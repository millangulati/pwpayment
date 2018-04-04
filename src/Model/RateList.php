<?php

class RateList
        extends AppModel {

    public $useTable = "rate_list";
    public $primaryKey = "serno";

    function addUpdatePaymentRate($request) {
        if (!isset($request['subflag']) || empty($request['subflag']) || !isset($request['mode_id']) || empty($request['mode_id']) || !isset($request['provider_id']) || empty($request['provider_id']) || empty($request['amt_frm']) || empty($request['amt_to']) || empty($request['rate_date']) || empty($request['gst_type']) || empty($request['amt_val']) || empty($request['app_type_id'])) {
            throw new Exception("Invalid Request. Please Try Again[Rate List]");
        }
        if ($request['mode_id'] != '1') {
            if (empty($request['bank_name'])) {
                throw new Exception("Bank has Not Been Received Properly.");
            }
            if ($request['payment_type'] == 'REQUEST') {
                if (empty($request['acnt_no'])) {
                    throw new Exception("account Number has Not Been Received Properly");
                }
            }
        }
        $request['rate_date'] = DateMethod::ChangeDateFormat($request['rate_date'], "Y-m-d");
        if ($request['rate_date'] < date('Y-m-d')) {
            throw new Exception("Rate Date Should Be Greater Than Current Date");
        }
        if (strtoupper($request['subflag']) == "UPDATE") {
            if (!isset($request['serno']) || is_null($request['serno']) || trim($request['serno']) == "") {
                throw new Exception("Required Data Has Not Been Received Properly (Serial No).");
            }
            $checkRecord = Set::extract('/RateList/.', $this->find('all', array('fields' => '*', 'conditions' => array('serno' => $request['serno']), 'limit' => 1)));
            if (trim($checkRecord[0]['mode_id']) != trim($request['mode_id'])) {
                throw new Exception("Invalid Request Found [Payment Mode]. ");
            }
            if ($checkRecord[0]['provider_id'] != $request['provider_id']) {
                throw new Exception("Invalid Request Found [Provider]. ");
            }
            if ($request['mode_id'] != '1') {
                if ($checkRecord[0]['bank_id'] != $request['bank_name']) {
                    throw new Exception("Invalid Request Found [Bank]. ");
                }
                if ($request['payment_type'] == 'REQUEST') {
                    if ($checkRecord[0]['account_no'] != $request['acnt_no']) {
                        throw new Exception("Invalid Request Found [Account]. ");
                    }
                }
            }
        }
        $fields = array('minslabamt', 'maxslabamt');
        $conditions = array('mode_id' => $request['mode_id'], 'ratedate' => $request['rate_date'], 'app_type' => $request['app_type_id'], 'provider_id' => $request['provider_id']);
        if ($request['mode_id'] != '1') {
            if (trim($request['bank_name']) != '*') {
                $conditions['bank_id'] = array($request['bank_name'], '*');
            }
            if ($request['payment_type'] == 'REQUEST') {
                if (trim($request['account_no']) != '*') {
                    $conditions['account_no'] = array($request['account_no'], '*');
                }
            }
        }
        if (strtoupper($request['subflag']) == "UPDATE") {
            $conditions['serno <>'] = $request['serno'];
        }
        $res = Set::extract('/RateList/.', $this->find('all', array('fields' => $fields, 'conditions' => $conditions)));
        $from = $request['amt_frm'];
        $to = $request['amt_to'];
        foreach ($res as $key => $value) {
            $Resfrom = $value['minslabamt'];
            $Resto = $value['maxslabamt'];
            if (($from >= $Resfrom && $from <= $Resto) || ($to >= $Resfrom && $to <= $Resto)) {
                throw new Exception("Amount Slab Already Exists.");
            } else if ($from <= $Resfrom && $to >= $Resto) {
                throw new Exception("Amount Slab Already Exists.");
            }
        }
        if (strtoupper($request['subflag']) == "ADD") {
            $this->addPaymentRate($request);
            return TRUE;
        }
        if (strtoupper($request['subflag']) == "UPDATE") {
            $conditions = array("serno" => $request['serno'], "mode_id" => $request['mode_id']);
            $this->updatePaymentRates($request, $conditions);
            return TRUE;
        }
    }

    function addPaymentRate($request) {
        try {
            $data = array();
            $request['rate_date'] = DateMethod::ChangeDateFormat($request['rate_date'], "Y-m-d");
            $data['mode_id'] = trim($request['mode_id']);
            $data['bank_id'] = trim($request['bank_name']);
            $data['ratedate'] = trim($request['rate_date']);
            $data['gst'] = trim($request['gst_type']);
            $data['ratemode'] = trim($request['rate_mode']);
            $data['entrydate'] = trim(date('Y-m-d H:i:s'));
            $data['minslabamt'] = trim($request['amt_frm']);
            $data['maxslabamt'] = trim($request['amt_to']);
            $data['app_type'] = trim($request['app_type_id']);
            $data['amount'] = trim($request['amt_val']);
            $data['provider_id'] = trim($request['provider_id']);
            if ($request['mode_id'] != '1') {
                $data['bank_id'] = trim($request['bank_name']);
                if ($request['payment_type'] == 'REQUEST') {
                    $data['account_no'] = $request['acnt_no'];
                }
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
        $request['rate_date'] = DateMethod::ChangeDateFormat($request['rate_date'], "Y-m-d");
        $data['mode_id'] = '"' . trim($request['mode_id']) . '"';
        $data['ratedate'] = '"' . trim($request['rate_date']) . '"';
        $data['ratemode'] = '"' . trim($request['rate_mode']) . '"';
        $data['gst'] = '"' . trim($request['gst_type']) . '"';
        $data['entrydate'] = '"' . trim($date) . '"';
        $data['minslabamt'] = '"' . trim($request['amt_frm']) . '"';
        $data['maxslabamt'] = '"' . trim($request['amt_to']) . '"';
        $data['app_type'] = '"' . trim($request['app_type_id']) . '"';
        $data['amount'] = '"' . trim($request['amt_val']) . '"';
        $data['provider_id'] = '"' . trim($request['provider_id']) . '"';

        if ($request['mode_id'] != '1') {
            $data['bank_id'] = '"' . trim($request['bank_name']) . '"';
            if ($request['payment_type'] == 'REQUEST') {
                $data['account_no'] = '"' . trim($request['acnt_no']) . '"';
            }
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
            $result['providerlist'] = Set::combine($ProviderMaster->find('all', array('fields' => array('provider_id', 'name', 'type'), 'conditions' => array('status' => 'Y'))), "{n}.ProviderMaster.name", "{n}.ProviderMaster", "{n}.ProviderMaster.type");
            //print_r($result['providerlist']);

            $result['ratelist'] = Set::combine($this->find('all', array("fields" => '*', "conditions" => '')), "{n}.RateList.serno", "{n}.RateList", "{n}.RateList.mode_id");
            $ModeMaster = \ClassRegistry::init('ModeMaster');
            $result['paymentMode'] = Set::combine($ModeMaster->find('all', array("fields" => '*', "conditions" => array(''))), "{n}.ModeMaster.name", "{n}.ModeMaster", "{n}.ModeMaster.type");

            $BankMaster = \ClassRegistry::init('BankMaster');
            $result['BankListName'] = $BankMaster->find('list', array("fields" => array("bankid", "bankname"), "conditions" => array(''), "group" => ""));
            $BankMaster->virtualFields = array("bankidlist" => "GROUP_CONCAT(bankid)");
            $result['BankList'] = $BankMaster->find('list', array("fields" => array("provider_id", "bankidlist"), "conditions" => array(''), "group" => "provider_id"));

            $BankAccountMaster = \ClassRegistry::init('BankAccountMaster');
            $BankAccountMaster->virtualFields = array("accountnolist" => "GROUP_CONCAT(accountno)");
            $result['BankAccountlist'] = $BankAccountMaster->find('list', array("fields" => array("bankid", "accountnolist"), "conditions" => array('status' => 'Y'), "group" => "bankid"));
            return $result;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getSearchedData($req_type, $modeData, $provider, $applicable_date) {

        try {
            $conditions = array(
                'mode_id' => $modeData,
                'provider_id' => $provider,
                'applicable_date' => $applicable_date,
                'charged_for' => 'PAYWORLD'
            );
            if ($provider == '1') { // cash in office
                $getRateData = Set::extract('/RateList/.', $this->find('all', array('conditions' => $conditions)));
            } else {
                $getRateData = Set::combine($this->find('all', array('conditions' => $conditions)), "{n}.RateList.serno", "{n}.RateList", "{n}.RateList.bank_id");
            }
            return $getRateData;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function saveRateData($data) {
        try {
            if (empty($data)) {
                throw new Exception("Something went wrong. Please try again later.");
            }
            $insert['mode_id'] = $data['selected_mode'];
            $insert['provider_id'] = $data['selected_provider'];
            $insert['applicable_date'] = date('Y-m-d', strtotime($data['selected_applicable_date']));
            if ($data['selected_provider'] == '1') { // cash in office
                if (isset($data['slab']['minamt'][0]) && $data['slab']['minamt'][0] != '' &&
                        isset($data['slab']['maxamt'][0]) && $data['slab']['maxamt'][0] != '' &&
                        isset($data['slab']['comm_mode'][0]) && $data['slab']['comm_mode'][0] != '' &&
                        isset($data['slab']['comm_amount'][0]) && $data['slab']['comm_amount'][0] != '' &&
                        isset($data['slab']['gst_tax'][0]) && $data['slab']['gst_tax'][0] != ''
                ) {
                    $i = 0;
                    foreach ($data['slab']['minamt'] as $rateD) {
                        $insert['minslabamt'] = $data['slab']['minamt'][$i];
                        $insert['maxslabamt'] = $data['slab']['maxamt'][$i];
                        $insert['comm_amount'] = $data['slab']['comm_amount'][$i];
                        $insert['gst'] = $data['slab']['gst_tax'][$i];
                        $insert['ratemode'] = $data['slab']['comm_mode'][$i];
                        $insert['charged_for'] = 'PAYWORLD';
                        $insert['entrydate'] = date('Y-m-d H:i:s');
                        $this->create();
                        $this->save($insert);
                        $i++;
                    }
                }
            } else {

                if (isset($data['slab']) && !empty($data['slab'])) {
                    //print_r($data['slab']);
                    foreach ($data['slab'] as $key => $value) {

                        $insert['bank_id'] = $key;
                        $i = 0;

                        foreach ($data['slab'][$key]['minamt'] as $rateD) {
                            if (isset($data['slab'][$key]['minamt'][0]) && $data['slab'][$key]['minamt'][0] != '' &&
                                    isset($data['slab'][$key]['maxamt'][0]) && $data['slab'][$key]['maxamt'][0] != '' &&
                                    isset($data['slab'][$key]['comm_mode'][0]) && $data['slab'][$key]['comm_mode'][0] != '' &&
                                    isset($data['slab'][$key]['comm_amount'][0]) && $data['slab'][$key]['comm_amount'][0] != '' &&
                                    isset($data['slab'][$key]['gst_tax'][0]) && $data['slab'][$key]['gst_tax'][0] != ''
                            ) {
                                $insert['minslabamt'] = $data['slab'][$key]['minamt'][$i];
                                $insert['maxslabamt'] = $data['slab'][$key]['maxamt'][$i];
                                $insert['comm_amount'] = $data['slab'][$key]['comm_amount'][$i];
                                $insert['gst'] = $data['slab'][$key]['gst_tax'][$i];
                                $insert['ratemode'] = $data['slab'][$key]['comm_mode'][$i];
                                $insert['charged_for'] = 'PAYWORLD';
                                $insert['entrydate'] = date('Y-m-d H:i:s');
                                $this->create();
                                $this->save($insert);
                                $i++;
                            }
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}

?>
