<?php

App::uses('AppModel', 'Model');

/**
 * Description of ProviderModeMap
 *
 * @author vinay
 */
class ProviderModeMap extends AppModel {

    public $useTable = 'provider_mode_map';
    public $primaryKey = 'serno';

    public function getMappedBranch() {
        $mappedList = $this->find('all', array('fields' => array('*'), 'conditions' => array('status' => 'Y')));
        $providerdata = array();
        $branchdata = array();
        foreach ($mappedList as $row) {
            $row = $row['ProviderModeMap'];
            $providerdata[$row['mode_id']][$row['provider_id']][$row['branchid']] = $row['status'];
            $branchdata[$row['mode_id']][$row['branchid']][$row['provider_id']] = $row['status'];
        }
        $result['providerdata'] = $providerdata;
        $result['branchdata'] = $branchdata;
        return $result;
    }

    public function saveMappedBranch($Request) {
//        $providers = explode(",", $Request['provider_str']);
//        CakeLog::write('aaaaa', \var_export(array($value, array_keys($value)), true));
        $this->updateAll(array('status' => "'N'"), array('mode_id' => $Request['mode_id']));
        if (!empty($Request['mappeddata'][$Request['mode_id']])) {
            foreach ($Request['mappeddata'][$Request['mode_id']] as $key => $value) {
                if (!empty($value)) {
                    foreach ($value as $key1 => $value1) {
                        $checkRecord = $this->field('status', array('mode_id' => $Request['mode_id'], 'provider_id' => $key, 'branchid' => $key1));
                        if ($checkRecord) {
                            if ($checkRecord == 'N') {
                                $this->updateAll(array('status' => "'Y'"), array('mode_id' => $Request['mode_id'], 'provider_id' => $key, 'branchid' => $key1));
                            }
                        } else {
                            $this->saveAll(array('mode_id' => $Request['mode_id'], 'provider_id' => $key, 'branchid' => $key1, 'status' => 'Y'));
                        }
                    }
                }
//                CakeLog::write('aaaaa', \var_export(array($value, array_keys($value)), true));
//                if (!empty($value)) {
//                    $notBranch = \array_keys($value);
//                    $this->updateAll(
//                            array('status' => "'N'"), array('mode_id' => $Request['mode_id'], 'provider_id' => $key, 'branchid <>' => $notBranch)
//                    );
//                }
            }
        }
//        foreach ($providers as $key2 => $value2) {
//            $Request['mappeddata'][$Request['mode_id']] = empty($Request['mappeddata'][$Request['mode_id']]) ? array() : $Request['mappeddata'][$Request['mode_id']];
//            if (!\in_array($value2, \array_keys($Request['mappeddata'][$Request['mode_id']]))) {
//                $this->updateAll(
//                        array('status' => "'N'"), array('mode_id' => $Request['mode_id'], 'provider_id' => $value2)
//                );
//            }
//        }
    }

    function getallmodeData($request, $branchid) {
        $conditions = array(
            "ProviderModeMap.branchid" => strtoupper($branchid),
            "ProviderModeMap.status" => 'Y'
        );

        $options = array(
            'fields' => array('ProviderModeMap.mode_id as ProviderModeMap__mode_id,ProviderModeMap.provider_id as ProviderModeMap__provider_id,mm.name as mm__name,mm.type as mm__type'),
            'joins' => array(
                array('table' => 'st_payment_mode_master',
                    'alias' => 'mm', // the alias is 'included' in the 'table' field
                    'type' => 'LEFT',
                    'conditions' => array('mm.mode_id = ProviderModeMap.mode_id')
                )
            ),
            'conditions' => $conditions
        );
//        \CakeLog::write('get1121', \var_export(array($options, $conditions), true));
//        $paymentModeList1 = $this->find('all', $options);
//        \CakeLog::write('get1', \var_export($paymentModeList1, true));

        $paymentModeList = Set::combine($this->find('all', $options), "{n}.ProviderModeMap__mode_id", "{n}", "{n}.ProviderModeMap__provider_id");
//        $this->printSqlLog();
        \CakeLog::write('paymentModeList', \var_export($paymentModeList, true));
        return $paymentModeList;
    }

}
