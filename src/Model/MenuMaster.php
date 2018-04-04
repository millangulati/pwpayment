<?php

/**
 * Description of MenuMaster
 *
 * CREATE TABLE `st_payment_menu_master` (
  `menucode` int(11) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(50) NOT NULL DEFAULT '',
  `menuicon` varchar(30) NOT NULL DEFAULT 'fa fa-circle-o',
  `menuaction` varchar(100) NOT NULL DEFAULT '',
  `menuindex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `finyearaccess` enum('BOTH','CURRENT') NOT NULL DEFAULT 'CURRENT',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`menucode`));
 * @author vinay
 *
 */
class MenuMaster
        extends AppModel {

    public $useTable = 'menu_master';
    public $primaryKey = 'menucode';

    public function getMenu($auth) {
        CakeLog::write('authlog', var_export($auth, true));

        $conditions = array("MenuMaster.status" => 'Y', 'MenuRights.status' => 'Y', 'MenuRights.usercode' => $auth['usercode']);
        if ($auth["finyeardate"] == ((date('m') > 3) ? date('Y') : date('Y') - 1) . '-04-01') {
            $conditions["MenuMaster.finyearaccess"] = array('BOTH', 'CURRENT');
        }
        if ($auth["logintype"] != 'HO') {
            $conditions["MenuMaster.access"] = array('BOTH');
        }
//        $onconditions["MenuMaster.menucode"] = "MenuRights.menucode";
        CakeLog::write('conditions', var_export($conditions, true));
        $options = array(
            'joins' => array(
                array('table' => 'st_payment_menu_rights',
                    'alias' => 'MenuRights', // the alias is 'included' in the 'table' field
                    'type' => 'LEFT',
                    'conditions' => array('MenuMaster.menucode = MenuRights.menucode')
                )
            ),
            'conditions' => $conditions,
            "order" => array("MenuMaster.parent", "MenuMaster.menuindex")
        );
        //CakeLog::write('options', var_export($options, true));
        //$menuarr = $this->find("all", array("conditions" => $conditions, "order" => array("parent", "menuindex")));
        $menuarr = $this->find("all", $options);
        //CakeLog::write('menuarr', var_export($menuarr, true));
        //$dbo = $this->getDatasource();
        //$logs = $dbo->getLog();
        //$lastLog = end($logs['log']);
//          debug($lastLog['query']);
        //CakeLog::write('lastLog', var_export($lastLog, true));
        $menudata = array();
        $Data = array();
        foreach ($menuarr as $row) {
            $row = $row[$this->name];
            $menudata[$row['menucode']]['class'] = $row['menuicon'];
            $menudata[$row['menucode']]['name'] = $row['menuname'];
            $Data[$row['level']][$row['parent']][$row['menucode']] = $row['menuaction'];
        }
        $menuList = array();
        if (isset($Data[0][0])) {
            foreach ($Data[0][0] as $mcode => $maction) {
                if (trim($maction) != "") {
                    $menuList[$mcode] = $maction;
                } else {
                    $tmp = $this->getSubMenu($mcode, 1, $Data);
                    $menuList[$mcode] = $tmp[$mcode];
                }
            }
        }
        return array("menu" => $menuList, "menuData" => $menudata);
    }

    function getSubMenu($parent, $level, $Data) {
        $menu = isset($Data[$level][$parent]) ? $Data[$level][$parent] : array();
        $arr = array($parent => '');
        foreach ($menu AS $key => $val) {
            if (trim($val) != '') {
                $arr[$parent][$key] = $val;
            } else {
                $level++;
                $tmp = $this->getSubMenu($key, $level, $Data);
                if (is_array($tmp[$key])) {
                    $arr[$parent][$key] = $tmp[$key];
                }
                $level --;
            }
        }
        return $arr;
    }

    public function getAllMenu($auth) {

        $menuarr = $this->find("all");
        $menudata = array();
        $Data = array();
        foreach ($menuarr as $row) {
            $row = $row[$this->name];
            $menudata[$row['menucode']]['class'] = $row['menuicon'];
            $menudata[$row['menucode']]['name'] = $row['menuname'];
            $Data[$row['level']][$row['parent']][$row['menucode']] = $row['menuaction'];
        }
        $menuList = array();
        if (isset($Data[0][0])) {
            foreach ($Data[0][0] as $mcode => $maction) {
                if (trim($maction) != "") {
                    $menuList[$mcode] = $maction;
                } else {
                    $tmp = $this->getSubMenu($mcode, 1, $Data);
                    $menuList[$mcode] = $tmp[$mcode];
                }
            }
        }
        return array("menu" => $menuList, "menuData" => $menudata);
    }

}
