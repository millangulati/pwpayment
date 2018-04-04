<?php
$LoginAccessStr = isset($response["loginAccessdays"]) ? $response["loginAccessdays"] : '';
$LoginAccess = isset($response["loginAccessdays"]) ? explode(",", $LoginAccessStr) : array();
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
//pr($LoginAccessStr);
$curtime = date("H:i:s");
$time = date("H:i");

echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'clockpicker', 'security.min'));

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-user-plus font-green-sharp"></i>';
echo $this->Html->tag('span', 'Create New User', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');

echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //main portlet-body
echo $this->Form->create('Bo', array("id" => "createuser", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->input('pass', array('id' => 'pass', 'class' => 'inputBox1', 'type' => "hidden"));
$this->Form->unlockField("pass");
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->input('access', array('id' => 'access', 'class' => 'inputBox1', 'type' => "hidden"));
$this->Form->unlockField("access");
echo $this->Form->hidden("dayaccess", array("value" => '', 'id' => 'dayaccess'));
$this->Form->unlockField("dayaccess");
echo $this->Html->div('portlet-title'); /// lgin details
echo '<i class="fa fa-user-secret font-green-sharp"></i>';
echo $this->Html->tag('span', ' Login Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('portlet-body'); //

echo $this->Html->div('row');
echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('loginname', array('id' => 'loginname', 'label' => 'Login Name', 'div' => FALSE, 'maxlength' => '20', 'onblur' => 'checklogin()', 'class' => 'form-control')));

echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('password', array('id' => 'password', 'label' => 'Password', 'div' => FALSE, 'class' => 'form-control', "type" => "password")));
echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('cnfpassword', array('id' => 'cnfpassword', 'label' => 'Confirm Password', 'div' => FALSE, 'class' => 'form-control', "type" => "password")));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div'); // lgin details end
echo "<hr>";
echo $this->Html->div('portlet-title'); /// User details
echo '<i class="fa fa-user font-green-sharp"></i>';
echo $this->Html->tag('span', ' User Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('portlet-body'); //

echo $this->Html->div('row');
echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('fullname', array('id' => 'fullname', 'label' => 'Full Name', 'div' => FALSE, 'class' => 'form-control', 'onkeyup' => 'EnterAlphaOnly(this)')));

echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('mobileno', array('id' => 'mobileno', 'label' => 'Mobile Number', 'div' => FALSE, 'class' => 'form-control', 'onkeyup' => 'EnterNumericKeyOnly(this)', 'maxlength' => "10")));
echo $this->Html->div('col-md-4  col-sm-6 form-group', $this->Form->input('emailid', array('id' => 'emailid', 'label' => 'Email Id', 'div' => FALSE, 'class' => 'form-control', "type" => 'mail')));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->useTag('tagend', 'div'); // User details end
echo "<hr>";
//
//
echo $this->Html->div('portlet-title'); /// Access details
echo '<i class="fa  fa-clock-o font-green-sharp"></i>';
echo $this->Html->tag('span', ' Access Durations', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('portlet-body'); //
echo $this->Html->div('row');

echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('start_time', array('id' => 'start_time', 'readonly' => true, 'label' => 'Start Time', 'div' => FALSE, 'class' => 'form-control')));
echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('end_time', array('id' => 'end_time', 'label' => 'End Time', 'readonly' => true, 'div' => FALSE, 'class' => 'form-control')));
echo $this->Html->div('col-md-4 col-sm-6 form-group');
echo " <label for='fullaccess' class='btn btn-primary fullbtn'>Select For Full Access Of Panel. <input type='checkbox' id='fullaccess' class='badgebox'><span class='badge'>&check;</span></label>";
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div'); // access details end
echo "<hr>";
echo $this->Form->end();
echo $this->Html->div('portlet-title'); /// Branch Rights
echo '<i class="fa fa-user-md font-green-sharp"></i>';
echo $this->Html->tag('span', ' Access Days', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('portlet-body'); //
echo $this->Html->div('row');
$disableAll = ($LoginAccessStr == '0,1,2,3,4,5,6') ? '' : 'disabled';
echo "<div class = 'col-md-12 col-sm-12 col-xs-12 '><div class='chkallclass form-group'><input name='chk_alldays' id='chk_alldays' autocomplete='off' type='checkbox' class='hidden $disableAll' onclick = 'return chk_all();' $disableAll ><div class='btn-group'><label for='chk_alldays' class=' btn green $disableAll'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='chk_alldays' class='btn btn-default $disableAll ' style='width: 160px;'>Select All </label></div></div></div>";
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('row');
foreach ($days as $key => $value) {
    $disable = in_array($key, \array_values($LoginAccess)) ? '' : 'disabled';
    echo "<div class = 'col-md-4 col-sm-4 col-xs-12'><div class='form-group'><input name=$key id=$key autocomplete='off' type='checkbox' class='dayslist hidden $disable' $disable><div class='btn-group'><label for=$key class='btn green $disable'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for=$key class='btn btn-default active $disable' style='width: 160px;'>$value</label></div></div></div>";
}
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->useTag('tagend', 'div'); // Branch Rights end



echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
?>

<style>
    .badgebox{opacity: 0;}
    .badgebox + .badge{text-indent: -999999px; width: 27px;}
    .badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
    .badgebox:checked + .badge{ text-indent: 0;}
    .fullbtn { background-color: #8D9BB2;        margin-top: 31px;width: 392px;}
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

</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var olduser = '';
    var userflag = '';
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var passrule = /(?=^.{8,24}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%=:.]*$/;
    $('#document').ready(function () {
        $("#mobileno,#emailid,#loginname,#password,#cnfpassword,#fullname,#start_time,#end_time").val('');
        $("#mobileno,#emailid,#loginname,#password,#cnfpassword,#fullname,#start_time,#end_time,#fullaccess,.ulclass1").click(function () {
            if ($("#msgDiv").text() == 'Login Name Is Available.' || $("#msgDiv").text() == 'Login Name Is Already Exist.' || $("#msgDiv").text() == 'Password And Confirm Password Are Not Matched.' || $("#msgDiv").text() == 'Password Matched.') {
                return true;
            }
            else {
                $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger,alert alert-success alert-autocloseable-success');
                $("#msgDiv").html("&nbsp");
            }
        });
        if (sucmsg != '') {
            SuccMsgFun('loginname', 'New User Added Successfully');
        }
        if (msg != '') {
            ErrorMsgFun('loginname', msg);
        }
        $('#start_time,#end_time').clockpicker();
        $('#start_time,#end_time').on('change', function () {
            let
            receivedVal = $(this).val();
            $(this).val(receivedVal + ":00");
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
        $("#cnfpassword").blur(function () {
            if ($("#cnfpassword").val() != '') {
                if ($("#password").val() != $("#cnfpassword").val()) {
                    return ErrorMsgFun('cnfpassword', 'Password And Confirm Password Are Not Matched.');
                    $("#cnfpassword").val("");
                } else {
                    return SuccMsgFun('cnfpassword', 'Password Matched.');
                }
            }
            else {
                return ErrorMsgFun('cnfpassword', 'Please Enter Confirm Password.');
            }
        });
        $("#submitbtn").click(function () {
            $('#start_time,#end_time').attr("disabled", false);
            var regexemobile = /^[789]+\d{9}$/;
            if ($("#loginname").val() != '') {
                if (userflag != 'Login Name Is Available.' && userflag != '') {
                    return  ErrorMsgFun(loginname, userflag);
                }
            } else {
                return ErrorMsgFun('loginname', 'Login Name Field Is Empty.');
            }
            if ($('#password').val() == "") {
                return ErrorMsgFun('password', 'Passeord Field Can Not be Empty');
            }
            else if (!passrule.test($("#password").val())) {
                return ErrorMsgFun('password', 'Please enter Valid Password');
                $("#password").val("");
            }
            else if ($("#password").val() != $("#cnfpassword").val()) {
                return ErrorMsgFun('cnfpassword', 'Password And Confirm Password Are Not Matched.');
                $("#cnfpassword").val("");
            }
            if ($('#cnfpassword').val() == "") {
                return ErrorMsgFun('cnfpassword', 'Confirm Passeord Field Can Not be Empty');
            }
            if ($('#fullname').val() == "") {
                return ErrorMsgFun('fullname', 'Full Name Field Can Not be Empty.');
            }
            if ($('#mobileno').val() == "") {
                return ErrorMsgFun('mobileno', 'Mobile Number Field Can Not be Empty.');
            } else if (!regexemobile.test($("#mobileno").val())) {

                return ErrorMsgFun('mobileno', 'Please enter Valid Mobile Number');
            }
            if ($("#emailid").val() != '') {
                if (!checkEmailValue('emailid')) {
                    return ErrorMsgFun('emailid', 'Invalid Email');
                }
            } else {
                return ErrorMsgFun('emailid', 'Email Field Can Not Be Empty.');
            }
            if ($('#start_time').val() == "") {
                return ErrorMsgFun('start_time', 'Please Select Start Time To Access For This User.');
            }
            if ($('#end_time').val() == "") {
                return ErrorMsgFun('end_time', 'Please Select End Time To Access For This User.');
            }
            chkDaysFun();
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
            var pass = MD5($("#password").val());
            $("#password").val("");
            $("#cnfpassword").val("");
            $("#pass").val(pass.toUpperCase());
            $('#createuser').submit();
        });
    });
    function checklogin() {
        if ($("#loginname").val() != '' && $("#loginname").val() != olduser) {
            olduser = $("#loginname").val();
            var url = baseUrl + "/CheckLogin";
            var dataSet = 'AuthVar=' + authvar + '&loginname=' + $("#loginname").val();
            $('#loaderDiv').show();
            AsyncAjaxRequest(url, dataSet, checkloginresp);
        }
    }
    function checkloginresp(status, data) {
        $('#loaderDiv').hide();
        if (status === 200) {
            var JSONObject = JSON.parse(data);
            if (JSONObject['tag'] == "#SUCCESS:") {
                delete JSONObject["tag"];
                if (JSONObject['error'] == true) {
                    userflag = JSONObject['message'];
                    return ErrorMsgFun('loginname', userflag);
                }
                else {
                    if (JSONObject['data'] != 'TRUE') {
                        userflag = 'Login Name Is Available.';
                        return SuccMsgFun('loginname', userflag);
                    }
                    else {
                        userflag = 'Login Name Is Already Exist.';
                        return ErrorMsgFun('loginname', userflag);
                    }
                }
            }
            else {
                return ErrorMsgFun('loginname', JSONObject["tag"]);
            }
        }
        else {
            return ErrorMsgFun('loginname', 'Error in Response.Please refresh and try again');
        }
    }
    function SuccMsgFun(id, msg) {
        $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger');
        $("#msgDiv").addClass('alert alert-success alert-autocloseable-success');
        $("#msgDiv").html("<center>" + msg + "</center>");
//        $("#" + id).focus();
        return true;
    }
    function ErrorMsgFun(id, msg) {
        $("#msgDiv").removeClass('alert alert-success alert-autocloseable-success');
        $("#msgDiv").addClass('alert alert-danger alert-autocloseable-danger');
        $("#msgDiv").html("<center>" + msg + "</center>");
        $("#" + id).focus();
        return false;
    }
    function chk_all() {
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