<?php

App::uses('AppModel', 'Model');

/**
 * Description of BranchMaster
 *
 * @author vinay
 */
class BranchMaster extends AppModel {

    public $useTable = 'branch_master';
    public $primaryKey = 'branchid';

    public function getStateWiseBranches($menuList, $branchAccess = array()) {
        foreach ($menuList as $k => $v) {
            $conditions["pw_db_serno"] = $k;
            if (count($branchAccess) > 0)
                $conditions["pw_branch"] = $branchAccess[$k];
//        Set::combine($this->find('all', array("fields" => array('pw_db_serno', 'pw_branch', 'branchname'), "conditions" => array(''))), "{n}.BranchMaster.pw_branch", "{n}.ModeMaster", "{n}.ModeMaster.pw_db_serno");
            $menu = $this->find("all", array("fields" => array("pw_branch", 'branchname'), "conditions" => $conditions));
            foreach ($menu AS $key => $val)
                $menuList1[$k][$val[$this->name]["pw_branch"]] = $val[$this->name]["branchname"];
        }
        return($menuList1);
    }

}
