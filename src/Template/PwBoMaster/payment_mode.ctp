<?php
$branchList = isset($response["branchList"]) ? $response["branchList"] : array();
$paymentModeList = isset($response["paymentMode"]) ? $response["paymentMode"] : array();
pr($response["res"]);
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-money font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Modes', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
echo $this->Html->div('col-sm-12');
//echo $this->Html->tag('H3', 'Payment Modes');
//echo $this->Html->para(isset($response["color"]) ? $response["color"] : "text-red", isset($response["msg"]) ? $response["msg"] : "&nbsp;", array('id' => 'msgDiv', "style" => "text-align:center"));
//echo $this->Html->para(isset($response["resultcolor"]) ? $response["resultcolor"] : "text-red", isset($response["record"]) ? $response["record"] : "&nbsp;", array('id' => 'msgDiv', "style" => "text-align:center"));
echo $this->Form->create('Bo', array("id" => "paymentmode", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));

foreach ($paymentModeList as $type => $mode) {
    echo $this->Html->div('box box-primary collapsed-box '); //collapsed-box
    echo $this->Html->div('box-header ui-sortable-handle pointhead', null, array('data-widget' => 'collapse', 'data-target' => "#activeStateDiv" . $type . "")); //
    echo $this->Html->div('box-tools fa fa-plus', null, array('style' => 'position:unset;display: inline-block;'));
    echo "<button class='btn btn-box-tool text-blue' data-widget='collapse'></button>";
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->tag('H4', $type, array('class' => 'box-title'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('box-body', NULL, array('id' => 'activemodes' . $type, 'class' => 'activemodes')); //box-body
    foreach ($mode as $modekey => $modevalue) {

        echo $this->Html->div('box collapsed-box');
        echo $this->Html->div('box-header pointhead', null, array('data-widget' => 'collapse', 'data-target' => "#activeStateDiv" . $modevalue['mode_id'] . ""));
        echo $this->Html->div('box-tools fa fa-plus', null, array('style' => 'position:unset;display: inline-block;'));
        echo "<button  class='btn btn-box-tool' data-widget='collapse'></button>";
        echo $this->Html->tag('H4', '&nbsp' . $modekey, array('class' => 'box-title', 'style' => 'color: rgba(1, 1, 39, 0.66);'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->div('row'); //row
        echo $this->Html->div('col-sm-7 col-md-10 ');
//        echo $this->Html->tag('H4', '&nbsp' . $modekey, array('class' => 'box-title'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->div('col-sm-3 col-md-2 pull-right', null, array('style' => "margin-top: -26px;"));
        echo $this->Form->button(($modevalue['status'] == 'Y' ? 'Inactive' : 'Active'), array('id' => 'submitbtn' . $modevalue['mode_id'], 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return submitFunc(\'' . $modevalue['mode_id'] . '\');'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div'); ////row end
        echo $this->Html->div('box-body'); //box-body inner
        $branch = explode(',', $modevalue['branchlist']);
        echo $this->Html->div('', NULL, array('id' => 'activeStateDiv' . $modevalue['mode_id'], 'class' => 'activeclass')); //activeStateDiv
        echo $this->Html->tag('H4', 'Active Branches : ', array('class' => 'box-header with-border '));
        echo $this->Html->div("row");
        foreach ($branch as $key => $value) {
            echo $this->Html->div('col-sm-4 form-group', $this->Form->label('activestate', $branchList[$value]));
        }
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->div('', NULL, array('id' => 'btnDiv' . $modevalue['mode_id'])); //btndiv
        echo $this->Html->div('row');
        echo $this->Html->div('col-sm-4 col-md-5', '');
        echo $this->Html->div('col-sm-4 col-md-2 form-group', $this->Form->button('Edit', array('id' => 'editBtn' . $modevalue['mode_id'], 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return editFunc(\'' . $type . '\',\'' . $modevalue['mode_id'] . '\',\'' . $modekey . '\');')));
//        echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->button(($modevalue['status'] == 'Y' ? 'Inactive' : 'Active'), array('id' => 'submitbtn' . $modevalue['mode_id'], 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return submitFunc((\'' . $modevalue['mode_id'] . '\');')));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div'); //activesateDiv end

        echo $this->Html->div('', NULL, array('id' => 'editstateDiv' . $modevalue['mode_id'], 'class' => 'editclass')); //editstateDiv

        echo $this->Html->tag('H4', ' Select Branches To Update : ', array('class' => 'box-header with-border'));
        echo $this->Html->div("row");
        echo $this->Html->div('col-xs-1 col-sm-1 col-md-1 chkclass ', $this->Form->checkbox('checkAll', array('id' => 'checkAll' . $modevalue['mode_id'], 'class' => "checkAll", 'onclick' => 'return chkAllFunc(\'' . $modevalue['mode_id'] . '\');')));
        echo $this->Html->div('col-xs-11 col-sm-5 col-md-3 lblclass', $this->Form->label('Select', 'Select All', array('id' => 'checklabel', 'class' => 'chk')));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->div("row");
        foreach ($branchList as $key => $value) {
            echo $this->Html->div(' col-xs-1 col-sm-1 col-md-1 chkclass', $this->Form->checkbox($value, array('id' => $modevalue['mode_id'] . '_' . $key, 'class' => "statename" . $modevalue['mode_id'])));
            echo $this->Html->div('col-xs-11 col-sm-5 col-md-3 lblclass ', $this->Form->label($value, $value, array('id' => 'checklabel', 'class' => 'chk')));
        }
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->div('', NULL, array('id' => 'editbtnDiv' . $modevalue['mode_id'], 'style' => 'margin-top: 20px;'));
        echo $this->Html->div('row');
        echo $this->Html->div('col-sm-3 col-md-3', '');
        echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->button('Back', array('id' => 'backBtn' . $modevalue['mode_id'], 'type' => 'button', 'class' => 'btn btn-danger form-control', 'onclick' => 'return backFunc(\'' . $modevalue['mode_id'] . '\');')));
        echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->button('Update', array('id' => 'updatebtn' . $modevalue['mode_id'], 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return updateFunc((\'' . $modevalue['mode_id'] . '\');')));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->useTag('tagend', 'div'); //editstateDiv end

        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div'); //box-body inner end
    }
    echo $this->Html->useTag('tagend', 'div'); //box-body end
    echo $this->Html->useTag('tagend', 'div'); //collapsed-box end
}

echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
?>
<style>
    .box { background: #ECF0F5 none repeat scroll 0% 0%;}
    .activeclass,.editclass {background-color: azure;}
    input[type="checkbox"]{margin-left: 15px;margin-top: 8px;}
    @media(max-width:500px){
        .chkclass {}
        .lblclass {margin-left: 62px;margin-top: -30px;}
    }
    .pointhead {
        cursor: pointer;
    }
    .box-header > .box-tools {
        color: #2b3b55;
    }

</style>
<script>
//    var modeStr = '< ?= json_encode($paymentModeList) ?>';
//    var modeList = JSON.parse(modeStr);
    var modeList = JSON.parse('<?= json_encode($paymentModeList) ?>');

    $('#document').ready(function () {
        $(".editclass").hide();
    });

    function updateFunc(id) {

    }
    function backFunc(id) {
        $("#editstateDiv" + id).hide();
        $("#activeStateDiv" + id).show();
    }
    function editFunc(type, id, idname) {
        $("#activeStateDiv" + id).hide();
        $("#editstateDiv" + id).show();
        $.each(modeList, function (modeKey, modeName) {
            if (modeKey == type) {
                $.each(modeName, function (mode, modeData) {
                    if (mode == idname) {
                        var array = JSON.parse("[" + modeData['branchlist'] + "]");
                        array.forEach(function (item) {
                            $('#' + id + '_' + item).prop('checked', true);
                        });
                    }
                });
            }
        });
    }
    function chkAllFunc(id) {
        var checked = $('#checkAll' + id).is(':checked');
        $('.statename' + id).each(function () {
            var checkBox = $(this);
            console.debug(checkBox);
            if (checked) {
                checkBox.prop('checked', true);
            } else {
                checkBox.prop('checked', false);
            }
        });
    }
    function submitFunc(id) {
        btntitle = $("#submitbtn" + id).text();
        if (btntitle == 'Inactive') {
            $("#submitbtn" + id).text('Active');
        } else {
            $("#submitbtn" + id).text('Inactive');
        }
    }

</script>