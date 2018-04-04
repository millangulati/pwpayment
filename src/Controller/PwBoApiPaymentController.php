<?php

//App::uses('LoginController', 'Controller');
App::uses('JwtController', 'Controller');
//App::uses('Key', 'Vendor');
//App::uses('jwt', 'Utility');

/**
 * CakePHP PwBoPaymentController
 *
 * @author vinay
 *
 */
class PwBoApiPaymentController extends JwtController {
//    private static $pub_key_file = 'public_key.key';
//    private static $pri_key_file = 'private_key.key';

    /**
     * API to get active Modes with branch information
     *
     * @params "request_from" => 'APOS', "request_type" => 'request', "provider_id" => '2', "db_serno" => ''state_code // 5-delhi', "branchcode" => 'B01'
     * @result array in JSON FORMAT of mapped payment modes e.g. Cashinbank,cheque etc
     * @throws Exception when any of ValidatePram function parameter is NULL
     */
    public function getModes() {
        try {
            $request = $this->request->data;
            PwSpecialFun::ValidatePram($request, array('request_from' => 'A', 'provider_id' => 'N', 'db_serno' => 'N', 'branchcode' => 'AN'));
            $this->loadModel('BranchMaster');
            $branchid = $this->BranchMaster->field('branchid', array('pw_db_serno' => $request['db_serno'], 'pw_branch' => $request['branchcode']));
            if ($branchid == '') {
                throw new Exception("Invalid Request[Branch]. Please Try Again");
            }
            $this->loadModel('ModeMaster');
            //            $paymentModeList = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('type' => strtoupper($request['request_type']), 'status' => 'Y')));
            $this->loadModel('ProviderModeMap');
            $paymentModeList = $this->ProviderModeMap->find('list', array('fields' => array('mode_id'), 'conditions' => array('provider_id' => strtoupper($request['provider_id']), 'status' => 'Y', 'branchid' => strtoupper($branchid))));
            if (!empty($paymentModeList)) {

                $paymentModeListName = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('mode_id' => $paymentModeList)));
                $this->ResponseArr['result']['data'] = $paymentModeListName;
            } else {
                $this->ResponseArr['result']['msg'] = 'No Record Found';
            }
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = array('error' => "true", 'code' => $ex->getCode(), 'msg' => $ex->getMessage(), 'data' => '');
        }
    }

    /**
     * API to get all the active banks based on requested provider ID
     * @params "request_from" => 'APOS', "provider_id" => '2'
     * @result array in JSON FORMAT of all active banks of requested provider ID
     * @throws Exception when any of ValidatePram function parameter is NULL
     *
     */
    public function getBanks() {
        try {
            $request = $this->request->data;
            PwSpecialFun::ValidatePram($request, array('request_from' => 'A', 'provider_id' => 'N'));
            $this->loadModel('BankMaster');
            $banklist = $this->BankMaster->find("list", array("fields" => array("bankid", "bankname"), 'conditions' => array('provider_id' => $request['provider_id'], 'status' => 'Y')));
            if (!empty($banklist)) {
                $this->ResponseArr['result']['data'] = $banklist;
            } else {
                $this->ResponseArr['result']['msg'] = 'No Record Found';
            }
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = array('error' => "true", 'code' => $ex->getCode(), 'msg' => $ex->getMessage(), 'data' => '');
        }
    }

    /**
     * API to get all active bank accounts and their associated account numbers based on requested parameters
     * @params "request_from" => 'APOS', "provider_id" => '2', "db_serno" => ''state_code // 5-delhi', "branchcode" => 'B01'
     * @result array in JSON FORMAT of all active banks and account numbers of requested paramters
     * @throws Exception when any of ValidatePram function parameter is NULL
     */
    public function getBankAccounts() {
        try {
            $request = $this->request->data;
            PwSpecialFun::ValidatePram($request, array('request_from' => 'A', 'provider_id' => 'N', 'db_serno' => 'N', 'branchcode' => 'AN'));
            $this->loadModel('AccountBranchMapping');
            $this->loadModel('BranchMaster');
            $branchid = $this->BranchMaster->field('branchid', array('pw_db_serno' => $request['db_serno'], 'pw_branch' => $request['branchcode']));
            if ($branchid == '') {
                throw new Exception("Invalid Request[Branch]. Please Try Again");
            }
            $aqccountList = Set::combine($this->AccountBranchMapping->find("all", array("fields" => array("bankid", "accountno", "status"), 'conditions' => array('branchid' => $branchid, 'status' => 'Y'))), "{n}.AccountBranchMapping.accountno", "{n}.AccountBranchMapping", "{n}.AccountBranchMapping.bankid");
            if (!empty($aqccountList)) {
                $this->ResponseArr['result']['data'] = $aqccountList;
            } else {
                $this->ResponseArr['result']['msg'] = 'No Record Found';
            }
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = array('error' => "true", 'code' => $ex->getCode(), 'msg' => $ex->getMessage(), 'data' => '');
        }
    }

    /**
     * API to get all active bank accounts and their associated account numbers based on requested parameters
     * @params "request_from" => 'APOS', "provider_id" => '2', "db_serno" => ''state_code // 5-delhi', "branchcode" => 'B01'
     * @result array in JSON FORMAT of all active banks and account numbers of requested paramters
     * @throws Exception when any of ValidatePram function parameter is NULL
     */
    public function savePaymentRequest() {
        try {
            $this->loadModel("BankMaster");
            $request = $this->request->data;
            \CakeLog::write('rereer', \var_export($request, true));
            PwSpecialFun::ValidatePram($request, array('request_for' => 'A', 'narration' => 'ANS', 'mode_id' => 'N', 'requested_panel' => 'A', 'amount' => 'F', 'provider_id' => 'N', 'db_serno' => 'N', 'branchcode' => 'AN', 'request_usercode' => 'AN', 'request_username' => 'AN'));
            if ($request['request_for'] == 'AGENT') {
                PwSpecialFun::ValidatePram($request, array('countercode' => 'AN', 'counter_agentcode' => 'AN'));
            } elseif ($request['request_for'] == 'RETAILER') {
                PwSpecialFun::ValidatePram($request, array('countercode' => 'AN', 'counter_agentcode' => 'AN'));
            } elseif ($request['request_for'] == 'API') {
                PwSpecialFun::ValidatePram($request, array('dstbtr_code' => 'AN'));
            } else {
                throw new Exception("Invalid Request. Please Try Again.");
            }
            $this->loadModel('BranchMaster');
            $branchid = $this->BranchMaster->field('branchid', array('pw_db_serno' => $request['db_serno'], 'pw_branch' => $request['branchcode']));
            $request['branchid'] = $branchid;
            if ($branchid == '') {
                throw new Exception("Branch Not Exist. Please Try Again");
            }
            if ($request['mode_id'] != '1') {
                PwSpecialFun::ValidatePram($request, array('bank_account_no' => 'N', 'bankid' => 'N', 'deposit_date' => 'D'));
            }
            if ($request['mode_id'] == '3') {
                PwSpecialFun::ValidatePram($request, array('chequeno' => 'AN', 'chequedate' => 'D'));
            }
            if ($request['mode_id'] == '4' || $request['mode_id'] == '9') {
                PwSpecialFun::ValidatePram($request, array('bank_ref_number' => 'AN'));
            }
            $this->loadModel('PaymentRequest');
            $response = $this->PaymentRequest->savePaymentRequest($request);
            if (!empty($response)) {
                $this->ResponseArr['result']['data']['receiptno'] = $response;
            } else {
                throw new Exception('Request Not Saved.');
            }
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = array('error' => "true", 'code' => $ex->getCode(), 'msg' => $ex->getMessage(), 'data' => '');
        }
    }

    public function getAllModes() {
        try {
            $request = $this->request->data;
            PwSpecialFun::ValidatePram($request, array('request_from' => 'A', 'provider_id' => 'N', 'db_serno' => 'N', 'branchcode' => 'AN'));
            $this->loadModel('BranchMaster');
            $branchid = $this->BranchMaster->field('branchid', array('pw_db_serno' => $request['db_serno'], 'pw_branch' => $request['branchcode']));
            if ($branchid == '') {
                throw new Exception("Invalid Request[Branch]. Please Try Again");
            }
            $this->loadModel('ModeMaster');
            $this->loadModel('ProviderModeMap');
            $paymentModeList = Set::extract('/ProviderModeMap/.', $this->ProviderModeMap->find('all', array('fields' => array('mode_id', 'provider_id'), 'conditions' => array('status' => 'Y', 'branchid' => strtoupper($branchid)))));
//            $paymentModeList = Set::combine($this->ProviderModeMap->find('all', array('fields' => array('mode_id', 'provider_id'), 'conditions' => array('status' => 'Y', 'branchid' => strtoupper($branchid)))), "{n}.ProviderModeMap.mode_id", "{n}.ProviderModeMap", "{n}.ProviderModeMap.provider_id");
            if (!empty($paymentModeList)) {
                $modeList = array();
                $paymentModeListName = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array()));
                foreach ($paymentModeList as $key => $value) {
                    $modeList[$value['provider_id']][$value['mode_id']] = $paymentModeListName[$value['mode_id']];
                }

                $this->ResponseArr['result']['data'] = $modeList;
            } else {
                $this->ResponseArr['result']['msg'] = 'No Record Found';
            }
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = array('error' => "true", 'code' => $ex->getCode(), 'msg' => $ex->getMessage(), 'data' => '');
        }
    }

}
