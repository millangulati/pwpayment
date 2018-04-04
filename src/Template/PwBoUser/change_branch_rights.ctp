<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$userData = isset($response["userInformation"]) ? $response["userInformation"] : array();
$userDataLoginname = isset($response["userInformation"]) ? $response["userInformation"]['Loginname'] : '';
$accessbranchList = isset($response["Data"]["branchList"]) ? $response["Data"]["branchList"] : array();
$accessStateList = isset($response["Data"]["stateList"]) ? $response["Data"]["stateList"] : array();
$loginType = isset($response["LoginType"]) ? $response["LoginType"] : "";
$allowedState = isset($response["Data"]["allowedstate"]) ? $response["Data"]["allowedstate"] : array();
$AllstateList = isset($response["Data"]["AllstateList"]) ? $response["Data"]["AllstateList"] : array();
$AllbranchList = isset($response["Data"]["AllbranchList"]) ? $response["Data"]["AllbranchList"] : array();
//pr($allowedState);
//pr($accessbranchList);

$curtime = date("H:i:s");
$time = date("H:i");
//echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure'));

function CreateTree($AllbranchList, $AllstateList, $accessStateList, $accessbranchList) {//, $AllstateList
    $menuitem = "";
    if (is_array($AllbranchList)) {
        $menuitem.= '<ul style="margin-left: 55px;">';
        foreach ($AllbranchList as $k => $v) {
            $maindisabled = in_array($k, \array_keys($accessStateList)) ? '' : 'disabled';

            $menuitem.= "<li>";
            $menuitem.= "<input name='" . $k . "' id='" . $k . "' class='hidden $maindisabled' type='checkbox' value='" . $k . "' onChange='changeRights(this);' $maindisabled ><div class='btn-group'><label for='" . $k . "' class=' btn green $maindisabled'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><span class='MenuTitle'><label for='" . $k . "' class='btn btn-default $maindisabled' style='width: 200px;'>" . $AllstateList[$k] . "</label></span></div>";
            if (is_array($v)) {
                $menuitem.= '<ul style="margin-left: 10px;">';
                foreach ($v as $key => $val):
                    $innerisabled = in_array($key, \array_keys(isset($accessbranchList[$k]) ? $accessbranchList[$k] : array())) ? '' : 'disabled';
//                    $innerisabled = in_array($key, $accessbranchList) ? false : true;
                    $menuitem.= "<li>";
                    $menuitem.= "<input name='" . $key . "@" . $k . "' id='" . $key . "@" . $k . "' class='hidden $innerisabled' type='checkbox' value='" . $key . "@" . $k . "' onChange='changeRights(this);' $innerisabled><div class='btn-group'><label for='" . $key . "@" . $k . "' class=' btn grey $innerisabled'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><span class='MenuTitle'><label for='" . $key . "@" . $k . "' class='btn btn-default $innerisabled' style='width: 200px;'>" . $val . "</label></span></div>";
                    $menuitem.= "</li>";
                endforeach;
                $menuitem.= "</ul>";
            }
            $menuitem.= "</li>";
        }
        $menuitem.= "</ul>";
    }
    return $menuitem;
}

