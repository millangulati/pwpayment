<?php

App::uses('AppController', 'Controller');
App::uses('Key', 'Vendor');
App::uses('jwt', 'Utility');

/**
 * CakePHP LoginController
 *
 * @author vinay
 *
 */
class LoginController
        extends AppController {

    public $uses = array('User');
    public $ResponseArr = array();
    public $theme = "Vinay";
    private static $pub_key_file = 'public_key.key';
    private static $pri_key_file = 'private_key.key';

    public function beforeFilter() {
        $defaultController = \Configure::read('masterController');
        parent::beforeFilter();
        $this->Session = $this->Components->load('Session');
        $this->Session->initialize($this);
        $this->Auth = $this->Components->load('Auth');
        $this->Auth->initialize($this);
        $this->Security = $this->Components->load('Security');
        $this->Security->initialize($this);
        $this->Security->csrfUseOnce = true;
        $this->Security->blackHoleCallback = "blackHole";
        $this->Security->csrfExpires = "+45 minutes";
        $this->Security->csrfLimit = 2;
        $this->Auth->allowedActions = array('reset', 'salt');
        $this->Security->unlockedActions = array('salt');
        $logintime = date("H:i:s");
        $this->Auth->authenticate = array(
            "Form" => array(
                "fields" => array("username" => "loginname", "password" => "password"),
                "userModel" => "User",
                "scope" => array("accessdays like" => '%' . date('w') . '%', "stime <=" => $logintime, "etime >" => $logintime, "loginquery" => "true")));
        $this->Auth->loginAction = array('controller' => $defaultController, 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => $defaultController, 'action' => 'home');
        $this->Auth->logoutRedirect = array('controller' => $defaultController, 'action' => 'login');
        $this->Auth->unauthorizedRedirect = array('controller' => $defaultController, 'action' => 'login');
        $this->Auth->authError = "Invalid Login Credentials Used.";
        if ($this->request->action == 'salt' && $this->request->isAll(array('post', 'ajax'))) {
            $this->httpApi = 'REST';
            $this->httpMethods = array('POST');
        }
        if (!(strtolower($this->request->controller) == strtolower($defaultController) && in_array($this->request->action, array('index', 'login', 'reset', 'salt')))) {
            if (!$this->Auth->loggedIn()) {
                $this->logout("Session Expired, Please Login To Continue...");
            }
            $this->validateAuthToken();
        }
    }

    public function beforeRender() {
        $this->response->data = $this->ResponseArr;
        $this->set('response', $this->ResponseArr);
        parent::beforeRender();
    }

    public function blackHole($type) {
        $message = (in_array(strtolower($type), array("csrf", "secure")) ? "Session Expired" : (strtolower($type) == "auth" ? "Authentication Failed" : $type));
        $this->logout($message . ", Please Login To Continue.");
    }

    public function validateAuthToken() {
        try {
            if (stripos(env("HTTP_REFERER"), "/login") === FALSE || ($this->request->action = "home" && $this->Auth->user("AuthToken") !== null)) {
                if ($this->Auth->user("AuthToken") !== null) {
                    $authVar = empty($this->request->data["AuthVar"]) ? '' : $this->request->data["AuthVar"];
                    $AuthToken = $this->Auth->user("AuthToken");
                    if (\Configure::read('disableRefresh') && (empty($authVar) || $authVar != $AuthToken)) {
                        throw new Exception("Authentication Failed, Invalid Token.");
                    }
                } else {
                    throw new Exception("Session Expired, Please Login To Continue.");
                }
            }
            $this->ResponseArr["AuthVar"] = md5(uniqid(rand(), true));
            CakeSession::write("Auth.User.AuthToken", $this->ResponseArr["AuthVar"]);
        } catch (Exception $e) {
            $this->logout($e->getMessage());
        }
    }

    public function index() {
        $this->redirect($this->Auth->logout());
    }

    public function login() {
        if ($this->request->is("post") && isset($this->request->data['loginname']) && CakeSession::check("TmpSess.salt")) {
            CakeSession::delete('Auth.User');
            $this->User->beforeLogin($this->request->data);
            if ($this->Auth->login()) {
                $this->User->afterLogin();
                $this->ResponseArr["authMessage"] = "";
                $this->redirect($this->Auth->loginRedirect);
            } else {
                $this->ResponseArr["authMessage"] = $this->Auth->authError;
            }
        }
        if (CakeSession::check("TmpSess.sessionError")) {
            $this->ResponseArr["authMessage"] = CakeSession::read("TmpSess.sessionError");
        }
        CakeSession::delete("TmpSess.sessionError");
        $this->render('/Login/login', 'login');
    }

    public function logout($message = '') {
        if (!empty($message)) {
            CakeSession::write("TmpSess.sessionError", $message);
        } else if ($this->request->action != "logout" && CakeSession::check("Auth.User") === false) {
            CakeSession::write("TmpSess.sessionError", "Session Expired, Please Login To Continue.");
        }
        if ($this->request->action == "logout") {
            CakeSession::delete("TmpSess.sessionError");
        }
        $this->redirect($this->Auth->logout());
    }

    /* public function changePasswd() {
      try {
      if (isset($this->request->data['oldpass']) && trim($this->request->data['oldpass']) != '') {
      PwSpecialFun::ValidatePram($this->request->data, array('oldpass' => 'ANS', 'newpass' => 'ANS', 'repass' => 'ANS'));
      $this->User->changePassword($this->request->data);
      $this->logout("Password updated successfully, Relogin...");
      }
      } catch (Exception $ex) {
      $this->ResponseArr['authMessage'] = $ex->getMessage();
      }
      $this->render('/Login/change_passwd', 'login');
      } */

    public function reset() {
        try {
            if ($this->request->is('POST') && isset($this->request->data['login'])) {
                PwSpecialFun::ValidatePram($this->request->data, array('login' => 'AN'));
                PwSpecialFun::ValidateOptional($this->request->data, array('mno' => 'MNO', 'emailid' => 'EMAIL'));
                $this->User->resetPassword($this->request->data);
                $this->logout("Your password reset request has been accepted, You will receive new password on your registered email ID.");
            }
        } catch (Exception $ex) {
            $this->ResponseArr['authMessage'] = $ex->getMessage();
        }
        $this->render('/Login/reset_password', 'login');
    }

    public function home($render = true) {
        if ($this->User->isPasswordExpired()) {
            $this->ResponseArr['authMessage'] = "Your password has expired, Kindly change it.";
            $this->ChangePasswd();
        } else if ($render) {
            $this->loadModel('ModeMaster');
            $total_agent_count_mode_type = $this->ModeMaster->getTypeModeCount('AGENT');
            $total_retailer_count_mode_type = $this->ModeMaster->getTypeModeCount('RETAILER');
            $agent_request_mode_graph = $this->ModeMaster->getGraphModeAmt('REQUEST', 'AGENT');
            $retailer_request_mode_graph = $this->ModeMaster->getGraphModeAmt('REQUEST', 'RETAILER');
            $agent_olp_mode_graph = $this->ModeMaster->getGraphModeAmt('PAYMENT', 'AGENT');
            $retailer_olp_mode_graph = $this->ModeMaster->getGraphModeAmt('PAYMENT', 'RETAILER');
            $agent_ecollect_mode_graph = $this->ModeMaster->getGraphModeAmt('COLLECT', 'AGENT');
            $retailer_ecollect_mode_graph = $this->ModeMaster->getGraphModeAmt('COLLECT', 'RETAILER');

            $this->ResponseArr['total_agent_count_mode_type'] = $total_agent_count_mode_type;
            $this->ResponseArr['total_retailer_count_mode_type'] = $total_retailer_count_mode_type;
            $this->ResponseArr['agent_request_mode_graph'] = $agent_request_mode_graph;
            $this->ResponseArr['retailer_request_mode_graph'] = $retailer_request_mode_graph;
            $this->ResponseArr['agent_olp_mode_graph'] = $agent_olp_mode_graph;
            $this->ResponseArr['retailer_olp_mode_graph'] = $retailer_olp_mode_graph;
            $this->ResponseArr['agent_ecollect_mode_graph'] = $agent_ecollect_mode_graph;
            $this->ResponseArr['retailer_ecollect_mode_graph'] = $retailer_ecollect_mode_graph;
            $this->render('/Login/home');
        }
    }

    public function salt() {
        if ($this->request->isAll(array('post', 'ajax'))) {
            try {
                $salt = PwSpecialFun::GeneratePasswd(rand(12, 32), 'ANSA');
                CakeSession::write("TmpSess.salt", $salt);
                $this->ResponseArr['skey'] = $salt;
            } catch (Exception $ex) {
                $this->ResponseArr = array('error' => true, 'code' => 400, 'message' => $ex->getMessage());
            }
        } else {
            $this->logout();
        }
    }

    public function getAllState() {
        $state = array($this->Auth->user('db_serno') => $this->Auth->user('state'));
        if ($this->Auth->user('state') == 'HO') {
            $this->loadModel('DbMaster');
            $state = array('*' => 'ALL');
            $state += $this->DbMaster->find('list', array('fields' => array('serno', 'state'), 'conditions' => array('status >=' => 1, 'brand' => 'pw'), 'order' => 'state'));
        }
        $this->ResponseArr['state'] = $state;
    }

    public function RestClient($URL, $payload = array(), $header = array()) {

        if (is_null($URL) || trim($URL) == '' || !preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $URL)) {
            throw new Exception('Invalid Url.');
        }
        $curlheader = array('content-type: application/json', 'accept: application/json');
        if (is_array($header) && count($header) > 0) {
            $curlheader = array_merge($curlheader, $header);
        }
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $URL);
        curl_setopt($handle, CURLOPT_HEADER, TRUE);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $curlheader);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLINFO_HEADER_OUT, FALSE);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        $payload = json_encode($payload);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
        $curl_response = curl_exec($handle);
        $resArr = explode("\r\n\r\n", $curl_response);
        \CakeLog::write('resArr', \var_export($resArr, true));
        return json_decode($resArr[count($resArr) - 1], TRUE);
    }

    public function jwtApiCall($methodName, $params) {
        try {
            //echo $URL = Configure::read('CONST_PW_API_URL') . $methodName;
            $URL = Configure::read('CONST_PW_API_URL') . 'PwPaymentEngine/getAgentList.jwt';
            \CakeLog::write('URL1', \var_export(self::$pub_key_file, true));
            $jwt_pb_key = Key::GetPublicKey(self::$pub_key_file, true);
            $jwt_pr_key = Key::GetPrivateKey(self::$pri_key_file, true);
            \CakeLog::write('URL1', \var_export(array($jwt_pb_key, $jwt_pr_key), true));
            $jwttoken['token'] = jwt::encode($params, array($jwt_pr_key, $jwt_pb_key), 'RS256');
            \CakeLog::write('token', \var_export($jwttoken['token'], true));
            $token = $this->RestClient($URL, $jwttoken, array('token: ' . md5('test@123') . md5(date('Ymd')) . base64_encode('test')));
            $responseObj = (array) jwt::decode($token['token'], $jwt_pb_key, 'RS256');
            \CakeLog::write('responseObj', \var_export($responseObj, true));
            return $this->objToArray($responseObj, $arr);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function objToArray($obj, &$arr) {

        if (!is_object($obj) && !is_array($obj)) {
            $arr = $obj;
            return $arr;
        }

        foreach ($obj as $key => $value) {
            if (!empty($value)) {
                $arr[$key] = array();
                $this->objToArray($value, $arr[$key]);
            } else {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

}
