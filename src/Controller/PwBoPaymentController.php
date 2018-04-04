<?php

App::uses('LoginController', 'Controller');
App::uses('Key', 'Vendor');
App::uses('jwt', 'Utility');

/**
 * CakePHP PwBoPaymentController
 *
 * @author vinay
 *
 */
class PwBoPaymentController extends LoginController {

    private static $pub_key_file = 'public_key.key';
    private static $pri_key_file = 'private_key.key';

    public function uploadBankStatement() {
        try {
            $request_bank_provider_id = \Configure::read('CONSTANT_PwBank');
            $response = '';

            $this->loadModel("BankMaster");
            $banklist = $this->BankMaster->find("list", array("fields" => array("bankid", "bankname"), 'conditions' => array('provider_id' => $request_bank_provider_id, 'status' => 'Y')));
            $this->BankMaster->setSource("account_branch_mapping");
            $banksAccountsList = $this->BankMaster->find("list", array("fields" => array("accountno", "bankid"), 'conditions' => array('status' => 'Y')));
            $banksAccounts = array();
            foreach ($banksAccountsList AS $account => $bank)
                $banksAccounts[$bank . "###" . $account] = $account;
            $this->ResponseArr['banklist'] = $banklist;
            $this->ResponseArr['bankaccountlist'] = $banksAccounts;
            $this->BankMaster->setSource("bank_master");
            if (!empty($this->request->data["statementfile"])) {
                $response = $this->uploadStatementFile();
                if (!is_array($response) && (strpos($response, "#ERROR:") !== false)) {
                    $response = str_replace("#ERROR:", "", $response);
//                    $this->ResponseArr['msg'] = $response;
                    throw new Exception($response);
                } else {
                    $this->ResponseArr['resultdata'] = $response;
                }
            }
            if (isset($this->request->data["upload_flag"]) && $this->request->data["upload_flag"] == 'submitdata') {
                if (empty($this->request->data["datastr"])) {
                    throw new Exception("Data Not Received Properly. Please Try Again.");
                }
                $this->loadModel("BankStatement");
                $message = $this->BankStatement->uploadBankStatementData($this->request->data["datastr"]);
                $this->ResponseArr['successmsg'] = "File Information Successfully uploaded";
            }
            if (isset($this->request->data["upload_flag"]) && $this->request->data["upload_flag"] == 'canceldata') {
                throw new Exception("Operation cancelled");
            }
        } catch (Exception $ex) {
            $this->ResponseArr['msg'] = $ex->getMessage();
        }
    }

    public function uploadStatementFile() {
        try {
            if (empty($this->request->data["statementfile"]))
                throw new Exception("No Valid File Has Been Received.");
            if (empty($this->request->data["bank"]))
                throw new Exception("Required Data Not Received[Bank Name].");
            if (empty($this->request->data["bankaccountno"]))
                throw new Exception("Required Data Not Received[Bank Account Number].");
            if (empty($this->request->data["statementdate"]))
                throw new Exception("Required Data Not Received[Statement Date].");
            if ($this->request->data["statementfile"]["error"] > 0)
                throw new Exception("Error In File Found: " . $this->request->data["statementfile"]["error"]);
            $allowedExts = array("xlsx", "xls");
            $temp = explode(".", $this->request->data["statementfile"]["name"]);
            $extension = end($temp);
            if (($this->request->data["statementfile"]["size"] < 2000000) && in_array($extension, $allowedExts)) {

                $this->loadModel("BankMaster");
                $bankDetail = $this->BankMaster->find("first", array("fields" => array("bankcode", "bankname"), "conditions" => array("bankid" => $this->request->data["bank"])));
                $bankCode = '';
                $bankName = '';
                if (!empty($bankDetail)) {
                    $bankCode = $bankDetail["BankMaster"]["bankcode"];
                    $bankName = $bankDetail["BankMaster"]["bankname"];
                }
                if (file_exists(TMP . "bank_statement" . DS . date('dmYHis') . $bankCode . "." . $extension)) {
                    throw new Exception("Your Previous Upload Is Under Process, Please Try Again Later.");
                } else {

                    $filepath = TMP . "bank_statement" . DS . date('dmYHis') . $bankCode . "." . $extension;
                    move_uploaded_file($this->request->data["statementfile"]["tmp_name"], $filepath);
                    try {
                        $statementdate = date('Y-m-d', strtotime($this->request->data["statementdate"]));
                        $bankAccountNo = $this->request->data["bankaccountno"];
                        //$this->loadModel("Bo");
                        $this->loadModel("BankStatement");
                        $resultData = $this->BankStatement->importStatementFile($filepath, $statementdate, $bankAccountNo);
                        return $resultData;
                    } catch (Exception $e) {
                        return("#ERROR:" . $e->getMessage());
                    }
                }
            } else {
                throw new Exception("Invalid File !!!");
            }
        } catch (Exception $e) {
            return "#ERROR:" . $e->getMessage();
        }
        return "#ERROR: Unable To Upload File[001].";
    }

