<?php
$flag = isset($response["flag"]) ? $response['flag'] : array();
$States = isset($response["States"]) ? $response["States"] : array();
$branches = isset($response["branches"]) ? $response["branches"] : array();
$auth = isset($response["auth"]) ? $response['auth'] : array();
//pr($auth);
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');

echo $this->Html->div('caption');
echo '<i class="fa fa-user-plus font-green-sharp"></i>';
echo $this->Html->tag('span', "Change $flag", array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return submitformfun();'));
echo $this->Html->useTag('tagend', 'div');

//echo $this->Html->div('tools');
//echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
//echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //main portlet-body
echo $this->Form->create('Bo', array("name" => "submitform", 'id' => 'submitform', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->hidden('flag', array('value' => ''));
$this->Form->unlockField("flag");
echo $this->Form->hidden('action', array('value' => ''));
$this->Form->unlockField("action");
echo $this->Html->div('', null, array('id' => 'stateDiv'));
echo $this->Html->div("row");
//echo $this->Html->div('col-sm-2 form-group', '');
echo $this->Html->div('col-sm-2 form-group', $this->Form->label('state', 'Select State'));
echo $this->Form->input("state", array("id" => "state", "label" => FALSE, 'div' => array('class' => 'col-sm-4 form-group'), 'options' => $States, 'empty' => 'Select State', "class" => "form-control"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', null, array('id' => 'branchDiv'));
echo $this->Html->div("row");
//echo $this->Html->div('col-sm-2 form-group', '');
echo $this->Html->div('col-sm-2 form-group', $this->Form->label('branch', 'Select Branch'));
echo $this->Form->input("branch", array("id" => "branch", "label" => FALSE, 'div' => array('class' => 'col-sm-4 form-group'), 'options' => $branches, 'empty' => 'Select Branch', "class" => "form-control"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
?>
<style>
    .alert {line-height: 0px;margin-bottom: -15px;}
</style>
<script>
    var flag = '<?= $flag ?>';
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    $('#document').ready(function () {
        if (flag == 'State') {
            $("#branchDiv").hide();
        } else if (flag == 'Branch') {
            $("#stateDiv").hide();
        }
        if (sucmsg != '') {
            SuccMsgFun('loginname', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('loginname', msg);
        }
        $("#state,#branch").click(function () {
            $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger,alert alert-success alert-autocloseable-success');
            $("#msgDiv").html("&nbsp");
        });
    });
    function submitformfun() {
        if (flag == 'State') {
            if ($("#state").val() == '') {
                return ErrorMsgFun('state', 'Please Select State.');
            }
        }
        $('#flag,#action').val(flag);
        $('#submitform').submit();
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
</script>