<?php

App::uses('AppModel', 'Model');

/**
 * Description of BankAccountMaster
 *
 * @author vinay
 */
class BankAccountMaster extends AppModel {

    public $useTable = 'bank_account_master';
    public $primaryKey = 'serno';

    public function getAccounts($providerList) {
        $BankMaster = ClassRegistry::init("BankMaster");
        $banks = Set::combine($BankMaster->find('all', array('fields' => array('bankid', 'provider_id', 'bankname'), 'conditions' => array('provider_id' => array_keys($providerList)), 'order' => 'uiorder DESC')), "{n}.BankMaster.bankid", "{n}.BankMaster", "{n}.BankMaster.provider_id");
        $bankid = array();
        $bankname = array();
        foreach ($banks as $bankskey => $banksval) {
            foreach ($banksval as $key1 => $val1) {
                $bankid[$bankskey][$key1] = $val1['bankname'];
            }
        }
        return $bankid;
    }

    public function addAccounts($request) {
        if (!isset($request['provider']) || !isset($request['bank']) || !isset($request['account'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        if (!is_numeric($request['account'])) {
            throw new Exception("Bank Account Number Must Be Numeric");
        }
        $data = array();
        $data['provider_id'] = trim($request['provider']);
        $data['bankid'] = trim($request['bank']);
        $data['accountno'] = trim($request['account']);
        $data['status'] = 'Y';
        $data['offline_status'] = trim($request['offlinestatus']);
        if (!$this->saveAll($data)) {
            throw new Exception("Error !!! Account Has Not Been ADDED Properly.");
        }
        return true;
    }

    public function updateAccounts($request) {
        if (!isset($request['serno']) || !isset($request['changeStatus']) || !isset($request['newAccountNumber']) || !isset($request['changeOfflineStatus'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        if (!is_numeric($request['newAccountNumber'])) {
            throw new Exception("Bank Account Number Must Be Numeric");
        }
        if (!$this->updateAll(array('accountno' => "'" . $request['newAccountNumber'] . "'", 'offline_status' => "'" . $request['changeOfflineStatus'] . "'", 'status' => "'" . $request['changeStatus'] . "'"), array("serno" => $request["serno"]))) {
            throw new Exception("Account Details Has Not Been Updated .");
        }
        return true;
    }
    
    public function addEcollectAccounts($request) {
        if (!isset($request['bank']) || !isset($request['account'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        $data = array();
        $data['provider_id'] = trim($request['provider']);
        $data['bankid'] = trim($request['bank']);
        $data['accountno'] = trim($request['account']);
        $data['ifsc_code'] = trim($request['ifsc_code']);
        $data['status'] = 'Y';
        if (!$this->saveAll($data)) {
            throw new Exception("Error !!! Account Has Not Been ADDED Properly.");
        }
        return true;
    }

    public function updateEcollectAccounts($request) {
        if (!isset($request['serno']) || !isset($request['changeStatus']) || !isset($request['newAccountNumber'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        if (!$this->updateAll(array('accountno' => "'" . $request['newAccountNumber'] . "'", 'ifsc_code' => "'" . $request['newIfsc_Code'] . "'", 'status' => "'" . $request['changeStatus'] . "'"), array("serno" => $request["serno"]))) {
            throw new Exception("Account Details Has Not Been Updated .");
        }
        return true;
    }

    public function updateofflinerights($activerights, $inactiverights) {
        if ($activerights != '') {
            $eachaccountcode = explode(",", $activerights);
            for ($i = 0; $i < count($eachaccountcode); $i++) {
                $this->updateAll(
                        array('offline_status' => "'Y'"), array('accountno' => $eachaccountcode[$i])
                );
            }
        }
        if ($inactiverights != '') {
            $eachaccountcode = explode(",", $inactiverights);
            for ($i = 0; $i < count($eachaccountcode); $i++) {
                $this->updateAll(
                        array('offline_status' => "'N'"), array('accountno' => $eachaccountcode[$i])
                );
            }
        }
    }

    public function updateMultiAccounts($request, $proid) {

        if (!isset($request['updatedSerno_str'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        $updateProId = explode(",", $request['updatedSerno_str']);
        \CakeLog::write('sdsdsds', \var_export(array($proid, $request, $updateProId), true));
        if ($request['statusflag'] == 'ACCOUNT') {
            $this->updateAll(array('status' => "'N'"), array('provider_id' => $proid));
            $this->updateAll(array('status' => "'Y'"), array('serno' => $updateProId));
        } elseif ($request['statusflag'] == 'OFFLINE') {
            $this->updateAll(array('offline_status' => "'N'"), array('provider_id' => $proid));
            $this->updateAll(array('offline_status' => "'Y'"), array('serno' => $updateProId));
        } else {
            throw new Exception("Invalid Request. Please Try Again");
        }
        return true;
    }

}