    public function generateReceipt() {
        $this->loadModel("BankMaster");
        try {
            $request_bank_provider_id = \Configure::read('CONSTANT_PwBank');
            $responseArr = array();
            $isRetailer = false;
            if ($this->request->is('post') && isset($this->request->data['agent_flag']) && $this->request->data['agent_flag'] == 'searchagent') {
                $loginname = $this->request->data['agent'];

                $params = array("serno" => $this->Auth->user('db_serno'),
                    "branchcode" => $this->Auth->user('branchcode'),
                    "loginname" => $loginname,
                    "searchtype" => 'Agent'
                );
                $responseArr = $this->jwtApiCall('getAgentList', $params);
                $this->ResponseArr['responseArrData'] = $responseArr;
                if (!empty($responseArr['result'])) {

                    $this->loadModel('ModeMaster');
                    $paymentModeList = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('type' => 'request', 'status' => 'Y')));
                    $banklist = $this->BankMaster->find("list", array("fields" => array("bankid", "bankname"), 'conditions' => array('provider_id' => $request_bank_provider_id, 'status' => 'Y')));
                    $this->BankMaster->setSource("account_branch_mapping");
                    $accountconditions['status'] = 'Y'; //, 'branchid' => $this->Auth->user('branchid'));
                    $conditions = '';
                    if ($this->Auth->user('branchcode') != 'HO') {
                        $accountconditions['branchid'] = $this->Auth->user('branchid');
                    }
                    $banksAccountsList = $this->BankMaster->find("list", array("fields" => array("accountno", "bankid"), 'conditions' => $accountconditions));
                    $banksAccounts = array();
                    foreach ($banksAccountsList AS $account => $bank)
                        $banksAccounts[$bank . "###" . $account] = $account;
                    $this->ResponseArr['banklist'] = $banklist;
                    $this->ResponseArr['bankaccountlist'] = $banksAccounts;
                    $this->ResponseArr['paymentmode'] = $paymentModeList;
                    $this->ResponseArr['response'] = $responseArr;
                } else {
                    $this->ResponseArr['msg'] = 'Agent information not found.';
                }
            }
            if ($this->request->is('post') && isset($this->request->data['agent_flag']) && $this->request->data['agent_flag'] == 'agentrequest') {
                $data['paymentmode'] = $this->request->data['paymentmode'];
                $data['cashamount'] = $this->request->data['cashamount'];
                $data['bank'] = $this->request->data['bank'];
                $data['bankaccountno'] = $this->request->data['bankaccountno'];
                $data['chequenumber'] = $this->request->data['chequenumber'];
                $data['referencenumber'] = $this->request->data['referencenumber'];
                $data['depositbranchcode'] = $this->request->data['depositbranchcode'];
                $data['chequebankname'] = $this->request->data['chequebankname'];
                $data['depositdate'] = $this->request->data['depositdate'];
                $data['chequedate'] = $this->request->data['chequedate'];
                $data['remarks'] = $this->request->data['remarks'];
                $data['agentcounter'] = $this->request->data['agentcounterhidden'];
                $data['agentcode'] = $this->request->data['agentcodehidden'];
                $data['agentname'] = $this->request->data['agentnamehidden'];
                $data['usercode'] = $this->Auth->user('usercode');
                $data['username'] = $this->Auth->user('loginname');
                $data['agentdbsernohidden'] = $this->request->data['agentdbsernohidden'];
                $data['agentbranchcodehidden'] = $this->request->data['agentbranchcodehidden'];
                $data['requesttype'] = 'Agent';
                $data['slipfile'] = '';

                if (!empty($this->request->data['slipfile']['name'])) {
                    try {
                        $fileresponse = $this->uploadReceiptFile('slipfile');
                        $data['slipfile'] = $fileresponse;
                    } catch (Exception $ex) {
                        $this->ResponseArr['msg'] = $ex->getMessage();
                    }
                }

                $this->loadModel('PaymentRequest');
                $response = $this->PaymentRequest->insertRequest($data);
                if ($response == 'success') {
                    $data['bankname'] = $this->BankMaster->find("first", array("fields" => array("bankname"), 'conditions' => array('bankid' => $data['bank'])));
                    $this->ResponseArr['generatereceipt'] = true;
                    $this->ResponseArr['generatereceiptdata'] = $data;
                    $this->ResponseArr['successmsg'] = "Agent payment request generated.";
                } else {
                    $this->ResponseArr['msg'] = 'Something went wrong. Please try again later1.';
                }
            }

