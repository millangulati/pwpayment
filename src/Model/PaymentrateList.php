<?php

class PaymentrateList extends AppModel {

    public $useTable = "st_payment_rate_list";
    public $primaryKey = "serno";

    function addUpdatePaymentRate($request) {
        if (!isset($request['subflag']) || empty($request['subflag']) || !isset($request['payment_mode']) || empty($request['payment_mode'])) {
            throw new Exception("Invalid Request. Please Try Again1");
        }

        if (empty($request['minslabamt']) || empty($request['maxslabamt']) || empty($request['ratedate']) || empty($request['tax']) || empty($request['amount']) || empty($request['app_type'])) {
            throw new Exception("Required Data Has Not Been Received Properly");
        }
        if ($request['minslabamt'] > $request['maxslabamt']) {
            throw new Exception("Minimum Amount Must Be Less Than Maximum Minimum Amount");
        }
        if ($request['payment_mode'] == 'cashinbank' || $request['payment_mode'] == 'netbanking' || $request['payment_mode'] == 'cheque') {
            if (empty($request['bank_name']) || empty($request['account_no'])) {
                throw new Exception("Required Data Has Not Been Received Properly");
            }
        }
        if ($request['payment_mode'] == 'olp') {
            if (empty($request['olpservice']) || empty($request['payment_type'])) {
                throw new Exception("Required Data Has Not Been Received Properly");
            }
        }
        if (empty($request['tax_amount'])) {
            throw new Exception("Tax Amount Field Is Empty");
        }
        if ($request['ratemode'] == 'A') {
            if ($request['tax'] == 'IN') {
                if ($request['tax_amount'] > $request['amount']) {
                    throw new Exception("Tax Amount Must Be Less Than Commission Amount");
                }
            }
        }
        $request['ratedate'] = DateMethod::ChangeDateFormat($request['ratedate'], "Y-m-d");
        if ($request['ratedate'] < date('Y-m-d')) {
            throw new Exception("Rate Date Should Be Greater Than Current Date");
        }
//        if (strtoupper($request['subflag']) == "ADD") {
        $fields = array('minslabamt', 'maxslabamt');
//            $conditions = array('payment_mode' => $request['payment_mode'], 'ratedate <=' => date('Y-m-d'), 'OR' => array('maxslabamt >=' => $request['maxslabamt'], 'maxslabamt >=' => $request['minslabamt'])/* ,'app_type'=>$request['app_type'] */);
        $conditions = array('payment_mode' => $request['payment_mode'], 'ratedate <=' => date('Y-m-d'), 'maxslabamt >=' => $request['minslabamt'], 'app_type' => $request['app_type']);

        if ($request['payment_mode'] == 'cashinbank' || $request['payment_mode'] == 'netbanking' || $request['payment_mode'] == 'cheque') {
            if (trim($request['bank_name']) != '*') {
                $conditions['bank_name'] = array($request['bank_name'], '*');
                if (trim($request['account_no']) != '*') {
                    $conditions['account_no'] = array($request['account_no'], '*');
                }
            }
        }
        if ($request['payment_mode'] == 'olp') {
            if (trim($request['olpservice']) != '*') {
                $conditions['ser_provider'] = array($request['olpservice'], '*');
                if (trim($request['payment_type']) != '*') {
                    $conditions['payment_type'] = array($request['payment_type'], '*');
                }
            }
        }
        $res = $this->find('all', array('fields' => $fields, 'conditions' => $conditions));
        if (count($res) > 0) {
            throw new Exception("Amount Slab Already Exists. Please Try Again With Another Slabs");
        }
        if (strtoupper($request['subflag']) == "ADD") {
            $this->addPaymentRate($request);
            return TRUE;
        }
        if (strtoupper($request['subflag']) == "UPDATE") {
            if (!isset($request['serno']) || is_null($request['serno']) || trim($request['serno']) == "")
                throw new Exception("Required Data Has Not Been Received Properly (Serial No).");
            else {
                $conditions = array("serno" => $request['serno'], "payment_mode" => $request['payment_mode']);
                $this->updatePaymentRates($request, $conditions);
                return TRUE;
            }
        }
    }

