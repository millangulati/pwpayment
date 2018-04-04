<?php
echo $this->Html->div('logo');
echo $this->Html->link($this->Html->image(\Configure::read('login_logo'), array("alt" => "Logo", "style" => "width:auto;height:45px;")), '/', array('escape' => false));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('content');
echo $this->Html->para('form-title font-green', isset($response['authMessage']) ? $response['authMessage'] : \Configure::read('login_text'), array('style' => 'font-size: 20px; font-weight: bold;'));
echo $this->Form->create('Login', array('url' => array('controller' => \Configure::read('masterController'), 'action' => 'login'), 'class' => 'login-form', 'target' => '_self', "autocomplete" => "off"));

echo $this->Html->div('form-group has-feedback');
echo $this->Form->input('login', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Login Name', 'value' => '', 'class' => 'form-control'));
//echo $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-user form-control-feedback'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('form-group has-feedback');
echo $this->Form->password('pass', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Password', 'value' => '', 'class' => 'form-control'));
//echo $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-lock form-control-feedback'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Form->input('loginname', array('type' => 'hidden', 'value' => ''));
echo $this->Form->input('password', array('type' => 'hidden', 'value' => ''));
echo $this->Form->unlockField('loginname');
echo $this->Form->unlockField('password');
echo $this->Form->end(array('label' => 'Sign In', 'div' => array(
	'class' => 'form-actions',
    ), 'onclick' => 'return validateLogin();', 'class' => 'btn green uppercase'));
echo $this->Form->postButton('Forgot password ?', array('controller' => \Configure::read('masterController'), 'action' => 'reset'), array('method' => 'POST', 'target' => '_self', 'class' => 'btn-link forget-password'));
echo $this->Html->useTag('tagend', 'div');

/*
  echo $this->Html->div('login-box');
  echo $this->Html->div('login-box-body');
  echo $this->Html->div('login-logo', $this->Html->image(\Configure::read('login_logo'), array('alt' => 'Logo', 'style' => 'width:auto;height:45px;')));
  echo $this->Html->para('text-info text-center', isset($response['authMessage']) ? $response['authMessage'] : \Configure::read('login_text'), array('style' => 'font-size: 20px; font-weight: bold;'));
  echo $this->Form->create('Login', array('url' => array('controller' => \Configure::read('masterController'), 'action' => 'login'), 'target' => '_self', "autocomplete" => "off"));
  echo $this->Html->div('form-group has-feedback');
  echo $this->Form->input('login', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Login Name', 'value' => '', 'class' => 'form-control'));
  echo $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-user form-control-feedback'));
  echo $this->Html->useTag('tagend', 'div');
  echo $this->Html->div('form-group has-feedback');
  echo $this->Form->password('pass', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Password', 'value' => '', 'class' => 'form-control'));
  echo $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-lock form-control-feedback'));
  echo $this->Html->useTag('tagend', 'div');
  echo $this->Form->input('loginname', array('type' => 'hidden', 'value' => ''));
  echo $this->Form->input('password', array('type' => 'hidden', 'value' => ''));
  echo $this->Form->unlockField('loginname');
  echo $this->Form->unlockField('password');
  echo $this->Form->end(array('label' => 'Sign In', 'onclick' => 'return validateLogin();', 'class' => 'btn btn-primary btn-block btn-flat'));
  echo $this->Form->postButton('I forgot my password', array('controller' => \Configure::read('masterController'), 'action' => 'reset'), array('method' => 'POST', 'target' => '_self', 'class' => 'btn-link'));
  echo $this->Html->useTag('tagend', 'div');
  echo $this->Html->useTag('tagend', 'div');
 */
?>
<script>
    function validateLogin() {
        if ($.trim($("#login").val()) === "") {
            alert("Enter Login Name");
            return false;
        } else if ($.trim($("#pass").val()) === "") {
            alert("Enter Password");
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
            data: 'p=login',
            async: false,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            success: function (data) {

                if (data['error'] || data['authMessage']) {
                    alert(data['error'] ? data['msg'] : data['authMessage']);
                } else {
                    $("#loginname").val(base64_encode($("#login").val()));
                    $("#password").val(base64_encode(MD5(MD5($("#pass").val()).toUpperCase() + data['skey'])));
                    $("#login,#pass").val('');
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
