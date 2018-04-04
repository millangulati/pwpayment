<?php

App::uses('LoginController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PwBoUserController
 *
 * @author software
 */
class PwBoUserController extends LoginController {

    public function changePasswd() {
        try {
            if (isset($this->request->data['oldpass']) && trim($this->request->data['oldpass']) != '') {
                $this->loadModel('User');
                PwSpecialFun::ValidatePram($this->request->data, array('oldpass' => 'ANS', 'newpass' => 'ANS', 'repass' => 'ANS'));
                $this->User->changePassword($this->request->data);
                $this->logout("Password updated successfully, Relogin...");
            }
        } catch (Exception $ex) {
            $this->ResponseArr['authMessage'] = $ex->getMessage();
        }
    }

    public function changeStateBranch() {
        $this->loadModel('BranchMaster');
        try {
            $this->ResponseArr['flag'] = $this->request->data['flag'];
            if ($this->request->data['flag'] == 'State') {
                $stateArr = $this->Auth->user("db_access");
                $this->loadModel("DbMaster");
                $states = $this->DbMaster->find("list", array("conditions" => array("status >= " => 1, "brand" => "pw", "serno" => $stateArr), 'fields' => array('serno', 'state')));
                ksort($states);
                $this->ResponseArr["States"] = $states;
            } else if ($this->request->data['flag'] == 'Branch') {

                $branches = $this->BranchMaster->find("list", array("conditions" => array("pw_db_serno" => $this->Auth->user("db_serno")), 'fields' => array('pw_branch', 'branchname')));
                $this->ResponseArr["branches"] = $branches;
            }

            if (isset($this->request->data['action']) && $this->request->data['action'] == 'State') {
                $this->Session->write("Auth.User.db_serno", $this->request->data["state"]);
                $this->loadModel("DbMaster");
                $stateArr = $this->DbMaster->find("list", array("conditions" => array("status >= " => 1, "brand" => "pw", "serno" => $this->request->data["state"]), 'fields' => array('serno', 'state')));
                $branch = $this->Auth->user("branch_access");
                $this->Session->write("Auth.User.branchcode", $branch[$this->request->data["state"]][0]);
                $this->Session->write("Auth.User.state", $stateArr[$this->request->data["state"]]);
                $branchinfo = $this->BranchMaster->find('first', array('fields' => array('branchid')
                    , 'conditions' => array('pw_db_serno' => $this->request->data["state"], 'pw_branch' => $branch[$this->request->data["state"]][0])));

                $branchid = '0';
                if (!empty($branchinfo)) {
                    $branchid = $branchinfo['BranchMaster']['branchid'];
                }
                $this->Session->write("Auth.User.branchid", $branchid);
                $this->ResponseArr["SuccessMessage"] = "State Changed Successfully.";
            } else if ((isset($this->request->data['action']) && $this->request->data['action'] == 'Branch')) {
                $this->Session->write("Auth.User.branchcode", $this->request->data["branch"]);
                $branchinfo = $this->BranchMaster->find('first', array('fields' => array('branchid')
                    , 'conditions' => array('pw_db_serno' => $this->Auth->user('db_serno'), 'pw_branch' => $this->request->data["branch"])));

                $branchid = '0';
                if (!empty($branchinfo)) {
                    $branchid = $branchinfo['BranchMaster']['branchid'];
                }
                $this->Session->write("Auth.User.branchid", $branchid);
                $this->ResponseArr["SuccessMessage"] = "Branch Changed Successfully.";
            }
        } catch (Exception $ex) {
            $this->ResponseArr['msg'] = $ex->getMessage();
        }
    }

    public function createNewUser() {
        try {
            $this->loadModel("DbMaster");
            $this->loadModel("BranchMaster");
            $this->loadModel("UserMaster");
            $this->ResponseArr["loginAccessdays"] = $this->Auth->user("accessdays");
            if (isset($this->request->data['loginname']) && trim($this->request->data['loginname']) != '') {

                if ($this->request->data['pass'] == '' || $this->request->data['loginname'] == '' || $this->request->data['fullname'] == '' || $this->request->data['mobileno'] == '' || $this->request->data['emailid'] == '' || $this->request->data['dayaccess'] == '') {
                    throw new Exception("Invalid Data Received. Please Try Again");
                }
                $saveData = $this->UserMaster->InsertUserData($this->request->data, $this->Auth->user("accessdays"));
                if ($saveData)
                    $this->ResponseArr["SuccessMessage"] = "New User Added Successfully";
            }
        } catch (Exception $ex) {
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function editUserDetails() {
        try {
            $this->loadModel('BranchMaster');
            $this->loadModel('UserMaster');

            if ($this->request->is('post') && isset($this->request->data['loginname'])) {

                $userData = $this->UserMaster->getUserDetails($this->request->data['loginname']);
                if ($userData != 'user_not_found') {
                    if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
                        if ($userData['States'] == 'All State')
                            throw new Exception("Branch Office User Can't Change The Rights Of Head Office User.");
                    }
                    $this->ResponseArr["userInformation"] = $userData;
                } else {
                    throw new Exception("User Not Found");
                }
            }
            if ($this->request->is('post') && isset($this->request->data['userloginname'])) {
                $updateData = $this->UserMaster->updateUserDetails($this->request->data);
                if ($updateData) {
                    $this->ResponseArr["SuccessMessage"] = "User Has Been Updated Successfully";
                }
                $this->ResponseArr["res"] = $this->request->data;
            }
        } catch (Exception $ex) {
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function changeAccessTimeandday() {
        try {
            $this->loadModel('BranchMaster');
            $this->loadModel('UserMaster');
            $this->ResponseArr["loginAccessdays"] = $this->Auth->user("accessdays");
            if ($this->request->is('post') && isset($this->request->data['loginname'])) {
                $userData = $this->UserMaster->getUserDetails($this->request->data['loginname']);
                if ($userData != 'user_not_found') {
                    if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
                        if ($userData['States'] == 'All State')
                            throw new Exception("Branch Office User Can't Change The Rights Of Head Office User.");
                    }
                    $this->ResponseArr["userInformation"] = $userData;
                } else {
                    throw new Exception("User Not Found");
                }
            }
            if ($this->request->is('post') && isset($this->request->data['dayaccess'])) {
                $updateData = $this->UserMaster->updateAccessDaysAndTime($this->request->data, $this->Auth->user("accessdays"));
                if ($updateData) {
                    $this->ResponseArr["SuccessMessage"] = "User Has Been Updated Successfully";
                }
                $this->ResponseArr["res"] = $this->request->data;
            }
        } catch (Exception $ex) {
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function changeBranchRights() {
        try {
            $this->loadModel('BranchMaster');
            $this->loadModel('UserMaster');
            $this->loadModel('DbMaster');
            if ($this->request->is('post')) {
                if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
                    $Authtemp = $this->UserMaster->getStateBranchAccess(array("usercode" => trim($this->Auth->user("usercode"))));
                    $stateAccessLogin = $Authtemp[0];
                    $branchAccessLogin = $Authtemp[1];
                    $stateList = $this->DbMaster->find("list", array("fields" => array("serno", "state"), "conditions" => array("serno" => $stateAccessLogin, "brand" => "PW", "status" => 1)));

                    $branchList = $this->BranchMaster->getStateWiseBranches($stateList, $branchAccessLogin);
                } else {
                    $stateList = $this->DbMaster->find("list", array("fields" => array("serno", "state"), "conditions" => array("brand" => "PW", "status" => 1)));
                    $branchList = $this->BranchMaster->getStateWiseBranches($stateList, array());
                }
            }
            if ($this->request->is('post') && isset($this->request->data['loginname'])) {
                $userData = $this->UserMaster->getUserDetails($this->request->data['loginname']);
                if ($userData != 'user_not_found') {
                    $this->ResponseArr["userInformation"] = $userData;
                } else {
                    throw new Exception("User Not Found");
                }
                $AllstateList = $this->DbMaster->find("list", array("fields" => array("serno", "state"), "conditions" => array("brand" => "PW", "status" => 1)));
                $AllbranchList = $this->BranchMaster->getStateWiseBranches($AllstateList, array());
                $tempSearch = $this->UserMaster->getStateBranchAccess(array("loginname" => trim($this->request->data["loginname"]), "usercode <>" => trim($this->Auth->user("usercode"))));
                $stateAccess = $tempSearch[0];
                $branchAccess = $tempSearch[1];
                if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
                    if ($userData['States'] == 'All State')
                        throw new Exception("Branch Office User Can't Change The Rights Of Head Office User.");
                }
                $allowedstate = "";
                $index = 0;
                foreach ($stateAccess as $key => $val) {
                    $allowedstate .= $val . ",";
                    foreach ($branchAccess[$val] as $ky => $vl)
                        $allowedstate .= $vl . "@" . $val . ",";
                }
                $this->ResponseArr["loginname"] = $this->request->data["loginname"];
                rtrim($allowedstate, ",");
                if ($allowedstate == '0,HO@0,' || $allowedstate == ',HO@,') {
                    $allowedstate = 'HO';
                }
                $this->ResponseArr["Data"] = compact("AllstateList", "AllbranchList", "allowedstate", "stateList", "branchList", "userData");
                $this->ResponseArr["LoginType"] = $this->Auth->user("logintype");
            }
            if ($this->request->is('post') && isset($this->request->data['dbgroup'])) {
                if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
                    if ($this->request->data['dbgroup'] == "O") {
                        throw new exception("Invalid Request Found.");
                    }
                }
                $updateData = $this->UserMaster->updateBranchRights($this->request->data, $stateList, $branchList);
                if ($updateData) {
                    $this->ResponseArr["SuccessMessage"] = "User's branch Has Been Updated Successfully.";
                }
                $this->ResponseArr["res"] = $this->request->data;
            }
        } catch (Exception $ex) {
            $this->ResponseArr["msg"] = $ex->getMessage();
        }
    }

    public function updateMenuRights() {
        $loginname = $userinformation = $currentmenuaccess = $menuList = $statusInformation = '';
        try {
            $this->loadModel('BranchMaster');
            $this->loadModel('UserMaster');
            $this->loadModel('MenuMaster');
            $this->loadModel('MenuRights');
            $conditions = array(
                'conditions' => array('usercode' => $this->Auth->user('usercode'), 'status' => 'Y'), //array of conditions
                'fields' => array('menucode'),
            );
            $menuaccessloggedin = $this->MenuRights->find('list', $conditions);
            if ($this->request->is('post') && ( isset($this->request->data['selectLoginName']) || (isset($this->request->data['hiddenusercode']) && isset($this->request->data['hiddenloginname'])) )) {
                if (isset($this->request->data['hiddenusercode']) && isset($this->request->data['hiddenloginname'])) {
                    $loginname = $this->request->data['hiddenloginname'];
                    $newmenurights = $this->request->data['hiddencheckedmenucodes'];
                    $newremovedmenurights = $this->request->data['hiddenuncheckedmenucodes'];
                    $usercode = $this->request->data['hiddenusercode'];
                    $updateData = $this->MenuRights->updateNewMenuAccessRights($newmenurights, $usercode, $newremovedmenurights, $menuaccessloggedin);
                    $statusInformation = 'Information Updated Successfully.';
                } else if (isset($this->request->data['selectLoginName'])) {
                    $loginname = $this->request->data['selectLoginName'];
                }

                $userinformation = $this->UserMaster->getUserDetails($loginname);
                if ($userinformation != 'user_not_found') {
//                    if (trim(strtoupper($this->Auth->user("logintype"))) != "HO") {
//                        if ($userinformation['States'] == 'All State')
//                            throw new Exception("Branch Office User Can't Change The Rights Of Head Office User.");
//                    }
                    $menuList = $this->MenuMaster->getAllMenu(AuthComponent::user());
                    $conditions = array(
                        'conditions' => array('usercode' => $userinformation['Usercode'], 'status' => 'Y'), //array of conditions
                        'fields' => array('menucode'),
                    );
                    $currentmenuaccess = $this->MenuRights->find('list', $conditions);
                } else {
                    $this->ResponseArr['loginname'] = $loginname;
                    throw new Exception("User not found.");
                }
            }
            $this->ResponseArr['loginname'] = $loginname;
            $this->ResponseArr['userInformation'] = $userinformation;
            $this->ResponseArr['menuinformation'] = $menuList;
            $this->ResponseArr['currentmenuaccess'] = $currentmenuaccess;
            $this->ResponseArr['menuaccessloggedin'] = $menuaccessloggedin;
            $this->ResponseArr['successmsg'] = $statusInformation;
        } catch (Exception $ex) {
            $this->ResponseArr['msg'] = $ex->getMessage();
        }
    }

}