    function addPaymentRate($request) {
        try {
            $data = array();
            $request['ratedate'] = DateMethod::ChangeDateFormat($request['ratedate'], "Y-m-d");
            $data['payment_mode'] = trim($request['payment_mode']);
            $data['ratedate'] = trim($request['ratedate']);
            $data['ratemode'] = trim($request['ratemode']);
            $data['tax'] = trim($request['tax']);
            $data['tax_amount'] = trim($request['tax_amount']);
            $data['entrydate'] = trim(date('Y-m-d H:i:s'));
            $data['minslabamt'] = trim($request['minslabamt']);
            $data['maxslabamt'] = trim($request['maxslabamt']);
            $data['app_type'] = trim($request['app_type']);
            $data['amount'] = trim($request['amount']);
            if ($request['payment_mode'] == 'cashinbank' || $request['payment_mode'] == 'netbanking' || $request['payment_mode'] == 'cheque') {
                $data['bank_name'] = trim($request['bank_name']);
                $data['account_no'] = trim($request['account_no']);
            }
            if ($request['payment_mode'] == 'olp') {
                $data['ser_provider'] = trim($request['olpservice']);
                $data['payment_type'] = trim($request['payment_type']);
            }
            if (!$this->saveAll($data)) {
                throw new Exception("Error !!! Data Has Not Been ADDED Properly.");
            }
        } catch (Exception $ex) {
            throw new Exception("Error !!! Data Has Not Been ADDED Properly.");
        }
    }

    function updatePaymentRates($request, $conditions) {
        $date = date('Y-m-d H:i:s');
        $data = array();
        $request['ratedate'] = DateMethod::ChangeDateFormat($request['ratedate'], "Y-m-d");
        $data['payment_mode'] = '"' . trim($request['payment_mode']) . '"';
        $data['ratedate'] = '"' . trim($request['ratedate']) . '"';
        $data['ratemode'] = '"' . trim($request['ratemode']) . '"';
        $data['tax'] = '"' . trim($request['tax']) . '"';
        $data['entrydate'] = '"' . trim($date) . '"';
        $data['minslabamt'] = '"' . trim($request['minslabamt']) . '"';
        $data['maxslabamt'] = '"' . trim($request['maxslabamt']) . '"';
        $data['app_type'] = '"' . trim($request['app_type']) . '"';
        $data['amount'] = '"' . trim($request['amount']) . '"';
        $data['tax_amount'] = '"' . trim($request['tax_amount']) . '"';
        if ($request['payment_mode'] == 'cashinbank' || $request['payment_mode'] == 'netbanking' || $request['payment_mode'] == 'cheque') {
            $data['bank_name'] = '"' . trim($request['bank_name']) . '"';
            $data['account_no'] = '"' . trim($request['account_no']) . '"';
        }
        if ($request['payment_mode'] == 'olp') {
            $data['ser_provider'] = '"' . trim($request['olpservice']) . '"';
            $data['payment_type'] = '"' . trim($request['payment_type']) . '"';
        }

        try {
            $this->updateAll($data, $conditions);
            if (count($this->getAffectedRows()) <= 0) {
                throw new Exception("Error !!!Data Has Not Been Updated Properly.");
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function getRateListData() {
        try {

            $ProviderMaster = \ClassRegistry::init('ProviderMaster');
            $result['providerlist'] = $ProviderMaster->find('list', array('fields' => array('provider_id', 'name'), 'conditions' => array('status' => 'Y')));
            $PaymentrateList = \ClassRegistry::init('PaymentrateList');
            $result['ratelist'] = Set::combine($PaymentrateList->find('all', array('fields' => '*', 'conditions' => '')), "{n}.PaymentrateList.serno", "{n}.PaymentrateList", "{n}.PaymentrateList.mode_id");
            \CakeLog::write('resddsdsdultArr', \var_export($result['providerlist'], true));
            $this->loadModel('ModeMaster');
            $ModeMaster = \ClassRegistry::init('ModeMaster');
            $result['paymentMode'] = Set::combine($ModeMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.ModeMaster.name", "{n}.ModeMaster", "{n}.ModeMaster.type");

            $this->loadModel('BankMaster');
            $BankMaster = \ClassRegistry::init('BankMaster');
            $result['BankListName'] = $BankMaster->find('list', array("fields" => array("bankid", "bankname"), "conditions" => array('status' => 'Y'), "group" => ""));
            $BankMaster->virtualFields = array("bankidlist" => "GROUP_CONCAT(bankid)");
            $result['BankList'] = $BankMaster->find('list', array("fields" => array("provider_id", "bankidlist"), "conditions" => array('status' => 'Y'), "group" => "provider_id"));

            $this->loadModel('BankAccountMaster');
            $BankAccountMaster = \ClassRegistry::init('BankAccountMaster');
            $BankAccountMaster->virtualFields = array("accountnolist" => "GROUP_CONCAT(accountno)");
            $result['BankAccountlist'] = $BankAccountMaster->find('list', array("fields" => array("bankid", "accountnolist"), "conditions" => array('status' => 'Y'), "group" => "bankid"));
            \CakeLog::write('reeeee', \var_export($result, true));
            return $result;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}

?>
