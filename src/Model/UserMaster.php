<?php

App::uses('AppModel', 'Model');

class UserMaster extends AppModel {

    public $useTable = "user_master";
    public $primaryKey = "usercode";

    public function getStateBranchAccess($conditions = array()) {
        $temp = $this->find("list", array("fields" => array("usercode", "db_branch"), "conditions" => $conditions, "limit" => 1));
        $stateAccess = array();
        $branchAccess = array();
        if (count($temp) <= 0)
            throw new Exception("Access Denied......");
        else {
            $indexing = key($temp);
            $stateBranch = explode("#", $temp[$indexing]);
            $index = 0;
            foreach ($stateBranch as $key => $val) {
                $state = explode(":", $val);
                $stateAccess[$key] = $state[0];
                $branch = explode("@", $state[1]);
                foreach ($branch as $k => $v):
                    $branchAccess[$state[0]][$index++] = $v;
                endforeach;
            }
        }
        return (array($stateAccess, $branchAccess));
    }

    public function InsertUserData($Request, $loginAccess) {
        $regexemail = "/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/";
        $regexmobile = "/^[789]+\d{9}$/";
        $day = substr($Request["dayaccess"], 1);
        if (!preg_match($regexemail, $Request["emailid"]))
            throw new exception("Data Has Not Received Properly[E-Mail]");
        if (!preg_match($regexmobile, $Request["mobileno"]))
            throw new exception("Data Has Not Received Properly[Mobile Number]");
        if (strlen($Request["mobileno"]) != 10)
            throw new exception("Mobile Number Cannot be Less Or Greater then 10 Digits");
        $dayArr = explode(",", $day);
        $loginAccessArr = explode(",", $loginAccess);
        foreach ($dayArr as $key => $value) {
            if (!in_array($value, array_values($loginAccessArr))) {
                throw new exception("Invalid Request Found.");
            }
        }
        $data1 = $this->find("all", array("fields" => "*", "conditions" => array("upper(loginname)" => trim(strtoupper($Request["loginname"])))));
        if (count($data1) > 0)
            throw new exception("Login Name Already Exists.");
        else {
            $data = array();
            $data["loginname"] = $Request["loginname"];
            $data["name"] = $Request["fullname"];
            $data["ph"] = $Request["mobileno"];
            $data["email"] = $Request["emailid"];
            $data["password"] = $Request["pass"];
            $data["pwdate"] = date("Y-m-d H:i:s");
            $data["creationdate"] = date("Y-m-d H:i:s");
            if ($Request["access"] == 1) {
                $data["stime"] = "00:00:00";
                $data["etime"] = "23:59:59";
            } else {
                $data["stime"] = $Request["start_time"];
                $data["etime"] = $Request["end_time"];
            }
            $data["accessdays"] = $day;
            if (!$this->save($data)) {
                throw new Exception("Party Has Not Been Created. Please Try Again[User Master]");
            }
            return true;
        }
    }

    public function getUserDetails($loginname) {
        $DbMaster = ClassRegistry::init("DbMaster");
        $user = $this->find('all', array('fields' => array('usercode', 'name', 'ph', 'email', 'db_group', 'block', 'loginname', 'stime', 'etime', 'accessdays'), 'conditions' => array('loginname' => $loginname)));
        if (count($user) <= 0)
            return "user_not_found";
        $row = $user[0][$this->name];
        $statelist = "All State";
        if (trim($row['db_group']) != 0) {
            $states = $DbMaster->find('list', array('fields' => array('serno', 'state'), 'conditions' => array('serno' => explode(":", $row['db_group']))));
            $statelist = implode(", ", array_values($states));
        }
        $ReportData = array('Usercode' => $row['usercode'], 'Username' => $row['name'], 'Phone' => $row['ph'], 'EmailId' => $row['email'], "States" => $statelist, 'Loginname' => $row['loginname'], 'Block' => $row['block'], 'Start_Time' => $row['stime'], 'End_Time' => $row['etime'], 'Accessdays' => $row['accessdays']);
        return $ReportData;
    }

    public function updateAccessDaysAndTime($Request, $loginAccess) {
        if ($Request["start_time"] == '' || $Request["end_time"] == '' || $Request["userloginname"] == '') {
            throw new exception("Invalid Request Found [User Master].");
        }

        \CakeLog::write('rererer', \var_export($Request, true));
        $day = substr($Request["dayaccess"], 1);

        $dayArr = explode(",", $day);
        $loginAccessArr = explode(",", $loginAccess);
        foreach ($dayArr as $key => $value) {
            if (!in_array($value, array_values($loginAccessArr))) {
                throw new exception("Invalid Request Found.");
            }
        }
        if (!$this->updateAll(array('stime' => "'" . trim($Request["start_time"]) . "'", 'etime' => "'" . trim($Request["end_time"]) . "'", 'accessdays' => "'" . trim($day) . "'"), array("loginname" => trim($Request["userloginname"])))) {
            throw new Exception("User Data Has Not Been Updated Properly.");
        } else {
            return true;
        }
    }

    public function updateUserDetails($Request) {
        if ($Request["userloginname"] == '') {
            throw new exception("Invalid Request Found.");
        }
        $regexemail = "/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/";
        $regexmobile = "/^[789]+\d{9}$/";
        $day = substr($Request["dayaccess"], 1);
        if (!preg_match($regexemail, $Request["emailid"]))
            throw new exception("Data Has Not Received Properly[E-Mail]");
        if (!preg_match($regexmobile, $Request["mobileno"]))
            throw new exception("Data Has Not Received Properly[Mobile Number]");
        if (strlen($Request["mobileno"]) != 10)
            throw new exception("Mobile Number Cannot be Less Or Greater then 10 Digits");
        \CakeLog::write('rererer', \var_export($Request, true));
        if (!$this->updateAll(array('name' => "'" . trim($Request["fullname"]) . "'", 'ph' => "'" . trim($Request["mobileno"]) . "'", 'email' => "'" . trim($Request["emailid"]) . "'"), array("loginname" => trim($Request["userloginname"])))) {
            throw new Exception("User Data Has Not Been Updated Properly.");
        } else {
            return true;
        }
    }

    public function updateBranchRights($Request, $stateList, $branchList) {
        if ($Request["dbgroup"] == '' || $Request["assigned"] == '' || $Request["userloginname"] == '') {
            throw new exception("Invalid Request Found.");
        }
        $stateAssign = array();
        $branchAssign = array();
        $stateBranch = explode("#", $Request["assigned"]);
        $index = 0;
        foreach ($stateBranch as $key => $val) {
            $state = explode(":", $val);
            $stateAssign[$key] = $state[0];
            $branch = explode("@", $state[1]);
            foreach ($branch as $k => $v):
                $branchAssign[$state[0]][$index++] = $v;
            endforeach;
        }
        if ($Request["dbgroup"] != '0') {
            $stateArr = explode(":", $Request["dbgroup"]);
            foreach ($stateArr as $value) {
                if (!in_array($value, array_keys($stateList))) {
                    throw new exception("Invalid Request Found.");
                } else {
                    foreach ($branchAssign[$value] as $value1) {
                        if (!in_array($value1, array_keys($branchList[$value]))) {
                            throw new exception("Invalid Request Found.");
                        }
                    }
                }
            }
        }
        if (!$this->updateAll(array('db_group' => "'" . trim($Request["dbgroup"]) . "'", 'db_branch' => "'" . trim($Request["assigned"]) . "'"), array("loginname" => trim($Request["userloginname"])))) {
            throw new Exception("User Data Has Not Been Updated Properly.");
        } else {
            return true;
        }
    }

}
