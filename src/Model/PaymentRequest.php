<?php

class PaymentRequest extends AppModel {

    public $useTable = 'payment_request';
    var $primaryKey = 'serno';

    function getDetail($field = array("*"), $conditions = array(), $order = array()) {
        return $this->find("all", array("fields" => $field, "conditions" => $conditions, "order" => $order));
    }

    public function insertRequest($data) {

        $agentdbserno = $data['agentdbsernohidden'];
        $agentbranchcode = $data['agentbranchcodehidden'];
        $BranchMaster = ClassRegistry::init("BranchMaster");
        $branchinfo = $BranchMaster->find('first', array('fields' => array('branchid')
            , 'conditions' => array('pw_db_serno' => $agentdbserno, 'pw_branch' => $agentbranchcode)));

        $branchid = '0';
        if (!empty($branchinfo)) {
            $branchid = $branchinfo['BranchMaster']['branchid'];
        }
        $dataArray = array(
            "dateval" => date('Y-m-d H:i:s'),
            "branch_id" => $branchid,
            "brand" => "PW",
            "countercode" => trim($data['agentcode']),
            "counter_agentcode" => $data['agentcounter'],
            "dstbtr_code" => '',
            "amount" => trim($data["cashamount"]),
            "chequeno" => trim($data["chequenumber"]),
            "chequedate" => $data["chequedate"] != '' ? date('Y-m-d', strtotime(trim($data["chequedate"]))) : '0000-00-00',
            "cheque_bank_name" => $data['chequebankname'],
            "deposit_date" => $data["depositdate"] != '' ? date('Y-m-d', strtotime(trim($data["depositdate"]))) : date('Y-m-d'),
            "bankid" => trim($data["bank"]),
            "mode_id" => trim($data['paymentmode']),
            "narration" => trim($data['remarks']),
            "requested_panel" => 'BOPOS',
            "request_usercode" => trim($data['usercode']),
            "request_username" => trim($data['username']),
            "bank_account_no" => trim($data['bankaccountno']),
            "receipt_url" => $data['slipfile'],
            "request_for" => $data['requesttype'],
            "deposit_branch_code" => $data['depositbranchcode'],
            "bank_ref_number" => $data['referencenumber']
        );

        if ($this->save($dataArray)) {
            return 'success';
        }
        return 'error';
    }

    public function getReportsData($request_for = NULL, $request_type = NULL) {

        if ($request_for == '' && $request_type == '') {
            throw new Exception("Something went wrong. Please try again later.");
        }
        $conditions = array(
            "m.type" => strtoupper($request_type),
            //"PaymentRequest.status" => "GRANTED",
            "PaymentRequest.request_for" => strtoupper($request_for)
        );

//        $onconditions["MenuMaster.menucode"] = "MenuRights.menucode";

        $options = array(
            'fields' => array('PaymentRequest.*'),
            'joins' => array(
                array('table' => 'st_payment_mode_master',
                    'alias' => 'm', // the alias is 'included' in the 'table' field
                    'type' => 'LEFT',
                    'conditions' => array('m.mode_id = PaymentRequest.mode_id')
                )
            ),
            'conditions' => $conditions
//"order" => array("ModeMaster.mode_id")
        );
        $header_value = array("branch_id", "dateval", "countercode", "mode_id", "bankid", "deposit_branch_code", "chequeno", "amount", "deposit_date");
        $pendingrequests = $this->find('all', $options);
        /* $dbo = $this->getDatasource();
          $logs = $dbo->getLog();
          $lastLog = end($logs['log']);
          debug($lastLog['query']); */
        $finalarray = array();

        $i = 0;
        $BranchMaster = \ClassRegistry::init('BranchMaster');
        $ModeMaster = \ClassRegistry::init('ModeMaster');
        $BankMaster = \ClassRegistry::init('BankMaster');
        foreach ($pendingrequests as $row) {
            foreach ($header_value as $key) {
                if ($key == 'branch_id') {
                    $branchlist = $BranchMaster->find('first', array('fields' => array('branchname'), 'conditions' => array('branchid' => $row['PaymentRequest'][$key])));
                    $finalarray[$i][$key] = $branchlist['BranchMaster']['branchname'];
                } else if ($key == 'mode_id') {
                    $modlist = $ModeMaster->find('first', array('fields' => array('name'), 'conditions' => array('mode_id' => $row['PaymentRequest'][$key])));
                    $finalarray[$i][$key] = $modlist['ModeMaster']['name'];
                } else if ($key == 'bankid') {
                    $banklist = $BankMaster->find('first', array('fields' => array('bankname', 'bankcode'), 'conditions' => array('bankid' => $row['PaymentRequest'][$key])));
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
                } else if ($key == 'dateval') {
                    $finalarray[$i][$key] = date('Y-m-d', strtotime($row['PaymentRequest'][$key]));
                } else {
                    $finalarray[$i][$key] = $row['PaymentRequest'][$key];
//}
                }
            }
            $i++;
        }
        return $finalarray;
    }

    public function savePaymentRequest($data) {
        try {
            $dataArray = array(
                "dateval" => date('Y-m-d H:i:s'),
                "branch_id" => $data['branchid'],
                "brand" => "PW",
                "countercode" => trim($data['countercode']),
//                 "db_serno" => trim($data['db_serno']),
                "counter_agentcode" => $data['counter_agentcode'],
                "dstbtr_code" => $data['dstbtr_code'],
                "amount" => $data["amount"],
                "mode_id" => trim($data['mode_id']),
                "narration" => trim($data['narration']),
                "requested_panel" => trim($data['requested_panel']),
                "request_usercode" => trim($data['request_usercode']),
                "request_username" => trim($data['request_username']),
                "receipt_url" => $data['receipt_url'],
                "request_for" => $data['request_for'],
                "deposit_branch_code" => $data['deposit_branch_code'],
                "status" => "PENDING"
            );
            if ($data['mode_id'] != '1') {
                $dataArray['bank_account_no'] = trim($data['bank_account_no']);
                $dataArray['bankid'] = trim($data['bankid']);
                $dataArray['deposit_date'] = date('Y-m-d', strtotime(trim($data["deposit_date"])));
            }
            if ($data['mode_id'] == '3') {
                $dataArray['chequeno'] = trim($data['chequeno']);
                $dataArray['chequedate'] = date('Y-m-d', strtotime(trim($data["chequedate"])));
                $dataArray['cheque_bank_name'] = trim($data['cheque_bank_name']);
            }
            if ($data['mode_id'] == '4' || $data['mode_id'] == '9') {
                $dataArray['bank_ref_number'] = trim($data['bank_ref_number']);
            }
            if (!$this->save($dataArray)) {
                throw new Exception('Request Not Saved Properly.');
            }
            return $this->getLastInsertID();
        } catch (Exception $ex) {
            throw new Exception('Some Error Occured.');
        }
    }

}

?>
