<?php

App::uses('AppController', 'Controller');
App::uses('Key', 'Vendor');

/**
 * CakePHP JwtController
 * @author vinay
 */
class JwtController
        extends AppController {

    public $ResponseArr = array();
    private static $username = 'test';
    private static $userpwd = 'test@123';
    public $httpApi = 'REST'; //REST|SOAP Type of API.
    public $httpMethods = array('POST', 'GET'); //GET|POST Not Required in SOAP.
    public $jwt_key = 'vinay_kuamr'; //Secreat shaired/rsa key to encode/decode in REST with JWT.
    public $jwt_alg = 'RS256'; // HS256|HS384|HS512|RS256|RS384|RS512 Required in REST with JWT Encreption/Decreption algo.<if in array first algo will be use for encoding/decoding data.>
//    private static $pub_key_file = 'cli_public_key.key'; // Client public key if jwt_algo is RSxxx.
    private static $pub_key_file = 'public_key.key'; // ankan.
    private static $pri_key_file = 'private_key.key'; // Server private key if jwt_algo is RSxxx.

    public function beforeRestRequest() {


        try {
            $is_rsa_algo = (isset($this->jwt_alg) && substr($this->jwt_alg, 0, 1) == 'R') ? true : false;
            if ($is_rsa_algo) {

                $this->jwt_key = Key::GetPublicKey(self::$pub_key_file, true);
            }
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function beforeRender() {

        $this->response->data = $this->ResponseArr;
        \CakeLog::write('authenticatehost', \var_export($this->response->data, true));
        parent::beforeRender();
        try {
            $is_rsa_algo = (isset($this->jwt_alg) && substr($this->jwt_alg, 0, 1) == 'R') ? true : false;
            if ($is_rsa_algo) {
                $this->jwt_key = Key::GetPrivateKey(self::$pri_key_file, true);
//                $this->jwt_key1 = Key::GetPrivateKey(self::$pri_key_file, true);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function invokeAction(CakeRequest $request) {

        try {
            $this->authenticateHost();
            parent::invokeAction($request);
        } catch (Exception $ex) {
            CakeLog::write('Error', var_export(array($request->data, $this->ResponseArr, $ex->getMessage(), $_SERVER), true));
            CakeLog::write('Errorrrrrrr', var_export(array($request->data, $this->ResponseArr, $ex->getMessage(), $_SERVER), true));
            throw new BadRequestException($ex->getMessage());
        }
    }

    private function authenticateHost() {

        if (!($this->request->accepts('application/jwt') || strtolower($this->request->param('ext')) == "jwt")) {
            throw new BadRequestException('Invalid Accept Format');
        }
        if (!in_array(env('REMOTE_ADDR'), array(env('REMOTE_ADDR')))) {
            throw new UnauthorizedException('IP not whitelisted.');
        }
        if (!is_null(env('HTTP_TOKEN'))) {
            $datetoken = md5(date('Ymd'));
            if (!strstr(env('HTTP_TOKEN'), $datetoken)) {
                throw new UnauthorizedException('Invalid Login Credentials.');
            }
            list($pass, $id) = explode($datetoken, env('HTTP_TOKEN'));
            if (md5(self::$userpwd) != $pass || self::$username != base64_decode($id)) {
                throw new UnauthorizedException('Invalid Login Credentials.');
            }
        } else {
            throw new UnauthorizedException('Authentication Token not found.');
        }
    }

    public function beforeFilter() {
        $this->ResponseArr['result'] = array('error' => "false", 'code' => '', 'msg' => '', 'data' => '');
        parent::beforeFilter();
    }

}
