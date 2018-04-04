<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 1.2
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
App::uses('ComponentCollection', 'Controller');

/**
 * Base class for an individual Component. Components provide reusable bits of
 * controller logic that can be composed into a controller. Components also
 * provide request life-cycle callbacks for injecting logic at specific points.
 *
 * ## Life cycle callbacks
 *
 * Components can provide several callbacks that are fired at various stages of the request
 * cycle. The available callbacks are:
 *
 * - `initialize()` - Fired before the controller's beforeFilter method.
 * - `startup()` - Fired after the controller's beforeFilter method.
 * - `beforeRender()` - Fired before the view + layout are rendered.
 * - `shutdown()` - Fired after the action is complete and the view has been rendered
 *    but before Controller::afterFilter().
 * - `beforeRedirect()` - Fired before a redirect() is done.
 *
 * @package       Cake.Controller
 * @link          https://book.cakephp.org/2.0/en/controllers/components.html
 * @see Controller::$components
 */
class Component
        extends CakeObject {

    /**
     * Component collection class used to lazy load components.
     *
     * @var ComponentCollection
     */
    protected $_Collection;

    /**
     * Settings for this Component
     *
     * @var array
     */
    public $settings = array();

    /**
     * Other Components this component uses.
     *
     * @var array
     */
    public $components = array();

    /**
     * A component lookup table used to lazy load component objects.
     *
     * @var array
     */
    protected $_componentMap = array();

    /**
     * Api Response type detector objects.
     *
     * @var array
     */
    protected $_apiResponseType = array();

    /**
     * Constructor
     *
     * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
     * @param array $settings Array of configuration settings.
     */
    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->_Collection = $collection;
        $this->settings = $settings;
        $this->_set($settings);
        if (!empty($this->components)) {
            $this->_componentMap = ComponentCollection::normalizeObjectArray($this->components);
        }
    }

    /**
     * Magic method for lazy loading $components.
     *
     * @param string $name Name of component to get.
     * @return mixed A Component object or null.
     */
    public function __get($name) {
        if (isset($this->_componentMap[$name]) && !isset($this->{$name})) {
            $settings = (array) $this->_componentMap[$name]['settings'] + array('enabled' => false);
            $this->{$name} = $this->_Collection->load($this->_componentMap[$name]['class'], $settings);
        }
        if (isset($this->{$name})) {
            return $this->{$name};
        }
    }

    /**
     * Called before the Controller::beforeFilter().
     *
     * @param Controller $controller Controller with components to initialize
     * @return void
     * @link https://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
     */
    public function initialize(Controller $controller) {

    }

    /**
     * Called after the Controller::beforeFilter() and before the controller action
     *
     * @param Controller $controller Controller with components to startup
     * @return void
     * @link https://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
     */
    public function startup(Controller $controller) {
        if ($controller->httpApi) {
            $controller->httpApi = strtolower(is_array($controller->httpApi) ? reset($controller->httpApi) : $controller->httpApi);
            $controller->request->param('api', ucfirst($controller->httpApi));
            if (!in_array('RequestHandler', (array) $controller->components)) {
                return 0;
            }
            if (method_exists($controller, 'before' . ucfirst($controller->httpApi) . 'Request')) {
                $controller->{ 'before' . ucfirst($controller->httpApi) . 'Request'}();
            }
            if (method_exists($this, 'handle' . ucfirst($controller->httpApi) . 'Request')) {
                $this->{ 'handle' . ucfirst($controller->httpApi) . 'Request'}($controller);
            } else {
                throw new NotImplementedException(ucfirst($controller->httpApi) . ' API is not implemented.');
            }
            if (method_exists($controller, 'after' . ucfirst($controller->httpApi) . 'Request')) {
                $controller->{ 'after' . ucfirst($controller->httpApi) . 'Request'}();
            }
        }
    }

    /**
     * Respond to SOAP Call.
     */
    private function handleSoapRequest($controller) {
        $wsdl = ROOT . DS . 'xsd' . DS . strtolower($controller->name) . ".xsd";
        if (!file_exists($wsdl)) {
            header('HTTP/1.1 500 Internal Service Error');
            header("Content-type:application/xml");
            exit('<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Body><SOAP-ENV:Fault><faultcode>http</faultcode><faultstring>WSDL file not found. ' . (Configure::read('debug') > 0 ? $wsdl : '') . '</faultstring></SOAP-ENV:Fault></SOAP-ENV:Body></SOAP-ENV:Envelope>');
        }
        $server = new SoapServer($wsdl, array(
            "cache_wsdl" => WSDL_CACHE_NONE,
            "send_errors" => TRUE,
            "soap_version" => SOAP_1_2));
        $server->setClass($controller->name . "Controller");
        $server->handle();
        exit();
    }

    /**
     * Respond to REST Call.
     */
    private function handleRestRequest($controller) {
        $this->_apiResponseType = $controller->request->accepts();
        $this->_apiResponseType = array_intersect(array('application/json', 'application/xml'), array_merge((array) reset($this->_apiResponseType), (array) $controller->response->type($controller->request->param('ext'))));
        if (empty($this->_apiResponseType)) {
            $this->_apiResponseType = array_intersect(array('application/json', 'application/xml'), (array) $controller->request->contentType());
        }
        switch (reset($this->_apiResponseType)) {
            case 'application/json':
                $controller->viewClass = 'Json';
                break;
            case 'application/xml':
                $controller->viewClass = 'Xml';
                break;
            default : throw new UnauthorizedException('Invalid Accept Format', 406);
        }
        $controller->request->param('vc', ucfirst($controller->viewClass));
        if (!empty($controller->httpMethods)) {
            if (!in_array(env('REQUEST_METHOD'), array_map('strtoupper', (array) $controller->httpMethods))) {
                throw new MethodNotAllowedException('HTTP ' . env('REQUEST_METHOD') . ' Method is not allowded');
            }
        }
        if ($controller->request->accepts('application/jwt') || strtolower($controller->request->param('ext')) == "jwt") {
            if ($this->request->is('GET')) {
                $this->handleJwtrestRequestGET($controller);
            } else {
                $this->handleJwtrestRequest($controller);
            }
        }
    }

    /**
     * Respond to JWT Call.
     */
    private function handleJwtrestRequest($controller) {
        $controller->request->param('api', 'JwtRest');
        $token = $controller->request->data('token');
        \CakeLog::write('handleJwtrestRequest', \var_export($this->request->data, true));
        if (empty($token)) {
            throw new BadRequestException('JWT Token Not Found.');
        }
        if (empty($controller->jwt_key)) {
            throw new NotImplementedException('JWT Key Not Defiend.');
        }
        if (empty($controller->jwt_alg)) {
            throw new NotImplementedException('JWT algorithms Not Defined.');
        }
        try {
            App::uses('jwt', 'Utility');
            $controller->request->data = (array) jwt::decode($controller->request->data('token'), $controller->jwt_key, $controller->jwt_alg);
        } catch (Exception $ex) {
            throw (Configure::read('debug') > 0 ? $ex : new BadRequestException('Signature verification failed'));
        }
    }

    private function handleJwtrestRequestGET($controller) {
        $controller->request->param('api', 'JwtRest');
        $token = $controller->request->query('token');

        if (empty($token)) {
            throw new BadRequestException('JWT Token Not Found.');
        }
        if (empty($controller->jwt_key)) {
            throw new NotImplementedException('JWT Key Not Defiend.');
        }
        if (empty($controller->jwt_alg)) {
            throw new NotImplementedException('JWT algorithms Not Defined.');
        }
        try {
            App::uses('jwt', 'Utility');
            $controller->request->data = (array) jwt::decode($controller->request->query('token'), $controller->jwt_key, $controller->jwt_alg);
        } catch (Exception $ex) {
            throw (Configure::read('debug') > 0 ? $ex : new BadRequestException('Signature verification failed'));
        }
    }

    /**
     * Called before the Controller::beforeRender(), and before
     * the view class is loaded, and before Controller::render()
     *
     * @param Controller $controller Controller with components to beforeRender
     * @return void
     * @link https://book.cakephp.org/2.0/en/controllers/components.html#Component::beforeRender
     */
    public function beforeRender(Controller $controller) {

    }

    /**
     * Called after Controller::render() and before the output is printed to the browser.
     *
     * @param Controller $controller Controller with components to shutdown
     * @return void
     * @link https://book.cakephp.org/2.0/en/controllers/components.html#Component::shutdown
     */
    public function shutdown(Controller $controller) {

    }

    /**
     * Called before Controller::redirect(). Allows you to replace the URL that will
     * be redirected to with a new URL. The return of this method can either be an array or a string.
     *
     * If the return is an array and contains a 'url' key. You may also supply the following:
     *
     * - `status` The status code for the redirect
     * - `exit` Whether or not the redirect should exit.
     *
     * If your response is a string or an array that does not contain a 'url' key it will
     * be used as the new URL to redirect to.
     *
     * @param Controller $controller Controller with components to beforeRedirect
     * @param string|array $url Either the string or URL array that is being redirected to.
     * @param int $status The status code of the redirect
     * @param bool $exit Will the script exit.
     * @return array|null Either an array or null.
     * @link https://book.cakephp.org/2.0/en/controllers/components.html#Component::beforeRedirect
     */
    public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {

    }

}
