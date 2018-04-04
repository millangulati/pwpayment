<?php

App::uses('AppModel', 'Model');

/**
 * Description of BankAccountMaster
 *
 * @author vinay
 */
class AccountBranchMapping extends AppModel {

    public $useTable = 'account_branch_mapping';
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

    public function getMappedBranch() {
        $mappedList = $this->find('all', array('fields' => array('*'), 'conditions' => array('status' => 'Y')));
        $providerdata = array();
        foreach ($mappedList as $row) {
            $row = $row['AccountBranchMapping'];
            $providerdata[$row['bankid']][$row['accountno']][$row['branchid']] = $row['status'];
        }
//        $result['providerdata'] = $providerdata;
        return $providerdata;
    }

    public function mapAccounts($request) {
        if (!isset($request['bankid']) || !isset($request['activeString'])) {
            throw new Exception("Invalid Request. Please Try Againq");
        }
        $mappeddata = json_decode($request['activeString'], true);
        $this->updateAll(array('status' => "'N'"), array('bankid' => $request['bankid']));
        if (!empty($mappeddata[$request['bankid']])) {
            foreach ($mappeddata[$request['bankid']] as $key => $value) {
                if (!empty($value)) {
                    foreach ($value as $key1 => $value1) {
                        $checkRecord = $this->field('status', array('bankid' => $request['bankid'], 'accountno' => $key, 'branchid' => $key1));
                        if ($checkRecord) {
                            if ($checkRecord == 'N') {
                                $this->updateAll(array('status' => "'Y'"), array('bankid' => $request['bankid'], 'accountno' => $key, 'branchid' => $key1));
                            }
                        } else {
                            $this->saveAll(array('bankid' => $request['bankid'], 'accountno' => $key, 'branchid' => $key1, 'status' => 'Y'));
                        }
                    }
                }
            }
        }
        return true;
    }

}
