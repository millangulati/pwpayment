<?php

App::uses('AppModel', 'Model');

/**
 * Description of PayReqTimeLimit
 *
 * @author vinay
 */
class PayReqTimeLimit
        extends AppModel {

    public $useTable = 'payreq_time_limit';

//    public function getTimeList($dbser) {
//        $BranchMaster = ClassRegistry::init("BranchMaster");
//        $ModeMaster = ClassRegistry::init("ModeMaster");
//        $dayname = array("Sunday", 'Monday', 'Tuesday', 'Wednesday', 'Thursday', "Firday", "Saturday");
//        $state = $BranchMaster->find('list', array("fields" => array('branchid', 'branchname')));
//        $paymode = $ModeMaster->find('list', array("fields" => array('mode_id', 'name'), "conditions" => array("status" => 'Y', "type" => "REQUEST")));
//
//        $query = "select branchid,mode_id,time_slot from st_payment_payreq_time_limit where branchid in (" . $dbser . ") and  row(branchid,mode_id,entrydate) in(  select branchid,mode_id,max(entrydate) from  st_payment_payreq_time_limit group by branchid,mode_id order by mode_id)order by branchid+0,mode_id+0;";
//
//
//        $result = $this->query($query);
//        $resultentArr = array();
//        $i = 0;
//        $DataField = array();
//        foreach ($dayname as $name) {
//            foreach ($paymode as $pcode => $pname) {
//                $DataField[$pcode][$name] = '';
//            }
//        }
//        foreach ($result as $i => $row) {
//            $row = $row['st_payment_payreq_time_limit'];
//            $resultentArr[$i]["Serno"] = $i + 1;
//            $resultentArr[$i]["State"] = $state[$row['branchid']];
//            $resultentArr[$i]['Payment Mode'] = $paymode[$row['mode_id']];
//            $resultentArr[$i] += $DataField[$row['mode_id']];
//            foreach (explode('#', $row['time_slot']) as $daytime) {
//                $tmp = explode('@', $daytime); //0@3-16
//                if ($tmp[0] != '') {
//                    $resultentArr[$i][$dayname[$tmp[0]]] = str_replace(",", ", ", $tmp[1]);
//                }
//            }
//        }
//        return $resultentArr;
//    }

    public function AddTimeSlot($data, $mode) {
        try {
            \CakeLog::write('dadada', \var_export(array($data, $mode), true));
            if ($data["paymentMode"] == '' || $mode == '') {
                throw new exception("Invalid Request Found.Please Try Again.");
            }
            $day = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fir', 'Sat');
            $time = array();
            $count = 0;
            $dbser = $data['selectState'];
            $data["paymentMode"] = substr($data["paymentMode"], 1);
            $paymentMode = explode(",", $data["paymentMode"]);

            foreach ($dbser as $state):
                foreach ($mode as $modekey => $modevalue) {
                    if (!\in_array($modekey, $paymentMode)) {
                        if (!$this->updateAll(array('entrydate' => "'" . date('Y-m-d H:i:s') . "'", 'time_slot' => "' '"), array('mode_id' => $modekey, 'branchid' => $state))) {
                            throw new Exception("Error !!! Data Has Not Been Updated  Properly.");
                        }
                    }
                }
            endforeach;

            foreach ($mode as $code => $paymode):
                $time[$code] = '';
                foreach ($day as $dd => $dayval):
                    $timeString = '';
                    $flag = 0;
                    for ($i = 0; $i < 3; $i++) {
                        if ($data[$code . "_" . $dayval . "_" . $i . "_f"] != "" && $data[$code . "_" . $dayval . "_" . $i . "_t"] == "") {
                            throw new Exception("Error # Time Slot(To) Getting Blank!!! ");
                        }
                        if ($data[$code . "_" . $dayval . "_" . $i . "_f"] == "" && $data[$code . "_" . $dayval . "_" . $i . "_t"] != "") {
                            throw new Exception("Error # Time Slot(Form) Getting Blank!!! ");
                        }
                        if ($data[$code . "_" . $dayval . "_" . $i . "_f"] < 0 || $data[$code . "_" . $dayval . "_" . $i . "_f"] > 24) {
                            throw new Exception("Error # Time Slot(Form) Contain Invalid Value!!! ");
                        }
                        if ($data[$code . "_" . $dayval . "_" . $i . "_t"] < 0 || $data[$code . "_" . $dayval . "_" . $i . "_t"] > 24) {
                            throw new Exception("Error # Time Slot(Form) Contain Invalid Value!!! ");
                        }
                        if (($i == 0 || $i == 1 || $i == 2) && ($data[$code . "_" . $dayval . "_" . $i . "_f"] != "" && $data[$code . "_" . $dayval . "_" . $i . "_t"] != "" )) {
                            if ($flag == 0) {
                                $flag++;
                                $time[$code] .= "#" . $dd . "@";
                            }
                            $count++;
                            $timeString .= "," . $data[$code . "_" . $dayval . "_" . $i . "_f"] . "-" . $data[$code . "_" . $dayval . "_" . $i . "_t"];
                        }
                    }
                    $timeString = substr($timeString, 1);
                    $time[$code] .= $timeString;
                endforeach;
                $time[$code] = substr($time[$code], 1);
            endforeach;
            if ($count == 0) {
                throw new Exception("Error # Time Slot Getting Blank!!! ");
            }
            $values = array();
// add a day
            foreach ($dbser as $state):
                foreach ($paymentMode as $modetype):
                    $values['branchid'] = $state;
                    $values['mode_id'] = $modetype;
                    $values['time_slot'] = $time[$modetype];
                    $values['entrydate'] = date('Y-m-d H:i:s');
                    $checkRecord = $this->field('mode_id', array('mode_id' => $values['mode_id'], 'branchid' => $values['branchid']));
                    if ($checkRecord) {
                        if (!$this->updateAll(array('entrydate' => "'" . $values['entrydate'] . "'", 'time_slot' => "'" . $values['time_slot'] . "'"), array('mode_id' => $values['mode_id'], 'branchid' => $values['branchid']))) {
                            throw new Exception("Error !!! Data Has Not Been ADDED Properly.");
                        }
                    } else {
                        if (!$this->saveAll($values)) {
                            throw new Exception("Error !!! Data Has Not Been ADDED Properly.");
                        }
                    }
                endforeach;
            endforeach;

            return true;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function getDetail($branchid, $modeid) {
        $dayname = array("Sunday", 'Monday', 'Tuesday', 'Wednesday', 'Thursday', "Friday", "Saturday");
        $resultentArr = array();
        $conditions = array(
            'mode_id' => $modeid
        );
        if ($branchid != '') {
            $conditions['branchid'] = $branchid;
        }
        $timeslot = $this->find('first', array('fields' => array('time_slot', 'branchid'), "conditions" => $conditions, "limit" => 1, "order" => array("entrydate DESC")));
        //if($timeslot['PayReqTimeLimit']);
        if (!empty($timeslot)) {
            $timedays = explode('#', $timeslot['PayReqTimeLimit']['time_slot']);
            for ($i = 0; $i < count($timedays); $i++) {
                $tmp = explode('@', $timedays[$i]); //0@3-16
                if ($tmp[0] != '') {
                    $resultentArr[$i][$dayname[$tmp[0]]] = str_replace(",", ", ", $tmp[1]);
                }
            }
        }
        return $resultentArr;
    }

    public function getTimeLimitDetail() {

        $result = Set::combine($this->find('all', array("fields" => array('mode_id', 'time_slot', 'branchid'), "conditions" => array('time_slot <>' => ''))), "{n}.PayReqTimeLimit.mode_id", "{n}.PayReqTimeLimit", "{n}.PayReqTimeLimit.branchid");
        return $result;
    }

}

?>
