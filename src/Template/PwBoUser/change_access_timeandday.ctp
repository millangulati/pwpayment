<?php
$LoginAccessStr = isset($response["loginAccessdays"]) ? $response["loginAccessdays"] : '';
$LoginAccess = isset($response["loginAccessdays"]) ? explode(",", $LoginAccessStr) : array();
//pr($LoginAccess);
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$userData = isset($response["userInformation"]) ? $response["userInformation"] : array();
$userDataLoginname = isset($response["userInformation"]) ? $response["userInformation"]['Loginname'] : '';
$AccessDay = isset($response["userInformation"]) ? $response["userInformation"]["Accessdays"] : "";
$SearchAccess = \explode(",", $AccessDay);
$curtime = date("H:i:s");
$time = date("H:i");
echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'clockpicker', 'security.min'));

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-clock-o font-green-sharp"></i>';
echo $this->Html->tag('span', 'Change Access Days And Time', array('class' => 'caption-subject font-green-sharp bold uppercase'));
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
    echo $this->Form->input('loginname', array("id" => "loginname", "label" => FALSE, 'div' => array('class' => 'col-md-3 col-sm-4 form-group'), 'value' => '', "class" => "form-control"));
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
    echo $this->Form->hidden("dayaccess", array("value" => '', 'id' => 'dayaccess'));
    $this->Form->unlockField("dayaccess");
    echo $this->Form->hidden("userloginname", array("value" => '', 'id' => 'userloginname'));
    $this->Form->unlockField("userloginname");
    echo $this->Html->div('portlet-title'); /// User details
    echo '<i class="fa fa-user font-green-sharp"></i>';
    echo $this->Html->tag('span', ' User Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //

    echo $this->Html->div('row');

    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('userCode', 'User Code:');
    echo $this->Html->tag('span', $userData['Usercode'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('userName', 'User Name:');
    echo $this->Html->tag('span', $userData['Username'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('phoneNumber', 'Phone Number:');
    echo $this->Html->tag('span', $userData['Phone'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('email', 'Email id:');
    echo $this->Html->tag('span', $userData['EmailId'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('states', 'States:');
    echo $this->Html->tag('span', $userData['States'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div'); // User details end
    echo "<hr>";
    echo $this->Html->div('portlet-title'); /// Access details
    echo '<i class="fa  fa-clock-o font-green-sharp"></i>';
    echo $this->Html->tag('span', ' Access Durations', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //
    echo $this->Html->div('row');

    echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('start_time', array('id' => 'start_time', 'value' => $userData['Start_Time'], 'readonly' => true, 'label' => 'Start Time', 'div' => FALSE, 'class' => 'form-control')));
    echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('end_time', array('id' => 'end_time', 'label' => 'End Time', 'value' => $userData['End_Time'], 'readonly' => true, 'div' => FALSE, 'class' => 'form-control')));
    $checked = '';
    if ($userData['End_Time'] == '23:59:59' && $userData['Start_Time'] == '00:00:00') {
        $checked = 'checked';
    }
    echo $this->Html->div('col-md-4 col-sm-6 form-group');
    echo " <label for='fullaccess' class='btn btn-primary fullbtn'> Full Day Access. <input type='checkbox' id='fullaccess' $checked class='badgebox'><span class='badge'>&check;</span></label>";
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div'); // access details end
    echo "<hr>";
    echo $this->Html->div('portlet-title'); /// Branch Rights
    echo '<i class="fa fa-calendar font-green-sharp"></i>';
    echo $this->Html->tag('span', ' Access Days', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //
    $checked = '';

    echo $this->Html->div('row');
    $disableAll = ($LoginAccessStr == '0,1,2,3,4,5,6') ? '' : 'disabled';
    echo "<div class = 'col-md-12 col-sm-12 col-xs-12 '><div class='chkallclass form-group'><input name='chk_alldays' id='chk_alldays' autocomplete='off' type='checkbox' class='hidden $disableAll'  onclick = 'return chk_allfun();' $disableAll ><div class='btn-group'><label for='chk_alldays' class=' btn green $disableAll'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='chk_alldays' class='btn btn-default $disableAll' style='width: 160px;'>Select All </label></div></div></div>";
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('row');
    foreach ($days as $key => $value) {
        $disable = in_array($key, \array_values($LoginAccess)) ? '' : 'disabled';
        echo "<div class = 'col-md-4 col-sm-4 col-xs-12'><div class='form-group'><input name=$key id=$key autocomplete='off' type='checkbox' class='dayslist hidden $disable' $disable><div class='btn-group'><label for=$key class='btn green $disable'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for=$key class='btn btn-default active $disable' style='width: 160px;'>$value</label></div></div></div>";
    }
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div'); // Branch Rights end
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
    .fullbtn { background-color: #8D9BB2;        margin-top: 32px;width: 208px;}
    .aaa{background-color: #BCCAE1;}
    .abc { float:right; }
    .alert {line-height: 0px;margin-bottom: -15px;}
    .form-group input[type="checkbox"] {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span {
        width: 20px;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:first-child {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:last-child {
        display: inline-block;
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
        display: none;
    }
    .disabled{cursor: not-allowed;}
</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var userLoginname = "<?= $userDataLoginname ?>";
    var AccessDay = "<?= $AccessDay ?>";
    $('#document').ready(function () {
        if (userLoginname == '') {
            $(".tools").hide();
        }
        else {
            $(".tools").show();
            $("#userloginname").val(userLoginname);
            selectDaysFun();
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
        $('#start_time,#end_time').clockpicker();
        $('#start_time,#end_time').on('change', function () {
//            let
            receivedVal = $(this).val();
            $(this).val(receivedVal + ":00");
        });
        $('#fullaccess').change(function () {
            if ($(this).is(":checked")) {
                $("#access").val('1');
                $('#start_time').val("00:00:00");
                $('#start_time').attr("disabled", true);
                $('#end_time').val("23:59:59");
                $('#end_time').attr("disabled", true);
            }
            else {
                $("#access").val('0');
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                $('#start_time').val(time);
                $('#start_time').attr("disabled", false);
                $('#end_time').val(time);
                $('#end_time').attr("disabled", false);
            }
        });
        $('#start_time,#end_time').change(function () {
            if ($('#start_time').val() != "00:00:00" || $('#end_time').val() != "23:59:59") {
                $("#fullaccess").removeAttr('checked');
            }
        });

        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        $('.dayslist').click(function () {
            var i = 0;
            $('.dayslist').each(function () {
                if (this.checked == true) {
                    i++;
                }
            });
            if (i == 7) {
                $("#chk_alldays").prop("checked", true);
            } else {
                $("#chk_alldays").prop("checked", false);
            }
        });
    });
    function validateLoginName() {
        if ($("#loginname").val() == '') {
            return ErrorMsgFun('loginname', 'Please enter login name.');
        } else {
            $('#searchUser').submit();
        }
    }
    function submitformfun() {
        chkDaysFun();
        if ($('#start_time,#end_time').val() == '') {
            return ErrorMsgFun('start_time', 'Please Select Access Time.');
        }
        var strt = $('#start_time').val().split(':');
        var endt = $('#end_time').val().split(':');
        if (strt[0] > endt[0]) {
            return ErrorMsgFun('start_time', 'Start Time Must Be Less Than End Time.');
        }
        else if (strt[0] == endt[0]) {
            if (strt[1] > endt[1]) {
                return ErrorMsgFun('start_time', 'Start Time Must Be Less Than End Time.');
            }
        }
        if ($('#start_time').val() == $('#end_time').val()) {
            return ErrorMsgFun('start_time', 'Start Time Can Not Be Equal To End Time.');
        }
        if ($('#dayaccess').val() == '') {
            return ErrorMsgFun('', 'Please Select A day.');
        }
        $('#start_time,#end_time').attr("disabled", false);
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
    function chk_allfun() {
        var checked1 = $('#chk_alldays').is(':checked');
        $('.dayslist').each(function () {
            var checkBox = $(this);
            if (checked1) {
                checkBox.prop('checked', true);
            } else {
                checkBox.prop('checked', false);
            }
        });
    }
    function selectDaysFun() {
        var x = AccessDay.split(",");
        for (var i = 0; i < x.length; i++) {
            var id = '#' + x[i];
            $(id).attr("checked", "checked");
        }
        var i = 0;
        $('.dayslist').each(function () {
            if (this.checked == true) {
                i++;
            }
        });
        if (i == 7) {
            $("#chk_alldays").attr("checked", "checked");
        }
    }
    function chkDaysFun() {
        var day = '';
        $('.dayslist').each(function () {
            if (this.checked == true) {
                day += "," + this.id;


            }
        });
        $('#dayaccess').val(day);

    }

</script>