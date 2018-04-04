<?php

App::uses('LoginController', 'Controller');

//App::uses('Key', 'Vendor');
//App::uses('jwt', 'Utility');

class GetJsonController extends LoginController {

    public $httpApi = 'REST';
    private static $pw_user = 'test';
    private static $pw_pass = 'test@123';
    private static $pw_url = 'http://172.20.2.37/PayApi/Pw/';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->csrfUseOnce = FALSE;
        $this->Security->unlockedActions = array($this->request->action);
    }

    public function afterFilter() {
        parent::afterFilter();
        $this->ResponseArr['AuthVar'] = $this->request->data['AuthVar'];
        $this->Session->write("Auth.User.AuthToken", $this->request->data['AuthVar']);
    }

    public function beforeRender() {
        if (!isset($this->ResponseArr["tag"])) {
            $this->ResponseArr["tag"] = "#SUCCESS:";
        }
        parent::beforeRender();
    }

    public function getTimeListData() {
        try {
            $this->loadModel('PayReqTimeLimit');
            $result = $this->PayReqTimeLimit->getTimeList($this->request->data['dbser']);
            $this->ResponseArr['data'] = $result;
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

    public function updateArrayData() {
        try {
            $oldRecord = $this->request->data['str'];
            $oldArr = json_decode($oldRecord, true);
            $newArr = array();
            if (!empty($oldArr)) {
                foreach ($oldArr as $key => $value) {
                    if (!empty($value)) {
                        foreach ($value as $key1 => $value1) {
                            if (!empty($value1)) {
                                foreach ($value1 as $key2 => $value2) {
                                    $newArr[$key][$key2][$key1] = $value2;
                                }
                            }
                        }
                    }
                }
            }
            $this->ResponseArr['data'] = json_encode($newArr);
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

    public function addUpdatePaymentRateData() {
        try {
            $this->loadModel("PaymentrateList");
            $result = $this->PaymentrateList->addUpdatePaymentRate($this->request->data);
            if (!$result)
                throw new Exception('#ERROR:Please Try Again');
        } catch (Exception $ex) {
            $this->AjaxResponse["tag"] = $ex->getMessage();
        }
    }

    public function paymentRateListData() {
        try {
            if ($this->request->data['payment_mode'] != "") {
                $this->loadModel('PaymentrateList');
                $result = Set::extract('/PaymentrateList/.', $this->PaymentrateList->find('all', array('fields' => '*', 'conditions' => array('payment_mode' => $this->request->data['payment_mode']))));
                if (count($result) > 0)
                    $this->AjaxResponse['data'] = $result;
                else
                    $this->AjaxResponse["tag"] = '#ERROR:No Record Found';
            }
        } catch (Exception $ex) {
            $this->AjaxResponse["tag"] = $ex->getMessage();
        }
    }

    public function CheckLogin() {
        try {
            $this->loadModel("UserMaster");
            $data = $this->UserMaster->find("list", array("fields" => array("usercode", "loginname"), "conditions" => array("loginname" => $this->request->data['loginname'])));
            \CakeLog::write('datad', \var_export(array($data, $this->request->data), true));
            if (count($data) > 0) {
                $this->ResponseArr['data'] = "TRUE";
            } else {
                $this->ResponseArr['data'] = "FALSE";
            }
        } catch (Exception $ex) {
            $this->ResponseArr['data'] = $ex->getMessage();
        }
    }

    public function getStatementData() {
        try {
            $statementids = $this->request->data['statementids'];
            $statementids = explode(",", $statementids);
            $serno = $this->request->data['serno'];
            $this->loadModel('BankStatementsData');
            $result = $this->BankStatementsData->find('all', array('conditions' => array('serno' => $statementids)));
            $this->ResponseArr['data'] = $result;
            $this->ResponseArr['serno'] = $serno;
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

    public function authorise() {
        try {
            $this->loadModel('BankStatementsData');
            $this->loadModel('PaymentRequest');
            $payment_ser_no = $this->request->data['serno'];
            $statement_no = $this->request->data['statement_no'];
            $authcode = $this->request->data['authcode'];
            $entered_rs = json_decode($this->request->data['entered_rs']);
            $requestType = $this->request->data['requestType'];
            $validate_ids = $this->validate_entered_data($entered_rs, $requestType);

            //if (in_array($payment_ser_no, $validate_ids)) {
            $isvalid = false;
            foreach ($validate_ids as $key => $value) {
                if ($payment_ser_no == $key) {
                    $isvalid = true;
                }
            }

            if ($isvalid) {
                if ($statement_no == '' || $statement_no == '0') {
                    $statement_no = '';
                } else {
                    if (!in_array($statement_no, $validate_ids[$payment_ser_no]))
                        throw new Exception("#ERROR:");
                }
                if ($statement_no != '' && $statement_no != '0') {
                    $this->BankStatementsData->updateAll(
                            array('flag_auth' => "'Y'", 'auth_date' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $statement_no)
                    );
                }
                if ($payment_ser_no != '' && $payment_ser_no != '0') {
                    $this->PaymentRequest->updateAll(
                            array('status' => "'AUTHENTICATED'", 'statement_no' => "'" . $statement_no . "'", 'auth_usercode' => "'" . $authcode . "'", 'auth_time' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $payment_ser_no)
                    );
                }
                $result = $payment_ser_no;
                $this->ResponseArr['data'] = $result;
            } else {

                throw new Exception("#ERROR:");
            }
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

    public function grant() {
        try {
            $this->loadModel('BankStatementsData');
            $this->loadModel('PaymentRequest');
            $this->loadModel('Transactions');
            $payment_ser_no = $this->request->data['serno'];
            $statement_no = $this->request->data['statement_no'];
            $authcode = $this->request->data['authcode'];
            $entered_rs = json_decode($this->request->data['entered_rs']);
            $requestType = $this->request->data['requestType'];
            $validate_ids = $this->validate_entered_data($entered_rs, $requestType);
            $isvalid = false;
            foreach ($validate_ids as $key => $value) {
                if ($payment_ser_no == $key) {
                    $isvalid = true;
                }
            }
            if ($isvalid) {
                if ($statement_no == '' || $statement_no == '0') {
                    $statement_no = '';
                } else {
                    if (!in_array($statement_no, $validate_ids[$payment_ser_no]))
                        throw new Exception("#ERROR: Something Went Wrong! Please Try Again.");
                }
                if ($statement_no != '' && $statement_no != '0') {
                    $this->BankStatementsData->updateAll(
                            array('flag_grant' => "'Y'", 'grant_date' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $statement_no)
                    );
                }
                if ($payment_ser_no != '' && $payment_ser_no != '0') {
                    $requestdata = $this->PaymentRequest->find('first', array('conditions' => array('serno' => $payment_ser_no)));
                    \CakeLog::write('11requestdata', \var_export($requestdata, true));

                    if (empty($requestdata)) {
                        throw new Exception("#ERROR: Invalid Request. Please Try Again.");
                    }
                    $requestdata1 = $requestdata['PaymentRequest'];
                    //api call ankan
                    $params = array("agentcode" => $requestdata1['countercode'],
                        "narration" => $requestdata1['narration'],
                        "amount" => $requestdata1['amount'],
                        "requestType" => $requestType
                    );
                    \CakeLog::write('params', \var_export($params, true));
                    $response = $this->jwtApiCall('PwPaymentEngine/grantReceipt.jwt', $params);
                    \CakeLog::write('responsejson', \var_export($response, true));
                    if ($response['result']['error'] == 'true') {
                        throw new Exception('#ERROR: ' . $response['result']['msg']);
                    } else {
                        if (isset($response['result']['data']['agt_payment_no']) && $response['result']['data']['agt_payment_no'] == '') {
                            throw new Exception('#ERROR:Receipt Not Generated Properly.Please Try Again');
                        }
                        $data = array();
                        foreach ($requestdata as $r) {
                            $data = array(
                                'snd_transno' => 'TEST!@#$',
                                'transaction_date' => date('Y-m-d'),
                                'mode_id' => $r['mode_id'],
                                'provider_id' => '2', // for PwBank
                                'branch_id' => $r['branch_id'],
                                'countercode' => $r['countercode'],
                                'counter_agentcode' => $r['counter_agentcode'],
                                'dstbtr_code' => $r['dstbtr_code'],
                                'requested_panel' => $r['requested_panel'],
                                'request_for' => $r['request_for'],
                                'transaction_type' => 'TRANSACTION',
                                'amount' => $r['amount'],
                                'gst_amount' => '0',
                                'bankid' => $r['bankid'],
                                'bank_account_no' => $r['bank_account_no'],
                                'bank_ref_number' => $r['chequeno'] . " " . $r['bank_ref_number'],
                                'cheque_date' => $r['chequedate'],
                                'deposit_date' => $r['deposit_date'],
                                'narration' => $r['narration'],
                                'dateval' => date('Y-m-d H:i:s'),
                                'transaction_mode' => 'CREDIT',
                                'pw_payment_no' => $response['result']['data']['agt_payment_no'],
                                'response_flag' => 'N'
                            );
                        }
                        if (!empty($data)) {
                            $saveTransaction = $this->Transactions->save($data);
                            $lastinsertid = $this->Transactions->id;
                            $this->PaymentRequest->updateAll(
                                    array('transaction_no' => $lastinsertid, 'status' => "'GRANTED'", 'statement_no' => "'" . $statement_no . "'", 'grant_usercode' => "'" . $authcode . "'", 'grant_time' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $payment_ser_no)
                            );
                            $this->ResponseArr['data'] = $payment_ser_no;
                        }
                    }
                } else {
                    throw new Exception("#ERROR: Something Went Wrong! Please Try Again. ");
                }
            } else {
                throw new Exception("#ERROR: Something Went Wrong! Please Try Again.");
            }
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

    public function revoke() {
        try {
            $this->loadModel('BankStatementsData');
            $this->loadModel('PaymentRequest');
            $payment_ser_no = $this->request->data['serno'];
            $statement_no = $this->request->data['statement_no'];
            $entered_rs = json_decode($this->request->data['entered_rs']);
            $requestType = $this->request->data['requestType'];
            $validate_ids = $this->validate_entered_data($entered_rs, $requestType);

            //if (in_array($payment_ser_no, $validate_ids)) {
            $isvalid = false;
            foreach ($validate_ids as $key => $value) {
                if ($payment_ser_no == $key) {
                    $isvalid = true;
                }
            }

            if ($isvalid) {
                if ($statement_no == '' || $statement_no == '0') {
                    $statement_no = '';
                } else {
                    if (!in_array($statement_no, $validate_ids[$payment_ser_no]))
                        throw new Exception("#ERROR:");
                }
                $authcode = $this->request->data['authcode'];

                if ($statement_no != '' && $statement_no != '0') {
                    $this->BankStatementsData->updateAll(
                            array('flag_auth' => "'N'", 'auth_date' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $statementno)
                    );
                }
                if ($payment_ser_no != '' && $payment_ser_no != '0') {
                    $this->PaymentRequest->updateAll(
                            array('status' => "'REVOKED'", 'statement_no' => "'" . $statement_no . "'", 'revoke_usercode' => "'" . $authcode . "'", 'revoke_time' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $payment_ser_no)
                    );
                }

                $result = $payment_ser_no;
                $this->ResponseArr['data'] = $result;
            } else {

                throw new Exception("#ERROR:");
            }
        } catch (Exception $ex) {
            $this->ResponseArr["tag"] = $ex->getMessage();
        }
    }

//    function objToArray($obj, &$arr) {
//
//        if (!is_object($obj) && !is_array($obj)) {
//            $arr = $obj;
//            return $arr;
//        }
//
//        foreach ($obj as $key => $value) {
//            if (!empty($value)) {
//                $arr[$key] = array();
//                $this->objToArray($value, $arr[$key]);
//            } else {
//                $arr[$key] = $value;
//            }
//        }
//        return $arr;
//    }

    public function validate_entered_data($entered_rs = '', $requestType = 'agent') {
        $request_bank_cashinofyc_id = \Configure::read('CONSTANT_CASHINOFFICE');
        $this->loadModel("BankStatementsData");
        $this->loadModel('PaymentRequest');
        $ids = array();
        $stids = array();
        if ($entered_rs != '') {
            $bank = $entered_rs->bank;
            $account_no = $entered_rs->account_no;
            $payment_mode = $entered_rs->payment_mode;
            $branch = $entered_rs->branch;
            $branchid = $entered_rs->branchid;
            $branchcode = $entered_rs->branchcode;
            $conditions = array(
                'mode_id' => $payment_mode
            );

            if (in_array($request_bank_cashinofyc_id, $payment_mode)) {
                $conditions[]['OR'] = array(
                    array('bankid' => $bank),
                    array('bankid' => '')
                );
                $conditions[]['OR'] = array(
                    array('bank_account_no' => $account_no),
                    array('bank_account_no' => '')
                );
            } else {
                $conditions['bankid'] = $bank;
                $conditions['bank_account_no'] = $account_no;
            }

            if ($requestType == 'agent') {
                $conditions['request_for'] = 'AGENT';
                $conditions['counter_agentcode'] = 'Agent';
            } else if ($requestType == 'retailer') {
                $conditions['request_for'] = 'RETAILER';
                $conditions['counter_agentcode !='] = 'Agent';
            }
            if ($branch != '') {
                $conditions['branch_id'] = $branch;
            } elseif ($branch == '' && $branchcode != 'HO') {
                $conditions['branch_id'] = $branchid;
                $branch = $conditions['branch_id'];
            }
            $conditions['or'] = array(
                array('status' => 'PENDING'),
                array('status' => 'AUTHENTICATED')
            );
            $pendingrequests = $this->PaymentRequest->find('all', array('fields' => array('serno', 'deposit_date', 'amount', 'bankid', 'bank_account_no'), 'conditions' => $conditions));
            $i = 0;
            if (!empty($pendingrequests)) {
                foreach ($pendingrequests as $pr) {
                    $ids[$i] = $pr['PaymentRequest']['serno'];

                    $st_conditions = array(
                        'statement_date' => $pr['PaymentRequest']['deposit_date'],
                        'credit_amount' => $pr['PaymentRequest']['amount'],
                        'bankid' => $pr['PaymentRequest']['bankid'],
                        'bank_account_no' => $pr['PaymentRequest']['bank_account_no'],
                        'flag_grant' => 'N'
                    );
                    if ($branchcode != 'HO') {
                        $st_conditions['flag_auth'] = 'N';
                    }
                    $bankst = $this->BankStatementsData->find('all', array('fields' => array('serno'), 'conditions' => $st_conditions));

                    $stids[$ids[$i]] = array();
                    if (!empty($bankst)) {
                        foreach ($bankst as $b) {
                            $stids[$ids[$i]][] = $b['BankStatementsData']['serno'];
                        }
                    }
                    $i++;
                }
            }
        }
        return $stids;
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

}
