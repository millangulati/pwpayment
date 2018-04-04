<?php

App::uses('Controller', 'Controller');
App::uses('DateMethod', 'Lib');
App::uses('PwSpecialFun', 'Lib');

/**
 * Application Controller
 *
 * @author vinay
 */
class AppController extends Controller {

    public $components = array('RequestHandler');
    public $httpMethods = array();
    public $httpApi = false;

    public function beforeRender() {
//      $this->request->allowMethod(array('post', 'get'));
        if (!isset($this->response->data)):
            $this->response->data = array();
        endif;
        $this->requestLog();

        //$this->printSqlLog();
        parent::beforeRender();
    }

    public function requestLog() {
        $query = array();
        try {
            $request_str = \http_build_query(\array_merge((array) $this->request->query, (array) $this->request->data, (array) $this->request->params['pass']));
            \CakeLog::write('req_log', \var_export($this->request, true));
            \CakeLog::write('req_query', \var_export($this->request->query('token'), true));
            \CakeLog::write('req_params', \var_export($this->request->params['pass'], true));
            $query = array(
                'dateval' => date('Y-m-d H:i:s'),
                'service' => "NEW_BO",
                'url' => "https://" . \env('SERVER_NAME') . $this->request->here . "?remoteaddr=" . \env('REMOTE_ADDR') . '&' . $request_str,
            );
            CakeLog::write('request', var_export($query, true));
            //$this->loadModel('RequestLog');
            //$this->RequestLog->create();
            //$this->RequestLog->save($query);
        } catch (Exception $ex) {
            $query['error'] = $ex->getMessage();
            CakeLog::write('request_error', var_export($query, true));
        }
    }

    public function printSqlLog() {
        $sources = class_exists("ConnectionManager") ? ConnectionManager::sourceList() : array();
        foreach ($sources as $source) {
            $db = ConnectionManager::getDataSource($source);
            if (!method_exists($db, 'getLog')) {
                continue;
            }
            $dblog = $db->getLog();
            foreach ($dblog['log'] as $i) {
                CakeLog::write("Querry", $i['query']);
            }
        }
    }

}