            if ($this->request->is('post') && isset($this->request->data['flagretailer']) && $this->request->data['flagretailer'] == 'searchretailer') {
                $isRetailer = true;
                $loginname = $this->request->data['retailer'];

                $params = array("serno" => $this->Auth->user('db_serno'),
                    "branchcode" => $this->Auth->user('branchcode'),
                    "loginname" => $loginname,
                    "searchtype" => ''
                );
                $responseArr = $this->jwtApiCall('PwPaymentEngine/getAgentList.jwt', $params);
                if (!empty($responseArr['result'])) {

                    $this->loadModel('ModeMaster');
                    $paymentModeList = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('type' => 'request', 'status' => 'Y')));
                    $banklist = $this->BankMaster->find("list", array("fields" => array("bankid", "bankname"), 'conditions' => array('provider_id' => $request_bank_provider_id, 'status' => 'Y')));
                    $this->BankMaster->setSource("account_branch_mapping");
                    $accountconditions['status'] = 'Y'; //, 'branchid' => $this->Auth->user('branchid'));
                    $conditions = '';
                    if ($this->Auth->user('branchcode') != 'HO') {
                        $accountconditions['branchid'] = $this->Auth->user('branchid');
                    }
                    $banksAccountsList = $this->BankMaster->find("list", array("fields" => array("accountno", "bankid"), 'conditions' => $accountconditions));
                    $banksAccounts = array();
                    foreach ($banksAccountsList AS $account => $bank)
                        $banksAccounts[$bank . "###" . $account] = $account;
                    $this->ResponseArr['banklist'] = $banklist;
                    $this->ResponseArr['bankaccountlist'] = $banksAccounts;
                    $this->ResponseArr['paymentmode'] = $paymentModeList;
                    $this->ResponseArr['responseretailer'] = $responseArr;
                } else {
                    $this->ResponseArr['msg'] = 'Retailer information not found.';
                }
            }

            if ($this->request->is('post') && isset($this->request->data['flagretailer']) && $this->request->data['flagretailer'] == 'retailerrequest') {
                $isRetailer = true;
                $data['paymentmode'] = $this->request->data['r_paymentmode'];
                $data['cashamount'] = $this->request->data['r_cashamount'];
                $data['bank'] = $this->request->data['r_bank'];
                $data['bankaccountno'] = $this->request->data['r_bankaccountno'];
                $data['chequenumber'] = $this->request->data['r_chequenumber'];
                $data['referencenumber'] = $this->request->data['r_referencenumber'];
                $data['depositbranchcode'] = $this->request->data['r_depositbranchcode'];
                $data['depositdate'] = $this->request->data['r_depositdate'];
                $data['chequedate'] = $this->request->data['r_chequedate'];
                $data['chequebankname'] = $this->request->data['r_chequebankname'];
                $data['remarks'] = $this->request->data['r_remarks'];
                $data['agentcounter'] = $this->request->data['r_agentcounterhidden'];
                $data['agentcode'] = $this->request->data['r_agentcodehidden'];
                $data['agentname'] = $this->request->data['r_agentnamehidden'];
                $data['usercode'] = $this->Auth->user('usercode');
                $data['username'] = $this->Auth->user('loginname');
                $data['agentdbsernohidden'] = $this->request->data['r_agentdbsernohidden'];
                $data['agentbranchcodehidden'] = $this->request->data['r_agentbranchcodehidden'];
                $data['requesttype'] = 'Retailer';
                $data['slipfile'] = '';

                if (!empty($this->request->data['r_slipfile']['name'])) {
                    try {
                        $fileresponse = $this->uploadReceiptFile('r_slipfile');
                        $data['slipfile'] = $fileresponse;
                    } catch (Exception $ex) {
                        $this->ResponseArr['msg'] = $ex->getMessage();
                    }
                }

                $this->loadModel('PaymentRequest');
                $response = $this->PaymentRequest->insertRequest($data);
                if ($response == 'success') {
                    $data['bankname'] = $this->BankMaster->find("first", array("fields" => array("bankname"), 'conditions' => array('bankid' => $data['bank'])));
                    $this->ResponseArr['generatereceipt'] = true;
                    $this->ResponseArr['generatereceiptdata'] = $data;
                    $this->ResponseArr['successmsg'] = "Retailer payment request generated.";
                } else {
                    $this->ResponseArr['msg'] = 'Something went wrong. Please try again later2.';
                }
            }
            if ($this->request->is('post') && isset($this->request->data['cancel_flag']) && $this->request->data['cancel_flag'] == 'cancelFromRetailerTab') {
                $isRetailer = true;
            }

            $this->ResponseArr['isRetailer'] = $isRetailer;
        } catch (Exception $ex) {
            $this->ResponseArr['msg'] = $ex->getMessage();
        }
    }

    public function uploadReceiptFile($fieldName) {
        try {
            if (empty($this->request->data[$fieldName]))
                throw new Exception("No Valid File Has Been Received.");
            if ($this->request->data[$fieldName]["error"] > 0)
                throw new Exception("Error In File Found: " . $this->request->data[$fieldName]["error"]);
            $allowedExts = array("jpg", "jpeg", "pjpeg", "png", "pdf");
            $temp = explode(".", $this->request->data[$fieldName]["name"]);
            $extension = end($temp);
            $filedbpath = "/webroot/payment_request_receipt" . DS . date('dmYHis') . $temp[0] . "." . $extension;
            if (($this->request->data[$fieldName]["size"] < 2000000) && in_array($extension, $allowedExts)) {

                if (file_exists(WWW_ROOT . "payment_request_receipt" . DS . date('dmYHis') . $temp[0] . "." . $extension)) {
                    throw new Exception("Your Previous Upload Is Under Process, Please Try Again Later.");
                } else {
                    $filepath = WWW_ROOT . "payment_request_receipt" . DS . date('dmYHis') . $temp[0] . "." . $extension;
                    if (move_uploaded_file($this->request->data[$fieldName]["tmp_name"], $filepath)) {
                        return $filedbpath;
                    } else {
                        throw new Exception("#ERROR: Unable To Upload File[001].");
                    }
                }
            } else {
                throw new Exception("Invalid File !!!");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        throw new Exception("#ERROR: Unable To Upload File[001].");
    }

    function agentPaymentAuthentication() {
//        $params = array("agentcode" => '5da07',
//            "narration" => 'Test Receipt API1',
////            "db_serno" => '5',
//            "amount" => '10.23'
//        );
//        $responseArr1 = $this->jwtApiCall('PwPaymentEngine/grantAgentReceipt.jwt', $params);
//        $this->ResponseArr['responseArr1'] = $responseArr1;
        $request_bank_provider_id = \Configure::read('CONSTANT_PwBank');
        $request_bank_cashinofyc_id = \Configure::read('CONSTANT_CASHINOFFICE');
        $this->loadModel('ModeMaster');
        $this->loadModel('BranchMaster');
        $this->loadModel("BankMaster");
        $this->loadModel("BankStatementsData");
        $this->loadModel('PayReqTimeLimit');
        $this->loadModel('BankAccountMaster');
        $rs = array();
        try {
            if ($this->request->is('post') && isset($this->request->data['pw_flag']) && ($this->request->data['pw_flag'] == 'pendingrequest' || $this->request->data['pw_flag'] == 'revoked')) {
                $rs['branch'] = $branch = $this->request->data['branch'];
                $rs['payment_mode'] = $payment_mode = $this->request->data['paymentmode'];
                $rs['bank'] = $bank = $this->request->data['bank'];
                $rs['account_no'] = $account_no = $this->request->data['bankaccountno'];
                $rs['branchcode'] = $this->Auth->user('branchcode');
                $rs['branchid'] = $this->Auth->user('branchid');
                /**
                 * check offline account number status
                 */
                $offlinerec = $this->BankAccountMaster->find('first', array('fields' => array('status'), 'conditions' => array('bankid' => $bank, 'accountno' => $account_no, 'offline_status' => 'Y')));
                $offlinestatus = false;
                if (!empty($offlinerec)) {
                    $offlinestatus = true;
                }
                $conditions = array(
                    'mode_id' => $payment_mode,
                    'request_for' => 'AGENT',
                    'counter_agentcode' => 'Agent'
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
                if ($branch != '') {
                    $conditions['branch_id'] = $branch;
                } elseif ($branch == '' && $this->Auth->user('branchcode') != 'HO') {
                    $conditions['branch_id'] = $this->Auth->user('branchid');
                    //$conditions['status'] = 'PENDING';
                    $branch = $conditions['branch_id'];
                }

                //if ($this->Auth->user('branchcode') == 'HO') {
                $conditions['or'] = array(
                    array('status' => 'PENDING'),
                    array('status' => 'AUTHENTICATED')
                );
                //}
                /**
                 * to check the time limit settings
                 */
                /* $isTime = false;

                  $gettimelimit = $this->PayReqTimeLimit->getDetail($branch, $payment_mode);

                  if (!empty($gettimelimit)) {
                  foreach ($gettimelimit[0] as $key => $value) {
                  if ($key == date('l')) {
                  foreach (explode(",", $value) as $timespan) {
                  $timepannels = explode("-", $timespan);
                  if ($timepannels[0] <= date('H') && $timepannels[1] > date('H')) {
                  $isTime = true;
                  }
                  }
                  }
                  }
                  }
                 */

                $this->loadModel('PaymentRequest');
                $header_value = array("branch_id", "brand", "dateval", "narration", "deposit_date", "countercode", "mode_id", "bankid", "deposit_branch_code", "chequeno", "amount", "status", "receipt_url", "statement", "serno", "mode_time_limit");
                $pendingrequests = $this->PaymentRequest->find('all', array('conditions' => $conditions));
                $finalarray = array();
                $i = 0;
                foreach ($pendingrequests as $row) {
                    foreach ($header_value as $key) {
                        if ($key == 'branch_id') {
                            $branchlist = $this->BranchMaster->find('first', array('fields' => array('branchname'), 'conditions' => array('branchid' => $row['PaymentRequest'][$key])));
                            $finalarray[$i][$key] = $branchlist['BranchMaster']['branchname'];
                        } else if ($key == 'mode_id') {
                            $modlist = $this->ModeMaster->find('first', array('fields' => array('name'), 'conditions' => array('mode_id' => $row['PaymentRequest'][$key])));
                            $finalarray[$i][$key] = $modlist['ModeMaster']['name'];
                        } else if ($key == 'bankid') {
                            $banklist = $this->BankMaster->find('first', array('fields' => array('bankname', 'bankcode'), 'conditions' => array('bankid' => $row['PaymentRequest'][$key])));
                            if (isset($banklist['BankMaster']['bankname']) && !empty($banklist['BankMaster']['bankname'])) {
                                $finalarray[$i][$key] = $banklist['BankMaster']['bankname'];
                            } else {
                                $finalarray[$i][$key] = '';
                            }
                        } else if ($key == 'bankcode') {
                            if (isset($banklist['BankMaster']['bankname']) && !empty($banklist['BankMaster']['bankname'])) {
                                $finalarray[$i][$key] = $banklist['BankMaster']['bankcode'];
                            } else {
                                $finalarray[$i][$key] = '';
                            }
                        } else if ($key == 'receipt_url') {
                            $finalarray[$i][$key] = $row['PaymentRequest'][$key];
                        } else if ($key == 'statement') {
                            $st_conditions = array(
                                'statement_date' => $row['PaymentRequest']['deposit_date'],
                                'credit_amount' => $row['PaymentRequest']['amount'],
                                'bankid' => $row['PaymentRequest']['bankid'],
                                'bank_account_no' => $row['PaymentRequest']['bank_account_no'],
                                'flag_grant' => 'N'
                            );
                            if ($this->Auth->user('branchcode') != 'HO') {
                                $st_conditions['flag_auth'] = 'N';
                            }
                            $bankst = $this->BankStatementsData->find('all', array('fields' => array('serno'), 'conditions' => $st_conditions));
                            $bankstids = '';
                            $arr = array();
                            if (!empty($bankst)) {
                                foreach ($bankst as $b) {
                                    $arr[] = $b['BankStatementsData']['serno'];
                                }
                                $bankstids = implode(",", $arr);
                            }
                            $finalarray[$i][$key] = $bankstids;
                        } else if ($key == 'receipt_url') {
                            $finalarray[$i][$key] = $row['PaymentRequest'][$key];
                        } else if ($key == 'mode_time_limit') {
                            $gettimelimit = $this->PayReqTimeLimit->getDetail($branch, $row['PaymentRequest']['mode_id']);
                            $isTime = false;
                            if (!empty($gettimelimit)) {
                                foreach ($gettimelimit[0] as $key => $value) {
                                    if ($key == date('l')) {
                                        foreach (explode(",", $value) as $timespan) {
                                            $timepannels = explode("-", $timespan);
                                            if ($timepannels[0] <= date('H') && $timepannels[1] > date('H')) {
                                                $isTime = true;
                                            }
                                        }
                                    }
                                }
                            }
                            $finalarray[$i]['mode_time_limit'] = $isTime;
                        } else {
                            $finalarray[$i][$key] = $row['PaymentRequest'][$key];
                        }
                    }
                    $i++;
                }

                if (!empty($finalarray)) {
                    //pr($finalarray);
                    $this->ResponseArr['branchcode'] = $this->Auth->user('branchcode');
                    $this->ResponseArr['pendingRequestLists'] = $finalarray;
                    //$this->ResponseArr['isTime'] = $isTime;
                    $this->ResponseArr['offlinestatus'] = $offlinestatus;
                    $this->ResponseArr['entered_rs'] = $rs;
                } else {
                    $this->ResponseArr['msg'] = "No Record Found";
                }
                if ($this->request->data['pw_flag'] == 'revoked') {
                    $this->ResponseArr['msg'] = "Request is revoked successfully.";
                }
            }

            $paymentModeList = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('type' => 'request', 'status' => 'Y')));
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
            foreach ($banksAccountsList AS $account => $bank)
                $banksAccounts[$bank . "###" . $account] = $account;


            $brachlist = $this->BranchMaster->find('list', array('fields' => array('branchid', 'branchname'), 'conditions' => $conditions));
            $this->ResponseArr['authusercode'] = $this->Auth->user('usercode');
            $this->ResponseArr['branchcode'] = $this->Auth->user('branchcode');
            $this->ResponseArr['banklist'] = $banklist;
            $this->ResponseArr['bankaccountlist'] = $banksAccounts;
            $this->ResponseArr['paymentmode'] = $paymentModeList;
            $this->ResponseArr['branchlist'] = $brachlist;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function retailerPaymentAuthentication() {
        $request_bank_provider_id = \Configure::read('CONSTANT_PwBank');
        $request_bank_cashinofyc_id = \Configure::read('CONSTANT_CASHINOFFICE');
        $this->loadModel('ModeMaster');
        $this->loadModel('BranchMaster');
        $this->loadModel("BankMaster");
        $this->loadModel("BankStatementsData");
        $this->loadModel('PayReqTimeLimit');
        $this->loadModel('BankAccountMaster');
        try {
            if ($this->request->is('post') && isset($this->request->data['pw_flag']) && $this->request->data['pw_flag'] == 'pendingrequest') {
                $rs['branch'] = $branch = $this->request->data['branch'];
                $rs['payment_mode'] = $payment_mode = $this->request->data['paymentmode'];
                $rs['bank'] = $bank = $this->request->data['bank'];
                $rs['account_no'] = $account_no = $this->request->data['bankaccountno'];
                $rs['branchcode'] = $this->Auth->user('branchcode');
                $rs['branchid'] = $this->Auth->user('branchid');

                /**
                 * check offline account number status
                 */
                $offlinerec = $this->BankAccountMaster->find('first', array('fields' => array('status'), 'conditions' => array('bankid' => $bank, 'accountno' => $account_no, 'offline_status' => 'Y')));
                $offlinestatus = false;
                if (!empty($offlinerec)) {
                    $offlinestatus = true;
                }
                $conditions = array(
                    'mode_id' => $payment_mode,
                    'request_for' => 'RETAILER',
                    'counter_agentcode !=' => 'Agent'
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
                if ($branch != '') {
                    $conditions['branch_id'] = $branch;
                } elseif ($branch == '' && $this->Auth->user('branchcode') != 'HO') {
                    $conditions['branch_id'] = $this->Auth->user('branchid');
                    //$conditions['status'] = 'PENDING';
                    $branch = $conditions['branch_id'];
                }

                //if ($this->Auth->user('branchcode') == 'HO') {
                $conditions['or'] = array(
                    array('status' => 'PENDING'),
                    array('status' => 'AUTHENTICATED')
                );
                //}
                /**
                 * to check the time limit settings
                 */
                /* $isTime = false;
                  $gettimelimit = $this->PayReqTimeLimit->getDetail($branch, $payment_mode);
                  if (!empty($gettimelimit)) {
                  foreach ($gettimelimit[0] as $key => $value) {
                  if ($key == date('l')) {
                  foreach (explode(",", $value) as $timespan) {
                  $timepannels = explode("-", $timespan);
                  if ($timepannels[0] <= date('H') && $timepannels[1] > date('H')) {
                  $isTime = true;
                  }
                  }
                  }
                  }
                  } */

                $this->loadModel('PaymentRequest');
                $header_value = array("branch_id", "brand", "dateval", "narration", "deposit_date", "countercode", "mode_id", "bankid", "deposit_branch_code", "chequeno", "amount", "status", "receipt_url", "statement", "serno", "mode_time_limit");
                $pendingrequests = $this->PaymentRequest->find('all', array('conditions' => $conditions));
                $finalarray = array();
                $i = 0;
                foreach ($pendingrequests as $row) {
                    foreach ($header_value as $key) {
                        if ($key == 'branch_id') {
                            $branchlist = $this->BranchMaster->find('first', array('fields' => array('branchname'), 'conditions' => array('branchid' => $row['PaymentRequest'][$key])));
                            $finalarray[$i][$key] = $branchlist['BranchMaster']['branchname'];
                        } else if ($key == 'mode_id') {
                            $modlist = $this->ModeMaster->find('first', array('fields' => array('name'), 'conditions' => array('mode_id' => $row['PaymentRequest'][$key])));
                            $finalarray[$i][$key] = $modlist['ModeMaster']['name'];
                        } else if ($key == 'bankid') {
                            $banklist = $this->BankMaster->find('first', array('fields' => array('bankname', 'bankcode'), 'conditions' => array('bankid' => $row['PaymentRequest'][$key])));
                            if (isset($banklist['BankMaster']['bankname']) && !empty($banklist['BankMaster']['bankname'])) {
                                $finalarray[$i][$key] = $banklist['BankMaster']['bankname'];
                            } else {
                                $finalarray[$i][$key] = '';
                            }
                        } else if ($key == 'bankcode') {
                            if (isset($banklist['BankMaster']['bankname']) && !empty($banklist['BankMaster']['bankname'])) {
                                $finalarray[$i][$key] = $banklist['BankMaster']['bankcode'];
                            } else {
                                $finalarray[$i][$key] = '';
                            }
                        } else if ($key == 'receipt_url') {
                            $finalarray[$i][$key] = $row['PaymentRequest'][$key];
                        } else if ($key == 'statement') {
                            $st_conditions = array(
                                'statement_date' => $row['PaymentRequest']['deposit_date'],
                                'credit_amount' => $row['PaymentRequest']['amount'],
                                'bankid' => $row['PaymentRequest']['bankid'],
                                'bank_account_no' => $row['PaymentRequest']['bank_account_no'],
                                'flag_grant' => 'N'
                            );
                            if ($this->Auth->user('branchcode') != 'HO') {
                                $st_conditions['flag_auth'] = 'N';
                            }
                            $bankst = $this->BankStatementsData->find('all', array('fields' => array('serno'), 'conditions' => $st_conditions));
                            $bankstids = '';
                            $arr = array();
                            if (!empty($bankst)) {
                                foreach ($bankst as $b) {
                                    $arr[] = $b['BankStatementsData']['serno'];
                                }
                                $bankstids = implode(",", $arr);
                            }
                            $finalarray[$i][$key] = $bankstids;
                        } else if ($key == 'mode_time_limit') {
                            $gettimelimit = $this->PayReqTimeLimit->getDetail($branch, $row['PaymentRequest']['mode_id']);
                            $isTime = false;
                            if (!empty($gettimelimit)) {
                                foreach ($gettimelimit[0] as $key => $value) {
                                    if ($key == date('l')) {
                                        foreach (explode(",", $value) as $timespan) {
                                            $timepannels = explode("-", $timespan);
                                            if ($timepannels[0] <= date('H') && $timepannels[1] > date('H')) {
                                                $isTime = true;
                                            }
                                        }
                                    }
                                }
                            }
                            $finalarray[$i]['mode_time_limit'] = $isTime;
                        } else {
                            $finalarray[$i][$key] = $row['PaymentRequest'][$key];
                        }
                    }
                    $i++;
                }

                if (!empty($finalarray)) {
                    $this->ResponseArr['branchcode'] = $this->Auth->user('branchcode');
                    $this->ResponseArr['pendingRequestLists'] = $finalarray;
                    //$this->ResponseArr['isTime'] = $isTime;
                    $this->ResponseArr['offlinestatus'] = $offlinestatus;
                    $this->ResponseArr['entered_rs'] = $rs;
                } else {
                    $this->ResponseArr['msg'] = "No Record Found";
                }
            }

            $paymentModeList = $this->ModeMaster->find('list', array('fields' => array('mode_id', 'name'), 'conditions' => array('type' => 'request', 'status' => 'Y')));
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
            foreach ($banksAccountsList AS $account => $bank)
                $banksAccounts[$bank . "###" . $account] = $account;


            $brachlist = $this->BranchMaster->find('list', array('fields' => array('branchid', 'branchname'), 'conditions' => $conditions));
            $this->ResponseArr['authusercode'] = $this->Auth->user('usercode');
            $this->ResponseArr['branchcode'] = $this->Auth->user('branchcode');
            $this->ResponseArr['banklist'] = $banklist;
            $this->ResponseArr['bankaccountlist'] = $banksAccounts;
            $this->ResponseArr['paymentmode'] = $paymentModeList;
            $this->ResponseArr['branchlist'] = $brachlist;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
