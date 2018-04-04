<?php
$gdate = new DateTime();
$curdate = $gdate->Format('d-m-Y');
$listArr = isset($response["list"]) ? $response["list"] : array();
$code = isset($response['partycode']) ? $response['partycode'] : '';

echo $this->Html->css('chosen.bootstrap.min');
echo $this->Html->script('chosen.jquery.min');
$allstate = isset($response["state"]) ? $response["state"] : array();

echo $this->Html->div("row", NULL, array("id" => "staterow"));
echo $this->Html->div('col-sm-6', $this->Form->label('state', 'Select State'), array('id' => 'db_sernolabel'));
echo $this->Form->input("db_serno", array("id" => "db_serno", "label" => FALSE, 'div' => array('class' => 'col-sm-6 form-group'), 'options' => $allstate, 'empty' => "Select State", "class" => "form-control", 'disabled' => isset($response['list']) ? TRUE : FALSE));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div("row", NULL, array("id" => "partycoderow"));
echo $this->Html->div('col-sm-6 form-group', $this->Form->label('partycode', 'Search(Party Code/ Login Name)'));
echo $this->Html->div("col-sm-6 form-group");
echo $this->Html->div("input-group input-group-md");
echo $this->Form->input("partycode", array('value' => $code, "label" => FALSE, "class" => "form-control", 'readonly' => isset($response['list']) ? TRUE : FALSE));
echo $this->Html->tag('span class="input-group-btn"', $this->Form->button('FIND', array('id' => 'find', 'class' => 'btn btn-info btn-flat', 'type' => 'button', 'disabled' => isset($response['list']) ? TRUE : FALSE)));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');


if (isset($response["list"]) && count($response["list"]) > '0') {
    echo $this->Html->div('row', null, array('id' => 'partydiv'));
    echo $this->Html->div('col-sm-6', $this->Form->label('party', 'Select Party'), array('id' => 'partylabel'));
    echo $this->Form->input("list", array("id" => "list", "label" => FALSE, 'div' => array('class' => 'col-sm-6 form-group'), 'empty' => '--Select--', is_array($listArr) ? "options" : "value" => $listArr, "class" => "form-control"));
    echo $this->Html->useTag('tagend', 'div');
}

echo $this->Html->div("row", NULL, array("id" => "fromdaterow"));
echo $this->Html->div('col-sm-6 form-group', $this->Form->label('fromdate', 'From Date', array('id' => 'fromlabel')));
echo $this->Html->div('col-sm-6 form-group has-feedback');
echo $this->Form->input("fromdate", array("id" => "fromdate", "label" => FALSE, 'placeholder' => 'Select From Date', 'value' => $curdate, "class" => "form-control"));
echo $this->Html->tag('span', '', array('class' => "glyphicon glyphicon-calendar form-control-feedback", 'style' => "text-align: left;z-index:0;"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div("row", NULL, array("id" => "todaterow"));
echo $this->Html->div('col-sm-6 form-group', $this->Form->label('todate', 'To Date', array('id' => 'tolabel')));
echo $this->Html->div('col-sm-6 form-group has-feedback');
echo $this->Form->input("todate", array("id" => "todate", "label" => FALSE, 'placeholder' => 'Select To Date', 'value' => $curdate, "class" => "form-control"));
echo $this->Html->tag('span', '', array('class' => "glyphicon glyphicon-calendar form-control-feedback", 'style' => "text-align: left;z-index:0;"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
?>
<script>
    $("#document").ready(function () {

        $("#partycode,#db_serno,#todate,#fromdate").click(function () {
            $("#msgDiv").html('&nbsp;');
        });
        $('#fromdate').datepicker({maxDate: 0, dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true});
        $('#todate').datepicker({maxDate: 0, dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true});
        $('#db_serno').chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!"
        });
    });
</script>
