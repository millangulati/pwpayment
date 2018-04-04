<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$userData = isset($response["userInformation"]) ? $response["userInformation"] : array();
$userDataLoginname = isset($response["userInformation"]) ? $response["userInformation"]['Loginname'] : '';
$AccessDay = isset($response["userInformation"]) ? $response["userInformation"]["Accessdays"] : "";
$curtime = date("H:i:s");
$time = date("H:i");
echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'clockpicker', 'security.min'));

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa  fa-edit font-green-sharp"></i>';
echo $this->Html->tag('span', 'Update User Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return submitformfun();'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Edit', array('id' => 'editbtn', 'type' => 'button', 'class' => 'btn green form-control'));
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
    echo $this->Html->div('', null, array('id' => 'editDiv'));
    echo $this->Html->div('portlet-title'); /// User details
    echo '<i class="fa fa-user font-green-sharp"></i>';
    echo $this->Html->tag('span', ' Update User Details', array('class' => 'caption-subject font-green-sharp bold uppercase'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('portlet-body'); //

    echo $this->Html->div('row');
    echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('fullname', array('id' => 'fullname', 'label' => 'Full Name', 'div' => FALSE, 'class' => 'form-control', 'value' => $userData['Username'], 'onkeyup' => 'EnterAlphaOnly(this)')));

    echo $this->Html->div('col-md-4 col-sm-6 form-group', $this->Form->input('mobileno', array('id' => 'mobileno', 'label' => 'Mobile Number', 'div' => FALSE, 'class' => 'form-control', 'onkeyup' => 'EnterNumericKeyOnly(this)', 'maxlength' => "10", 'value' => $userData['Phone'])));
    echo $this->Html->div('col-md-4  col-sm-6 form-group', $this->Form->input('emailid', array('id' => 'emailid', 'label' => 'Email Id', 'div' => FALSE, 'class' => 'form-control', "type" => 'mail', 'value' => $userData['EmailId'])));
    echo $this->Html->useTag('tagend', 'div');

    echo "<hr>";
    echo $this->Html->useTag('tagend', 'div'); // User details end
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Form->end();
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
    .alert {line-height: 3px;margin-bottom: -15px;}
</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var userLoginname = "<?= $userDataLoginname ?>";
    var AccessDay = "<?= $AccessDay ?>";
    var regexemobile = /^[789]+\d{9}$/;
    $('#document').ready(function () {
        if (userLoginname == '') {
            $(".tools").hide();
        }
        else {
            $(".tools").show();
            $("#userloginname").val(userLoginname);
            $("#submitbtn,#editDiv").hide();
        }
        if (sucmsg != '') {
            SuccMsgFun('loginname', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('loginname', msg);
        }
        $("#mobileno,#emailid,#fullname,#editbtn,#loginname").click(function () {
            $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger,alert alert-success alert-autocloseable-success');
            $("#msgDiv").html("&nbsp");
        });
        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        $("#editbtn").click(function () {
            $("#submitbtn,#editDiv").show();
            $("#editbtn").hide();
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


</script>