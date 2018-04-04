<?php

App::uses('AppModel', 'Model');

/**
 * Description of BankMaster
 *
 * @author vinay
 */
class BankMaster extends AppModel {

    public $useTable = 'bank_master';
    public $primaryKey = 'bankid';

    public function updateBankOrder($Request) {
        if ($Request["orderProvider"] == '' || $Request["orderString"] == '') {
            throw new exception("Invalid Request Found.Please Try Again.");
        }
        $bankArr = explode(",", rtrim($Request['orderString'], ","));
        foreach ($bankArr as $key => $value) {
            $bankData = explode("##", $value);
            if (!$this->updateAll(array('uiorder' => "'" . $bankData[1] . "'"), array("bankid" => $bankData[0], "provider_id" => trim($Request["orderProvider"])))) {
                throw new Exception("Order Has Not Been Updated Successfully After Order Number :" . $bankData[1]);
            }
        }
        return true;
    }

    public function addNewBank($Request) {
        if ($Request["bankname"] == '' || $Request["orderProvider"] == '' || $Request["bankcode"] == '' || $Request["cmnBankName"] == '') {
            throw new exception("Invalid Request Found.Please Try Again.");
        }
        $data = array();
        if ($Request['filepath'] != '') {
            $data['logo'] = $Request["filepath"];
        }
        $data["provider_id"] = $Request["orderProvider"];
        $data["bankcode"] = $Request["bankcode"];
        $data["bankname"] = $Request["bankname"];
        $data["provider_bankcode"] = $Request["cmnBankName"];
        $data["status"] = "N";
        if (!$this->save($data)) {
            throw new Exception("Bank Has Not Been Created. Please Try Again[Bank Master]");
        }
        return true;
    }

    public function updateBankStatus($Request) {
        if ($Request["activeString"] == '') {
            throw new exception("Invalid Request Found.Please Try Again.");
        }
        $bankArr = explode(",", rtrim($Request['activeString'], ","));
        foreach ($bankArr as $key => $value) {
            $bankData = explode("##", $value);
            if (!$this->updateAll(array('status' => "'" . $bankData[1] . "'"), array("bankid" => $bankData[0]))) {
                throw new Exception("Status Has Not Been Updated Successfully After Bank Id  :" . $bankData[0]);
            }
        }
        return true;
    }

    public function updateBankDetails($Request) {
        try {
            if ($Request["bankname"] == '' || $Request["orderProvider"] == '' || $Request["bankcode"] == '') {
                throw new exception("Invalid Request Found.Please Try Again.");
            }
            $data = array();
            $data['bankcode'] = '"' . trim($Request['bankcode']) . '"';
            $data['bankname'] = '"' . trim($Request['bankname']) . '"';
            if ($Request['filepath'] != '') {
                $data['logo'] = '"' . trim($Request['filepath']) . '"';
            }
            $conditions = array();
            $conditions["bankid"] = $Request["updateId"];
            $conditions["provider_id"] = $Request["orderProvider"];
            $this->updateAll($data, $conditions);
            if (count($this->getAffectedRows()) <= 0) {
                throw new Exception("Error !!!Data Has Not Been Updated Properly.");
            } else {
                return true;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
//        if (!$this->updateAll(array('bankcode' => "'" . $Request['bankcode'] . "'", 'logo' => "'" . $logo . "'", 'bankname' => "'" . $Request['bankname'] . "'"), array("bankid" => $Request["updateId"], "provider_id" => trim($Request["orderProvider"])))) {
//            throw new Exception("Order Has Not Been Updated Successfully After Order Number :" . $bankData[1]);
//        }
//        return true;
    }

    public function getBankData() {

        $ProviderMaster = ClassRegistry::init("ProviderMaster");
        $exclude_provider_id = \Configure::read('CONSTANT_ExlProvider');
        $result['providerList'] = $ProviderMaster->find('list', array("conditions" => array('status' => 'Y', 'provider_id <>' => $exclude_provider_id)));
        $result['paymentMode'] = Set::combine($ProviderMaster->find('all', array("fields" => array('provider_id', 'name', 'type'), "conditions" => array(''))), "{n}.ProviderMaster.provider_id", "{n}.ProviderMaster", "{n}.ProviderMaster.type");
        $result['bankName'] = $this->find('list', array("conditions" => array(''), 'fields' => array('provider_bankcode', 'bankname')));
        $result['bankListProvider'] = Set::combine($this->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.BankMaster.provider_id", "{n}.BankMaster", "{n}.BankMaster.provider_bankcode");
        $result['bankList'] = Set::combine($this->find('all', array("fields" => '*', "conditions" => array(''), 'order' => 'uiorder')), "{n}.BankMaster.bankid", "{n}.BankMaster", "{n}.BankMaster.provider_id");
        return $result;
    }

}
