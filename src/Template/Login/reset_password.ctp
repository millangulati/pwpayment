<?php
echo $this->Html->div('logo');
echo $this->Html->link($this->Html->image(\Configure::read('login_logo'), array("alt" => "Logo", "style" => "width:auto;height:45px;")), '/', array('escape' => false));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('content');
echo $this->Html->para('form-title font-green', isset($response['authMessage']) ? $response['authMessage'] : '&nbsp', array('style' => 'font-size: 20px; font-weight: bold;'));
echo $this->Form->create('Reset', array('url' => array('controller' => \Configure::read('masterController'), 'action' => 'reset'), 'class' => 'login-form', 'target' => '_self', "autocomplete" => "off"));
echo $this->Html->div('form-group has-feedback');
echo $this->Form->input('login', array('label' => FALSE, 'div' => FALSE, 'placeholder' => 'Login Name', 'value' => '', 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group has-feedback');
echo $this->Form->input('mno', array('type' => 'tel', 'label' => FALSE, 'div' => FALSE, 'placeholder' => 'Registered Mobile No.', 'value' => '', 'class' => 'form-control', 'maxlength' => 10, 'onkeyup' => "if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Form->label('or', 'OR', 'text-center no-border text-red');

echo $this->Html->div('form-group has-feedback');
echo $this->Form->input('emailid', array('type' => 'email', 'label' => FALSE, 'div' => FALSE, 'placeholder' => 'Registered Email ID', 'value' => '', 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Form->end(array('label' => 'Submit', 'div' => array(
	'class' => 'form-actions',
    ), 'onclick' => 'return validateChangePass();', 'class' => 'btn green uppercase'));
echo $this->Form->postButton('Back To login', array('controller' => \Configure::read('masterController'), 'action' => 'login'), array('method' => 'POST', 'target' => '_self', 'class' => 'btn-link forget-password'));
echo $this->Html->useTag('tagend', 'div');
?>
<script>
    function validateChangePass() {
        var emailrule = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var mnorule = /(?=^.{10}$)([789]{1})([0-9]{9})$/;
        if ($.trim($("#login").val()) === "") {
            alert("Enter Login Name");
            $("#login").focus();
            return false;
        } else if ($.trim($("#mno").val()) === "" && $.trim($("#emailid").val()) === "") {
            alert("Enter Mobile No. / Email ID");
            $('#mno').focus();
            return false;
        } else if ($.trim($("#mno").val()) !== "" && !mnorule.test($('#mno').val())) {
            alert('Invalid Mobile No.');
            $('#mno').focus();
            return false;
        } else if ($.trim($("#emailid").val()) !== "" && !emailrule.test($('#emailid').val())) {
            alert('Invalid Email ID');
            $('#emailid').focus();
            return false;
        } else {
            return true;
        }
    }
</script>