function invoke($AllbranchList, $AllstateList, $loginType, $accessStateList, $accessbranchList) {
    $menuitem = "";
    if (strtoupper($loginType) == "HO") {
        $menuitem.= '<ul>';
        $menuitem.= "<li>";
        $menuitem.= "<input name='HO' id='HO' class='hidden'  type='checkbox' value='HO' onChange='changeRights(this);'><div class='btn-group'><label for='HO' class=' btn btn-primary'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><span class='MenuTitle'><label for='HO' class='btn btn-default' style='width: 50px;'>HO</label></span></div>";
        $menuitem.=CreateTree($AllbranchList, $AllstateList, $accessStateList, $accessbranchList);
        $menuitem.= "</li>";
        $menuitem.= "</ul>";
    } else
        $menuitem.=CreateTree($AllbranchList, $AllstateList, $accessStateList, $accessbranchList);
    return $menuitem;
}

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa  fa-home font-green-sharp"></i>';
echo $this->Html->tag('span', 'Change Branch Rights', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return submitformfun();'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //main portlet-body

if (!isset($response['userInformation'])) {
    echo $this->Html->div('portlet-title'); /// lgin search
    echo $this->Form->create('Bo', array("id" => "searchUser", "target" => "_self", "autocomplete" => "off"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo '<i class="fa fa-user font-green-sharp"></i>';
    echo $this->Html->tag('span', ' Search User : ', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //

    echo $this->Html->div("row", NULL, array("id" => "searchDiv"));

    echo $this->Html->div('col-sm-2 col-md-2', $this->Form->label('loginName', 'Login Name', array('style' => 'padding-left:0px;')));
    echo $this->Form->input('loginname', array("id" => "loginname", "label" => FALSE, 'div' => array('class' => 'col-md-3 col-sm-3 form-group'), 'value' => '', "class" => "form-control"));
    echo $this->Html->div('col-sm-2 col-md-2');
    echo $this->Form->button('Go', array('id' => 'btnsearchlogin', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return validateLoginName();'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
    echo $this->Html->useTag('tagend', 'div'); // lgin search end
//
} else {
    echo $this->Form->create('Bo', array("name" => "submitform", 'id' => 'submitform', "target" => "_self", "autocomplete" => "off"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->hidden("userloginname", array("value" => '', 'id' => 'userloginname'));
    $this->Form->unlockField("userloginname");
    echo $this->Form->input('dbgroup', array('id' => 'dbgroup', 'class' => 'inputBox1', 'type' => "hidden"));
    $this->Form->unlockField("dbgroup");
    echo $this->Form->input('assigned', array('id' => 'assigned', 'class' => 'inputBox1', 'type' => "hidden"));
    $this->Form->unlockField("assigned");
    echo $this->Form->end();
    echo $this->Html->div('portlet-title'); /// User details
    echo '<i class="fa fa-user font-green-sharp"></i>';
    echo $this->Html->tag('span', ' User Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //

    echo $this->Html->div('row');

    echo $this->Html->div('col-md-4 form-group');
    echo $this->Form->label('userCode', 'User Code:');
    echo $this->Html->tag('span', $userData['Usercode'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4 form-group');
    echo $this->Form->label('userName', 'User Name:');
    echo $this->Html->tag('span', $userData['Username'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4 form-group');
    echo $this->Form->label('phoneNumber', 'Phone Number:');
    echo $this->Html->tag('span', $userData['Phone'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4 form-group');
    echo $this->Form->label('email', 'Email id:');
    echo $this->Html->tag('span', $userData['EmailId'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-8 form-group');
    echo $this->Form->label('states', 'States:', array('style' => 'float:left;'));
    echo $this->Html->tag('span', $this->Html->div('col-md-10 no-padding', $userData['States'], array('style' => 'margin-top:4px;float:left;')), array('class' => 'strong'));
//    echo $this->Form->label('states', 'States:');
//    echo $this->Html->tag('span', $userData['States'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div'); // User details end
    echo "<hr>";
    echo $this->Html->div('portlet-title'); /// Access Branch
    echo '<i class="fa  fa-clock-o font-green-sharp"></i>';
    echo $this->Html->tag('span', ' Branch Access', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //


    echo $this->Html->div('row');
    echo "<div id='tree'>" . invoke($AllbranchList, $AllstateList, $loginType, $accessStateList, $accessbranchList) . "</div>";
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div'); // access Branch end
    echo "<hr>";
}
echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
echo $this->Form->create('formback', array("name" => "formback", 'id' => 'formback', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->end();
?>

<style>
    .strong {font-weight: bold;}
    #start_time,#end_time{ width: 209px;}
    .tools{margin-right: 10px;display: none;}
    .badgebox{opacity: 0;}
    .badgebox + .badge{text-indent: -999999px; width: 27px;}
    .badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
    .badgebox:checked + .badge{ text-indent: 0;}
    .alert {line-height: 0px;margin-bottom: -15px;}
    #tree ul{margin-bottom: 10px;}
    #tree li{margin-left: 55px;}
    #tree ul li{ display: inline;margin-bottom: 10px;}
    input[type="checkbox"] { display: none;}
    input[type="checkbox"] + .btn-group > label span {width: 20px; }
    input[type="checkbox"] + .btn-group > label span:first-child {display: none;}
    input[type="checkbox"] + .btn-group > label span:last-child {display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:first-child { display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:last-child {display: none;}
    .btn { line-height: 1.44; margin-bottom: 7px;}
    .disabled{cursor: not-allowed;}
</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var userLoginname = "<?= $userDataLoginname ?>";
    $('#document').ready(function () {
        if (userLoginname == '') {
            $(".tools").hide();
        }
        else {
            $(".tools").show();
            $("#userloginname").val(userLoginname);
        }
        if (sucmsg != '') {
            SuccMsgFun('loginname', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('loginname', msg);
        }
        $("#loginname,#start_time,#end_time,#fullaccess,.dayslist,#chk_alldays").click(function () {
            $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger,alert alert-success alert-autocloseable-success');
            $("#msgDiv").html("&nbsp");
        });

        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        setRights("<?= $allowedState ?>");
    });
    function setRights(rightsStr) {
        if (rightsStr == "")
        {
            $("#tree input[type=checkbox]").attr("checked", false);
            $("#tree input[type=checkbox]").prop('indeterminate', false);
            return;
        }
        var RightArr = rightsStr.split(",");
        $("#tree input[type=checkbox]").each(function () {
            if ($.inArray($(this).val(), RightArr) >= 0 || rightsStr == "ALL" || rightsStr == "HO")
                $(this).prop('checked', true);
            else
                $(this).prop('checked', false);
            changeRights(this);
        });
    }
    function validateLoginName() {
        if ($("#loginname").val() == '') {
            return ErrorMsgFun('loginname', 'Please enter login name.');
        } else {
            $('#searchUser').submit();
        }
    }
    function submitformfun() {
        var rightsval = getRights();
        $('#assigned').val(rightsval);
//        alert($('#dbgroup').val());
//        alert($('#assigned').val());
        $('#submitform').submit();
    }
    function SuccMsgFun(id, msg) {
        $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger');
        $("#msgDiv").addClass('alert alert-success alert-autocloseable-success');
        $("#msgDiv").html("<center>" + msg + "</center>");
        $("#" + id).focus();
        return true;
    }
    function ErrorMsgFun(id, msg) {
        $("#msgDiv").removeClass('alert alert-success alert-autocloseable-success');
        $("#msgDiv").addClass('alert alert-danger alert-autocloseable-danger');
        $("#msgDiv").html("<center>" + msg + "</center>");
        $("#" + id).focus();
        return false;
    }
    function getRights() {
        var RightStr = "";
        var DbGroup = "";
        var last = '';
        $("#tree input[type=checkbox]").each(function () {
            if ($(this).val() == "HO" && $(this).is(':checked') && !$(this).prop('indeterminate') /*&& !$(this).is(':unchecked')*/) {
                RightStr += "0:HO,";
                DbGroup = "0:";
                return false;
            }
            if ($(this).is(':checked') || $(this).prop('indeterminate')) {
                var test = $(this).val();
                if ($.isNumeric(test)) {
                    RightStr = RightStr.substr(0, RightStr.length - 1);
                    RightStr += "#" + $(this).val() + ":";
                    DbGroup += $(this).val() + ":";
                }
                else {
//                            last   chanchal
                    last = test.substring(test.lastIndexOf("@") + 1, test.length);
                    var val = $(this).val().substr(0, $(this).val().length - 1);
                    if (last > 9) {
                        val = val.slice(0, -1);
                    }
                    RightStr += val;
                }
            }
        });
        RightStr = RightStr.substr(0, RightStr.length - 1);
        RightStr = RightStr.substr(1);
        DbGroup = DbGroup.substr(0, DbGroup.length - 1);
        $('#dbgroup').val(DbGroup);
        return RightStr;
    }
</script>