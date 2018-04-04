<?php
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-cog font-green-sharp"></i>';
echo $this->Html->tag('span', 'Change Password', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
echo $this->Html->div('col-sm-12');


//echo $this->Html->div('content');
echo $this->Html->para('form-title font-green', isset($response['authMessage']) ? $response['authMessage'] : '&nbsp', array('style' => 'font-size: 20px; font-weight: bold;'));
//echo $this->Html->para('form-title font-green', isset($response['authMessage']) ? $response['authMessage'] : \Configure::read('login_text'), array('style' => 'font-size: 20px; font-weight: bold;'));
echo $this->Form->create('Login', array('url' => array('controller' => \Configure::read('masterController'), 'action' => 'ChangePasswd'), 'class' => 'login-form', 'target' => '_self', "autocomplete" => "off"));
echo $this->Form->hidden('AuthVar', array('value' => $response["AuthVar"]));
echo $this->Html->div('form-group has-feedback');
echo $this->Form->label('old_password', 'Old Password', array('class' => 'col-md-3 control-label no-padding-right'));
echo $this->Html->div('col-md-8 form-group');
echo $this->Form->password('oldpass', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Enter Old Password', 'value' => '', 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('form-group has-feedback');
echo $this->Form->label('new_password', 'New Password', array('class' => 'col-md-3 control-label no-padding-right'));
echo $this->Html->div('col-md-8 form-group');
echo $this->Form->password('newpass', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Enter New Password', 'value' => '', 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('form-group has-feedback');
echo $this->Form->label('confirm_password', 'Confirm Password', array('class' => 'col-md-3 control-label no-padding-right'));
echo $this->Html->div('col-md-8 form-group');
echo $this->Form->password('repass', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Re-Enter New Password', 'value' => '', 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Form->input('loginname', array('type' => 'hidden', 'value' => ''));
echo $this->Form->input('password', array('type' => 'hidden', 'value' => ''));
echo $this->Form->unlockField('loginname');
echo $this->Form->unlockField('password');
echo $this->Form->end(array('label' => 'Submit', 'div' => array(
	'class' => 'form-actions',
	'style' => 'width:100%;float:left;margin-top:20px;margin-left:14px;',
    ), 'onclick' => 'return validateChangePass();', 'class' => 'btn green uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
?>
<script>
    function validateChangePass() {
        var passrule = /(?=^.{8,16}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%=:.]*$/;
        if ($.trim($("#oldpass").val()) == "") {
            alert("Enter Old Password");
            $("#oldpass").focus();
            return false;
        } else if ($.trim($("#newpass").val()) == "") {
            alert("Enter New Password");
            $('#newpass').focus();
            return false;
        } else if ($('#oldpass').val() == $('#newpass').val()) {
            alert('New Password And Old Password Are Same. Kindly Choose A New One.');
            $('#newpass').focus();
            return false;
        } else if (!passrule.test($('#newpass').val())) {
            alert('Password Must Conatin atleast One Of Each UpperCase,LowerCase,SpecialCharacter(@,#,$,%,=,:) And Number... And Must Be 8-16 Chars Long');
            $('#newpass').focus();
            return false;
        } else if ($.trim($('#repass').val()) == '') {
            alert('Re-Enter Password');
            $('#repass').focus();
            return false;
        } else if ($('#newpass').val() != $('#repass').val()) {
            alert("New Password and Re-Enter Password Don't match");
            $('#repass').focus();
            return false;
        } else {
            return EncreptCredential();
        }
    }
    function EncreptCredential() {
        $('#loaderDiv').show();
        var flag = false;
        $.ajax({
            url: 'salt',
            type: 'POST',
            data: 'p=changepass',
            async: false,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            success: function (data) {
                if (data['error'] || data['authMessage']) {
                    alert(data['error'] ? data['msg'] : data['authMessage']);
                } else {
                    $('#oldpass').val(MD5(MD5($('#oldpass').val()).toUpperCase() + data['skey']));
                    $('#newpass').val(base64_encode(data['skey'] + base64_encode($('#newpass').val())));
                    $('#repass').val(MD5(MD5($('#repass').val()).toUpperCase() + data['skey']));
                    flag = true;
                }
            },
            error: function () {
                alert("Something went wrong please refresh and try again.");
            }
        });
        $('#loaderDiv').hide();
        return flag;
    }
</script>
