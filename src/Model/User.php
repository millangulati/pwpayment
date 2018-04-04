<?php

App::uses('AppModel', 'Model');

/**
 * Description of User
 *
 * @author vinay
 */
class User
        extends AppModel {

//    public $useDbConfig = "payworld";
    public $useTable = "user_master";
    public $primaryKey = "usercode";
    public $hashPasswordFlag = false;
    private static $pwdformat = 'MD5'; // TEXT|MD5
    private static $pwdExp = '+200 days'; // Duration from last password change date to expire password (+<0-9> days|months|years).

    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        if (!empty($queryData) && isset($queryData["conditions"]["loginquery"])) {
            unset($queryData["conditions"]["loginquery"]);
            $this->hashPasswordFlag = true;
        }
        return $queryData;
    }

    public function afterFind($results, $primary = false) {
        parent::afterFind($results);
        if ($this->hashPasswordFlag && !empty($results[0][$this->name]["password"])) {
            $this->hashPasswordFlag = false;
            $salt = CakeSession::read("TmpSess.salt");
            CakeSession::delete("TmpSess.salt");
            App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
            $PasswordHasher = new SimplePasswordHasher();
            $results[0][$this->name]["password"] = $PasswordHasher->hash(md5(strtoupper(self::$pwdformat == 'MD5' ? $results[0][$this->name]["password"] : md5($results[0][$this->name]["password"])) . $salt));
        }
        return $results;
    }

    public function beforeLogin(&$rdata) {
        $loginname = base64_decode(trim($rdata['loginname']));
        $password = base64_decode($rdata['password']);
        $rdata = array($this->name => array('loginname' => $loginname, 'password' => $password));
    }

    public function afterLogin() {
        $this->updateAll(array("loggedin" => "'" . date('Y-m-d H:i:s') . "'"), array("usercode" => AuthComponent::user("usercode")));
        if (AuthComponent::user("db_group") == '0') {
            CakeSession::write("Auth.User.db_serno", 0);
            CakeSession::write("Auth.User.state", 'HO');
            CakeSession::write("Auth.User.logintype", 'HO');
            CakeSession::write("Auth.User.branchcode", 'HO');
            CakeSession::write("Auth.User.branchid", 'HO');
        } else {
            CakeSession::write("Auth.User.logintype", 'Individual');
            $db_access = explode(":", AuthComponent::user("db_group"));
            $temp = explode("#", AuthComponent::user("db_branch"));
            foreach ($temp as $key => $val):
                $state = explode(":", $val);
                $branch = explode("@", $state[1]);
                $index = 0;
                foreach ($branch as $k => $v):
                    $branchAccess[$state[0]][$index++] = $v;
                endforeach;
            endforeach;
            $BranchMaster = ClassRegistry::init("BranchMaster");
            $branchinfo = $BranchMaster->find('first', array('fields' => array('branchid')
                , 'conditions' => array('pw_db_serno' => $db_access[0], 'pw_branch' => $branchAccess[$db_access[0]][0])));

            $branchid = '0';
            if (!empty($branchinfo)) {
                $branchid = $branchinfo['BranchMaster']['branchid'];
            }
            CakeSession::write("Auth.User.db_serno", $db_access[0]);
            CakeSession::write("Auth.User.branchcode", $branchAccess[$db_access[0]][0]);
            CakeSession::write("Auth.User.branch_access", $branchAccess);
            CakeSession::write("Auth.User.db_access", $db_access);
            CakeSession::write("Auth.User.branchid", $branchid);
            $db_master = ClassRegistry::init('DbMaster');
            CakeSession::write("Auth.User.state", $db_master->field('state', array("status >= " => 1, "brand" => "pw", 'serno' => AuthComponent::user("db_serno"))));
        }

        CakeSession::write("Auth.User.loggedin", date('Y-m-d H:i:s'));
        CakeSession::write("Auth.User.finyeardate", PwSpecialFun::GetCurFinYear() . '-04-01');
        $MenuMaster = ClassRegistry::init('MenuMaster');
        CakeSession::write("Auth.User.layoutData", $MenuMaster->getMenu(AuthComponent::user()));
        CakeSession::write("Auth.User.marquee", "Welcome To Back office");
        \CakeLog::write('se', \var_export('ghgh', true));
    }

    public function changePassword($request) {
        try {
            if (!CakeSession::check("TmpSess.salt")) {
                throw new Exception('Something went wrong, reload page and retry');
            }
            $salt = CakeSession::read("TmpSess.salt");
            $newpass = base64_decode(substr(base64_decode($request['newpass']), strlen($salt)));
            if (md5(strtoupper(md5($newpass)) . $salt) != $request['repass']) {
                throw new Exception("New Password and Re-Enter Password are not matched.");
            }
            $conditions = array('usercode' => AuthComponent::user('usercode'));
            $pass = $this->field('password', $conditions);
            if ($request['oldpass'] != md5(strtoupper(self::$pwdformat == 'MD5' ? $pass : md5($pass)) . $salt)) {
                throw new Exception('Invalid Old Password.');
            }
            if ($request['oldpass'] == $request['repass']) {
                throw new Exception("New Password must be different from Old Password.");
            }
            $this->updateAll(array('password' => "'" . (self::$pwdformat == 'MD5' ? strtoupper(md5($newpass)) : $newpass) . "'", 'pwdate_byuser' => "'N'", 'pwdate' => "'" . date('Y-m-d H:i:s') . "'"), $conditions);
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function resetPassword($request) {
        try {
            $conditions = array('loginname' => $request['login']);
            if (!empty($request['mno'])) {
                $conditions['ph'] = $request['mno'];
            } elseif (!empty($request['emailid'])) {
                $conditions['email'] = $request['emailid'];
            } else {
                throw new Exception('Please Enter Registered Mobile no. / Email ID');
            }
            $user = $this->find('all', array('fields' => array('name', 'loginname', 'usercode', 'email', 'ph'), 'conditions' => $conditions));
            if (!count($user)) {
                throw new Exception('Invalid combination of parameter values.');
            }
            $this->sendResetPasswordMail($user[0]['User']);
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    private function sendResetPasswordMail($user) {
        $passwd = PwSpecialFun::GeneratePasswd(8);
        App::import('Vendor', 'Email');
        $mail = new Email();
        $mail->to = $user['email'];
        $mail->subject = 'Reset Password';
        $mail->message = 'Dear ' . $user['name'] . ',<br><br>Your Request For Reset Password Has Been Processed Successfully.<br><br><b>Login Name : </b>' . $user['loginname'] . '<br><br><b>New Password : </b>' . $passwd . '<br><br><b>Registered Mobile No. : </b>' . $user['ph'] . '<br><br><b>Regards,<br><u>Paymet Engine.</u></b>';
        $mail->Send();
        $this->updateAll(array('password' => "'" . (self::$pwdformat == 'MD5' ? strtoupper(md5($passwd)) : $passwd) . "'", 'pwdate_byuser' => "'Y'", 'pwdate' => "'" . date('Y-m-d H:i:s') . "'"), array('usercode' => $user['usercode']));
    }

    public function isPasswordExpired() {
        return AuthComponent::user('pwdate_byuser') == 'Y' || (date('Ymd') > date('Ymd', strtotime(AuthComponent::user('pwdate') . self::$pwdExp)));
    }

}
