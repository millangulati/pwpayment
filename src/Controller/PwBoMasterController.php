<?php

App::uses('LoginController', 'Controller');
App::uses('Key', 'Vendor');
App::uses('jwt', 'Utility');

/**
 * CakePHP PwBoPaymentController
 *
 * @author millan
 *
 */
class PwBoMasterController
        extends LoginController {

    public function paymentTimeLimit() {
        try {
            $this->loadModel('ModeMaster');
            $this->loadModel('BranchMaster');
            $this->loadModel('PayReqTimeLimit');
            $this->ResponseArr['stateList'] = $this->BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
            $this->ResponseArr['paymentMode'] = $this->ModeMaster->find('list', array("fields" => array('mode_id', 'name'), "conditions" => array("status" => 'Y', "type" => "REQUEST")));
            if ($this->request->is('post') && isset($this->request->data['selectState'])) {
                $AddTime = $this->PayReqTimeLimit->AddTimeSlot($this->request->data, $this->ResponseArr['paymentMode']);
                if ($AddTime) {
                    $this->ResponseArr["SuccessMessage"] = "Slots Has Been Added.";
                }
            }
            $this->ResponseArr['timeLimitData'] = $this->PayReqTimeLimit->getTimeLimitDetail();
        } catch (Exception $ex) {
            $this->ResponseArr['timeLimitData'] = $this->PayReqTimeLimit->getTimeLimitDetail();
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function addPaymentBank() {
        try {
            $this->loadModel('BankMaster');
            $this->request->data['filepath'] = '';
            if ($this->request->is('post') && isset($this->request->data['flag']) && ($this->request->data['flag'] == 'ADD' || $this->request->data['flag'] == 'UPDATE') && ($this->request->data['uploadimage']['type'] != '')) {
                if ($this->request->data['uploadimage']["error"] > 0)
                    throw new Exception("Error In File Found: " . $this->request->data['uploadimage']["error"]);
                $allowedExts = array("jpg", "jpeg", "pjpeg", "png");
                $temp = explode(".", $this->request->data['uploadimage']["name"]);
                $extension = end($temp);
                $filepath = WWW_ROOT . "banklogo" . DS . date('dmYHis') . $temp[0] . "." . $extension;
                if (!in_array($extension, $allowedExts)) {
                    throw new Exception('Uploaded Logo Should be in JPEG/PJEPG/PNG Format');
                }
                if (file_exists(WWW_ROOT . "banklogo" . DS . date('dmYHis') . $temp[0] . "." . $extension)) {
                    throw new Exception('File Already Exists. Upload With Different Name.');
                }
                if ($this->request->data['uploadimage']['tmp_name'] == '' || $this->request->data['uploadimage']['type'] == '') {
                    throw new Exception('Invalid Document file');
                }
                if ($this->request->data['uploadimage']["size"] > 524288) {
                    throw new Exception("Maximum Allowed Size For Logo is 512 Kb.");
                }
                if (move_uploaded_file($this->request->data['uploadimage']["tmp_name"], $filepath)) {
                    $filepath = "/webroot/banklogo" . DS . date('dmYHis') . $temp[0] . "." . $extension;
                    $this->request->data['filepath'] = $filepath;
                } else {
                    throw new Exception("Unable To Upload Logo.");
                }
            }
            if ($this->request->is('post') && isset($this->request->data['flag']) && $this->request->data['flag'] == 'ORDER') {
                $this->ResponseArr['responseData'] = $this->request->data;
                $updatebankOrder = $this->BankMaster->updateBankOrder($this->request->data);
                if ($updatebankOrder) {
                    $this->ResponseArr["SuccessMessage"] = "Order Has Been Updated Successfully.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['flag']) && $this->request->data['flag'] == 'ADD') {
                $this->ResponseArr['responseData'] = $this->request->data;
                $addBank = $this->BankMaster->addNewBank($this->request->data);
                if ($addBank) {
                    $this->ResponseArr["SuccessMessage"] = "Bank Has Been Added.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['flag']) && $this->request->data['flag'] == 'ACTIVE') {
                $this->ResponseArr['responseData'] = $this->request->data;
                $activeBank = $this->BankMaster->updateBankStatus($this->request->data);
                if ($activeBank) {
                    $this->ResponseArr["SuccessMessage"] = " Bank Status Has been Updated.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['flag']) && $this->request->data['flag'] == 'UPDATE') {
                $this->ResponseArr['responseData'] = $this->request->data;
                $updatebank = $this->BankMaster->updateBankDetails($this->request->data);
                if ($updatebank) {
                    $this->ResponseArr["SuccessMessage"] = "Bank Detail Has Been Updated Successfully.";
                }
            }
            $this->ResponseArr['result'] = $this->BankMaster->getBankData();
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = $this->BankMaster->getBankData();
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function addPaymentAccounts() {
        try {
            $this->loadModel('ProviderMaster');
            $req_provider_id = \Configure::read('CONSTANT_PwBank');
            $this->ResponseArr['providerList'] = $this->ProviderMaster->find('list', array("fields" => array('provider_id', 'name'), "conditions" => array('status' => 'Y', 'provider_id' => '2')));
            $this->loadModel('BranchMaster');
            $this->loadModel('BankMaster');
            $this->loadModel('BankAccountMaster');
            $this->ResponseArr['bankName'] = $this->BankMaster->find('list', array("fields" => array('bankid', 'bankname'), "conditions" => array('provider_id' => $req_provider_id)));

            if ($this->request->is('post') && isset($this->request->data['bank']) && ($this->request->data['flag']) == 'ADD') {
                if (($this->request->data['bank'] == '') || ($this->request->data['account'] == '')) {
                    throw new Exception("Invalid Request. Please Try Again");
                }
                $addAccountData = $this->BankAccountMaster->addAccounts($this->request->data);
                if ($addAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Account Has Been Added.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['serno']) && ($this->request->data['flag']) == 'UPDATE') {
                if (($this->request->data['serno'] == '') || ($this->request->data['newAccountNumber'] == '') || ($this->request->data['changeStatus'] == '') || ($this->request->data['changeOfflineStatus'] == '')) {
                    throw new Exception("Invalid Request. Please Try Again1");
                }
                $updateAccountData = $this->BankAccountMaster->updateAccounts($this->request->data);
                if ($updateAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Account Has Been Updated.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['serno']) && ($this->request->data['flag']) == 'MULTIUPDATE') {

                $updatemultiAccountData = $this->BankAccountMaster->updateMultiAccounts($this->request->data, $req_provider_id);
                if ($updatemultiAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Accounts Has Been Updated.";
                }
            }
            $this->ResponseArr['banklist'] = $this->BankAccountMaster->getAccounts($this->ResponseArr['providerList']);
            $this->ResponseArr['accountList'] = Set::extract('/BankAccountMaster/.', $this->BankAccountMaster->find('all', array('fields' => '*', 'conditions' => array('provider_id' => $req_provider_id))));
        } catch (Exception $ex) {

            $this->ResponseArr['banklist'] = $this->BankAccountMaster->getAccounts($this->ResponseArr['providerList']);
            $this->ResponseArr['accountList'] = Set::extract('/BankAccountMaster/.', $this->BankAccountMaster->find('all', array('fields' => '*', 'conditions' => array('provider_id' => $req_provider_id))));
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function addEcollectPaymentAccounts() {
        try {
            $this->loadModel('ProviderMaster');
            $pwecollect_provider_id = \Configure::read('CONSTANT_PwEcollect');
            $this->ResponseArr['providerList'] = $this->ProviderMaster->find('list', array("fields" => array('provider_id', 'name'), "conditions" => array('status' => 'Y', 'provider_id' => $pwecollect_provider_id)));
            $this->loadModel('BranchMaster');
            $this->loadModel('BankMaster');
            $this->loadModel('BankAccountMaster');
            $this->ResponseArr['bankName'] = $this->BankMaster->find('list', array("fields" => array('bankid', 'bankname'), "conditions" => array('provider_id' => $pwecollect_provider_id)));


            if ($this->request->is('post') && isset($this->request->data['bank']) && ($this->request->data['flag']) == 'ADD') {
                if (($this->request->data['bank'] == '') || ($this->request->data['account'] == '')) {
                    throw new Exception("Invalid Request. Please Try Again");
                }
                $addAccountData = $this->BankAccountMaster->addEcollectAccounts($this->request->data);
                if ($addAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Account Has Been Added.";
                }
            }
            if ($this->request->is('post') && isset($this->request->data['serno']) && ($this->request->data['flag']) == 'UPDATE') {
                if (($this->request->data['serno'] == '') || ($this->request->data['newAccountNumber'] == '') || ($this->request->data['changeStatus'] == '')) {
                    throw new Exception("Invalid Request. Please Try Again");
                }
                $updateAccountData = $this->BankAccountMaster->updateEcollectAccounts($this->request->data);
                if ($updateAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Account Has Been Updated.";
                }
            }
            $this->ResponseArr['banklist'] = $this->BankAccountMaster->getAccounts($this->ResponseArr['providerList']);
            $this->ResponseArr['accountList'] = Set::extract('/BankAccountMaster/.', $this->BankAccountMaster->find('all', array('fields' => '*', 'conditions' => array('provider_id' => $pwecollect_provider_id))));
        } catch (Exception $ex) {

            $this->ResponseArr['banklist'] = $this->BankAccountMaster->getAccounts($this->ResponseArr['providerList']);
            $this->ResponseArr['accountList'] = Set::extract('/BankAccountMaster/.', $this->BankAccountMaster->find('all', array('fields' => '*', 'conditions' => array('provider_id' => $pwecollect_provider_id))));
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function mapAccountBranch() {
        try {
            $this->loadModel('BranchMaster');
            if (trim(strtoupper($this->Auth->user("logintype"))) == "HO") {
                $branchList = $this->BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
            } else {
                throw new Exception("You Don't Have Permission For This option.");
            }
            $this->ResponseArr['branchList'] = $branchList;
            $this->loadModel('BankMaster');
            $this->loadModel('BankAccountMaster');
            $this->loadModel('AccountBranchMapping');
            $this->ResponseArr['banklist'] = $this->BankMaster->find('list', array("conditions" => array('status' => 'Y', 'provider_id' => '2'), 'fields' => array('bankid', 'bankname')));
            $this->ResponseArr['accountList'] = Set::combine($this->BankAccountMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.BankAccountMaster.accountno", "{n}.BankAccountMaster", "{n}.BankAccountMaster.bankid");
            $this->ResponseArr['activeAccountList'] = Set::combine($this->AccountBranchMapping->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.AccountBranchMapping.branchid", "{n}.AccountBranchMapping", "{n}.AccountBranchMapping.accountno");
            if ($this->request->is('post') && isset($this->request->data['bankid'])) {
                if (($this->request->data['bankid'] == '') || ($this->request->data['activeString'] == '')) {
                    throw new Exception("Invalid Request. Please Try Again");
                }
                $this->loadModel('AccountBranchMapping');
                $mapAccountData = $this->AccountBranchMapping->mapAccounts($this->request->data);
                if ($mapAccountData) {
                    $this->ResponseArr["SuccessMessage"] = "Account Has Been Mapped With Branch.";
                }
            }
            $this->ResponseArr['mappedData'] = $this->AccountBranchMapping->getMappedBranch();
        } catch (Exception $ex) {
            $this->ResponseArr['mappedData'] = $this->AccountBranchMapping->getMappedBranch();
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function mapPaymentProvider() {
        try {

            $this->loadModel('BranchMaster');
            $this->ResponseArr['branchList'] = $this->BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
            $this->loadModel('ModeMaster');
            $this->ResponseArr['paymentMode'] = Set::combine($this->ModeMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.ModeMaster.name", "{n}.ModeMaster", "{n}.ModeMaster.type");
            $this->loadModel('ProviderMaster');
            $this->ResponseArr['providers'] = $this->ProviderMaster->find('list', array("conditions" => array('status' => 'Y')));
            $this->ResponseArr['providerMode'] = Set::combine($this->ProviderMaster->find('all', array("fields" => '*', "conditions" => array('status' => 'Y'))), "{n}.ProviderMaster.name", "{n}.ProviderMaster", "{n}.ProviderMaster.type");

            $this->loadModel('ProviderModeMap');
            if (isset($this->request->data['subflag'])) {
                $mappedData = $this->request->data['mapped_json'];
                $this->request->data['mappeddata'] = json_decode($mappedData, true);
                $this->ResponseArr['result1'] = $this->request->data;

                $mappedData = $this->ProviderModeMap->saveMappedBranch($this->request->data);
                $this->ResponseArr["SuccessMessage"] = "Bank Detail Has Been Updated Successfully.";
            }
            $this->ResponseArr['mappedData'] = $this->ProviderModeMap->getMappedBranch();
        } catch (Exception $ex) {
            $this->ResponseArr['mappedData'] = $this->ProviderModeMap->getMappedBranch();
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function paymentRateList() {
        $pwcashinoffice_provider_id = \Configure::read('CONSTANT_CASHINOFFICE');
        $pwcashinbank_provider_id = \Configure::read('CONSTANT_PwBank');

        $req_type = '';
        $getRateData = array();
        try {
            $this->loadModel('BranchMaster');
            $this->loadModel('ModeMaster');
            $this->loadModel('ProviderMaster');
            $this->loadModel('RateList');

            if ($this->request->is('post') && isset($this->request->data['submitflag'])) {
                $req_type = $this->request->data['submitflag']; // Request Type: REQUEST, PAYMENT, COLLECT
                $p_mode = $this->request->data['payment_mode']; // Mode: CashInOffice, CashInBank etc.
                $applicable_date = $this->request->data['applicable_date'];
                $applicable_date = $applicable_date != '' ? date('Y-m-d', strtotime($this->request->data['applicable_date'])) : '';
                $modeData = explode(",", $p_mode);
                $provider = $this->request->data['provider'];
                if (count($modeData) != 3) {
                    throw new Exception("Something went wrong. Please try again later.");
                }
                if ($req_type == 'REQUEST' && ($provider == $pwcashinoffice_provider_id || $provider == 'all_providers') && $modeData[0] == $pwcashinoffice_provider_id) {
                    $this->ResponseArr['showRateStructure'] = 'pwoffice';
                }
                if ($req_type == 'REQUEST' && ($provider == $pwcashinbank_provider_id || $provider == 'all_providers')) {
                    $this->ResponseArr['selectedProvider'] = $provider;
                    $this->ResponseArr['showRateStructure'] = 'pwbank';
                }
                $getRateData = $this->RateList->getSearchedData($req_type, $modeData[0], $provider, $applicable_date);
                $this->ResponseArr['getRateData'] = $getRateData;
            }

            if ($this->request->is('post') && isset($this->request->data['rateDataFlag']) && $this->request->data['rateDataFlag'] == 'saveRateData') {

                //pr($this->request->data);
                $submittedData = $this->request->data;
                $response = $this->RateList->saveRateData($submittedData);
                $this->ResponseArr["SuccessMessage"] = "Rate Data has been added successfully.";
            }

            $this->ResponseArr['request_type'] = $req_type;
            $this->ResponseArr['branchList'] = $this->BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
            $this->ResponseArr['paymentMode'] = Set::combine($this->ModeMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.ModeMaster.name", "{n}.ModeMaster", "{n}.ModeMaster.type");
//            $this->ResponseArr['providers'] = $this->ProviderMaster->find('list', array("conditions" => array('status' => 'Y')));
            $this->ResponseArr['providerMode'] = Set::combine($this->ProviderMaster->find('all', array("fields" => '*', "conditions" => array('status' => 'Y'))), "{n}.ProviderMaster.name", "{n}.ProviderMaster", "{n}.ProviderMaster.type");

            if (isset($this->request->data['subflag'])) {
                $this->ResponseArr['responseData'] = $this->request->data;
                $saveData = $this->RateList->addUpdatePaymentRate($this->request->data);
                if ($saveData) {
                    $this->ResponseArr["SuccessMessage"] = "Successfull.";
                }
            }
            $this->ResponseArr['result'] = $this->RateList->getRateListData();
        } catch (Exception $ex) {
            $this->ResponseArr['result'] = $this->RateList->getRateListData();
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function offlineGrantAccessRights() {
        $request_bank_provider_id = \Configure::read('CONSTANT_PwBank');
        $this->loadModel('BankMaster');
        $this->loadModel('BankAccountMaster');
        try {

            if ($this->request->is('post') && isset($this->request->data['offline_flag']) && ($this->request->data['offline_flag'] == 'actionsubmit')) {
                if (isset($this->request->data['hiddencheckedrights']) && isset($this->request->data['hiddenuncheckedrights'])) {
                    $activerights = $this->request->data['hiddencheckedrights'];
                    $inactiverights = $this->request->data['hiddenuncheckedrights'];
                    $updateData = $this->BankAccountMaster->updateofflinerights($activerights, $inactiverights);
                    $statusInformation = 'Information Updated Successfully.';
                    $this->ResponseArr["SuccessMessage"] = $statusInformation;
                } else if (isset($this->request->data['selectLoginName'])) {
                    $loginname = $this->request->data['selectLoginName'];
                }
            }

            $banklist = $this->BankMaster->find("list", array("fields" => array("bankid", "bankname"), 'conditions' => array('provider_id' => $request_bank_provider_id, 'status' => 'Y')));
            $this->BankMaster->setSource("account_branch_mapping");
            $accountconditions['status'] = 'Y'; //, 'branchid' => $this->Auth->user('branchid'));
            $conditions = '';
            if ($this->Auth->user('branchcode') != 'HO') {
                $conditions = array('pw_db_serno' => $this->Auth->user('db_serno'), 'pw_branch' => $this->Auth->user('branchcode'));
                $accountconditions['branchid'] = $this->Auth->user('branchid');
            }
            $banksAccountsList = $this->BankMaster->find("list", array("fields" => array("accountno", "bankid"), 'conditions' => $accountconditions));
            $banksAccounts = array();
            $offline_access = array();
            foreach ($banksAccountsList AS $account => $bank) {
                $banksAccounts[$bank][] = $account;
                $offlineAccounts = $this->BankAccountMaster->find("first", array("fields" => array("bankid", "accountno", "offline_status"), 'conditions' => array('accountno' => $account, 'status' => 'Y')));

                foreach ($offlineAccounts as $off) {
                    $offline_access[$bank][$account] = $off['offline_status'];
                }
            }

            $this->ResponseArr['banklist'] = $banklist;
            $this->ResponseArr['bankaccountlist'] = $banksAccounts;
            $this->ResponseArr['offlineAccounts'] = $offline_access;
        } catch (Exception $ex) {
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    function objToArray($obj, &$arr) {

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

    public function paymentMode() {
        try {
            $this->loadModel('BranchMaster');
            $this->ResponseArr['branchList'] = $this->BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
            $this->loadModel('ModeMaster');
            $this->ResponseArr['paymentMode'] = Set::combine($this->ModeMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.ModeMaster.name", "{n}.ModeMaster", "{n}.ModeMaster.type");
            $URL = 'http://172.20.2.37/userchanchal/JwtApi/new/PwPaymentEngine/saveMappedData.jwt';
            $jwt_pb_key = Key::GetPublicKey(self::$pub_key_file, true);
            $jwt_pr_key = Key::GetPrivateKey(self::$pri_key_file, true);
            $payload = array("name" => "ankanverma", "lastname" => "Verma");
            $jwttoken['token'] = jwt::encode($payload, array($jwt_pr_key, $jwt_pb_key), 'RS256');
            $result = $this->RestClient($URL, $jwttoken, array('token: ' . md5('test@123') . md5(date('Ymd')) . base64_encode('test')));
            $result11 = (array) jwt::decode($result['token'], $jwt_pb_key, 'RS256');
            $this->ResponseArr['res'] = $result11;
        } catch (Exception $ex) {
            \CakeLog::write('exception', \var_export($ex->getMessage(), true));
            $this->set('msg', $ex->getMessage());
        }
    }

    public function addPaymentCards() {
        try {
            $this->loadModel('CardMaster');
            $this->ResponseArr['cardList'] = Set::combine($this->CardMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.CardMaster.card_type", "{n}.CardMaster", "{n}.CardMaster.mode_id");
        } catch (Exception $ex) {
            $this->set('msg', $ex->getMessage());
        }
    }

}
