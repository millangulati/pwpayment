<?php

App::uses('AppModel', 'Model');

/**
 * Description of ModeMaster
 *
 * @author vinay
 */
class ModeMaster
        extends AppModel {

    public $useTable = 'mode_master';
    public $primaryKey = 'mode_id';

    public function getGraphModeAmt($type = 'REQUEST', $request_for = 'AGENT') {
        $conditions = array("ModeMaster.type" => $type);

//        $onconditions["MenuMaster.menucode"] = "MenuRights.menucode";

        $options = array(
            'fields' => array('IFNULL(sum(r.amount),0) as amt', 'ModeMaster.name'),
            'joins' => array(
                array('table' => 'st_payment_payment_request',
                    'alias' => 'r', // the alias is 'included' in the 'table' field
                    'type' => 'LEFT',
                    'conditions' => array('ModeMaster.mode_id = r.mode_id', 'r.status="GRANTED"', 'r.request_for="' . $request_for . '"')
                )
            ),
            'conditions' => $conditions,
            "order" => array("ModeMaster.mode_id"),
            'group' => array('ModeMaster.name')
        );
        $finalarray = array();
        //$menuarr = $this->find("all", array("conditions" => $conditions, "order" => array("parent", "menuindex")));
        $result = $this->find("all", $options);
        $total_amount = 0;
        if (!empty($result)) {
            $i = 0;

            foreach ($result as $r) {
                $finalarray[$i]['name'] = $r['ModeMaster']['name'];
                $finalarray[$i]['amt'] = $r[0]['amt'];
                $total_amount += $r[0]['amt'];
                $i++;
            }
            array_unshift($finalarray, array('name' => 'Total', 'amt' => $total_amount));
        }
        return json_encode($finalarray, JSON_NUMERIC_CHECK);
    }

    public function getTypeModeCount($request_for = 'AGENT') {
        $conditions = array('r.request_for' => $request_for);
        $options = array(
            'fields' => array('count(r.serno) as count', 'r.status', 'ModeMaster.type'),
            'joins' => array(
                array('table' => 'st_payment_payment_request',
                    'alias' => 'r', // the alias is 'included' in the 'table' field
                    'type' => 'LEFT',
                    'conditions' => array('ModeMaster.mode_id = r.mode_id')
                )
            ),
            'conditions' => $conditions,
            'group' => array('r.status', 'ModeMaster.type')
        );

        $finalarray = array();

        //$menuarr = $this->find("all", array("conditions" => $conditions, "order" => array("parent", "menuindex")));
        $result = $this->find("all", $options);
        if (!empty($result)) {
            $i = 0;
            $type = '';
            foreach ($result as $r) {
                $type = $r['ModeMaster']['type'];
                /* $finalarray[$type][$i]['status'] = $r['r']['status'];
                  $finalarray[$type][$i]['count'] = $r[0]['count']; */
                $finalarray[$type][$r['r']['status']]['count'] = $r[0]['count'];
                //$finalarray[$type][$i]['count'] = $r[0]['count'];
                $i++;
            }
        }
        if (!empty($finalarray)) {
            $type = '';
            foreach ($finalarray as $mtype => $value) {
                $total_count = 0;
                foreach ($value as $type => $a_count) {
                    $total_count += $finalarray[$mtype][$type]['count'];
                }
                $finalarray[$mtype] = array('Total' => array('count' => $total_count)) + $finalarray[$mtype];
            }
        }
        return $finalarray;
    }

}
