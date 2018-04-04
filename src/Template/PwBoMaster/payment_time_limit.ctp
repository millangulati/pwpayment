
<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$stateList = isset($response["stateList"]) ? $response["stateList"] : array();
$paymentModeList = isset($response["paymentMode"]) ? $response["paymentMode"] : array();
$responseData = isset($response["responseData"]) ? $response["responseData"] : array();
$timeLimitData = isset($response["timeLimitData"]) ? $response["timeLimitData"] : array();
//pr($timeLimitData);
//echo $this->Html->script('');
echo $this->Html->css('jquery.multiselect');
echo $this->Html->script(array('jsvalidation', 'bootbox.min', 'jquery.multiselect'));
$timeFrom = array();
$timeto = array();
for ($i = 0; $i <= 24; $i++) {
    $timeFrom[$i] = $i;
}
for ($i = 0; $i <= 24; $i++) {
    $timeto[$i] = $i;
}
$baseurl = $this->Html->url(array('controller' => 'getJson'), true);
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-clock-o font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Time List', array('id' => 'spanhead', 'class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn green form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Edit', array('id' => 'editbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return editFunc();'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');  // title

echo $this->Html->div('portlet-body'); // portlet-body
//echo $this->Html->div("msgDiv style18", isset($msg) ? $msg : '&nbsp', array("id" => "msgDiv", "style" => "width:90%;text-align:center;color:red;margin-top: -11px;;font-size: 16px"));
echo $this->Form->create('paymentTimeLimit', array("id" => "paymentTimeLimit", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->input("AuthVar", array('id' => 'auth', "type" => "hidden", "class" => "nochange", "value" => $response["AuthVar"]));
echo $this->Form->input('db_serno', array('id' => 'dbser', 'type' => 'hidden', 'fields' => FALSE));
$this->Form->unlockField("db_serno");
echo $this->Form->input('paymentMode', array('id' => 'mode', 'type' => 'hidden', 'fields' => FALSE));
$this->Form->unlockField("paymentMode");
echo $this->Html->div('tab-content'); //tab-content
//echo $this->Html->div('row'); //1-row
echo $this->Html->div("tab-pane active", NULL, array("id" => "portlet_add"));


echo $this->Html->div("row", NULL, array("id" => "viewBranchDiv"));
echo $this->Html->div('col-sm-2 col-md-2', $this->Form->label('selectStateview', 'Select Branch'));
echo $this->Form->input("selectStateview", array("id" => "selectStateview", "label" => FALSE, 'div' => array('class' => 'col-md-4 col-sm-4 form-group'), 'options' => $stateList, "class" => "form-control "));
echo $this->Html->useTag('tagend', 'div');



echo $this->Html->div("row", NULL, array("id" => "selectBranchDiv"));
echo $this->Html->div('col-sm-2 col-md-2', $this->Form->label('selectState', 'Select Branch'));
echo $this->Form->input('selectState', array('label' => False, 'id' => 'selectState', 'options' => array($stateList), 'multiple' => true, 'class' => 'stateBox', 'div' => array('class' => 'col-sm-7 col-md-10 form-group'), 'empty' => '', 'selected' => ''));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('', null, array('id' => 'modeDiv', 'class' => 'table-responsive'));
echo "<table id='tableEntry' class='table table-striped' ><thead><tr class=headrows><th>Payment Mode</th><th colspan=2><center>Sunday</center></th><th colspan=2><center>Monday</center></th><th colspan=2><center>Tuesday</center></th><th colspan=2><center>Wednesday</center></th><th colspan=2><center>Thursday</center></th><th colspan=2><center>Friday</center></th><th colspan=2><center>Saturday</th></tr><tr class='headrow headrows'><th></th><th >From</th><th >To</th><th >From</th><th >To</th><th >From</th><th >To</th><th >From</th><th >To</th><th >From</th><th >To</th><th >From</th><th >To</th><th >From</th><th >To</th></thead><tbody>";
$j = 1;
foreach ($paymentModeList as $code => $mode) {
    echo '<tr><td style="width:9% ">' . $this->Form->input('Bo.' . $code, array('id' => 'mode_' . $code, 'class' => 'paymodeBox', "checked" => false, 'type' => 'checkbox', 'value' => $code, 'label' => array('text' => $mode, 'class' => 'paymodeclass'))) . "</td>";
    foreach (array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fir', 'Sat') as $daykey => $day) {
        echo '<td colspan=2>';
        for ($i = 0; $i < 3; $i++) {
            $fromid = 'from_modeid_' . $code . '_slot_' . $i . "_dayid_" . $daykey;
            $toid = 'to_modeid_' . $code . '_slot_' . $i . "_dayid_" . $daykey;
            echo $this->Form->input($code . "_" . $day . "_" . $i . "_f", array('id' => $j . "_f", 'label' => false, 'class' => 'form-control a inputVal ' . $code . "day" . " " . $fromid, 'options' => $timeFrom, 'empty' => '', 'value' => '', 'div' => array('class' => 'col-sm-6 col-md-6 col-xs-6'))) . $this->Form->input($code . "_" . $day . "_" . $i . "_t", array('id' => $j . "_t", 'label' => false, 'class' => 'form-control a inputVal ' . $code . "day" . " " . $toid, 'options' => $timeto, 'empty' => '', 'value' => '', 'div' => array('class' => 'col-sm-6 col-md-6 col-xs-6')));
            $j++;
        }
        echo '</td>';
    }
    echo '</tr>';
}
echo "</tbody></table>";
echo $this->Html->useTag('tagend', 'div'); //modDiv
echo $this->Html->useTag('tagend', 'div'); //portlet_add
echo $this->Html->useTag('tagend', 'div'); /// tab-contentend
echo $this->Html->useTag('tagend', 'div'); // portlet body end
echo $this->Form->end();



echo $this->Form->create('formback', array("name" => "formback", 'id' => 'formback', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->end();
?>
<style>
    .alert {line-height: 3px;margin-bottom: -15px;}
    .tools{margin-right: 10px;display: none;}
    .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"],    .radio-inline input[type="radio"] { margin-left: 0px;}
    .a {padding-left: 4px;border-radius: 10px;width:50px; margin-left: -10px; margin-right: 50px;padding-top: 0px;height: 23px;margin-bottom: 3px; padding-right: 0px;}
    .checkbox label, .radio label { margin-left: 18px;padding-right: 0;padding-top: 2px; }
    .table th {color: #515151; border-left: 1px solid #f4f4f4; border-right: 1px solid #f4f4f4;}
    .headrow{ background-color: #DFDFF2;  border-bottom: 2px solid #f4f4f4;}
    .headrows{ background-color: #DFDFE8;border-bottom: 2px solid #f4f4f4;}
    .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"] {
        position: unset;}
    .portlet-title > .nav-tabs { background: none;margin: 0;float: right;display: inline-block;border: 0;}
    .portlet-title > .nav-tabs > li {background: none;margin: 0; border: 0;}
    .portlet-title > .nav-tabs > li > a {background: none;border: 0;padding: 2px 10px 13px;color: #444;}
    .portlet-title > .nav-tabs > li.active,
    .portlet-title > .nav-tabs > li.active:hover { border-bottom: 4px solid #f3565d;position: relative; }
    .portlet-title > .nav-tabs > li:hover {border-bottom: 4px solid #f29b9f;}

    .portlet-title > .nav-tabs > li.active > a,
    .portlet-title > .nav-tabs > li:hover > a {color: #333; background: #fff;border: 0;}
    .table > thead > tr > th {border-bottom: 2px solid #f4f4f4;border-top: 2px solid #f4f4f4;text-align: center; }
    .alert {line-height: 3px;margin-bottom: -15px;}
    .radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
        position: absolute;
        margin-top: 4px;
        margin-left: -20px;
    }
</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var baseurl = "<?= $baseurl ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    var timeLimitDataStr = '<?= json_encode($timeLimitData) ?>';
    var timeLimitData = JSON.parse(timeLimitDataStr);
    var stateListStr = '<?= json_encode(array_keys($stateList)) ?>';
    var stateList = JSON.parse(stateListStr);
    var paymentModeListStr = '<?= json_encode($paymentModeList) ?>';
    var paymentModeList = JSON.parse(paymentModeListStr);
    var j = "<?= $j ?>";
    var editmode = '';
    var bankid = stateList[0];
    var recordExist = false;
    var tempRecord = '';
    var newRecord = '';
    $('#document').ready(function () {
        localStorage.setItem('alerted', '');
        $("#submitbtn,#selectBranchDiv,#backbtn").hide();
        $("#selectStateview").val(bankid);
        $(".inputVal").attr('disabled', 'disabled');
        $(".paymodeBox").attr('disabled', 'disabled');

        if (sucmsg != '') {
            SuccMsgFun('', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('', msg);
        }
        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        $(".ta,.paymodeBox,.paymodeclass,.inputVal,.ms-options-wrap").click(function () {
            clearMsg();
        });
        $('#selectState').change(function () {

            var selectedbranch = $("#selectState").val();
            $.each(selectedbranch, function (id, idval) {
                newRecord = '';
                if (idval != bankid) {
                    $.each(timeLimitData[idval], function (branch_id, data) {
                        newRecord += "_" + data['time_slot'];
                    });
                    if (tempRecord != newRecord) {
                        $(".inputVal").val('');
                        $(".paymodeBox").prop('checked', false);
                        return false;
                    }
                }
            });
            var alerted = localStorage.getItem('alerted') || '';
            if ($("#selectState :selected").length == 1) {
                localStorage.setItem('alerted', '');
            }
            if ($("#selectState :selected").length == 2 && alerted != 'yes') {
                bootbox.alert('If Record Of These Selected Branches Is Not Same Than Old Record Will Be Clear.');
                localStorage.setItem('alerted', 'yes');
            }
        });
        fillRecord();
        $('#selectStateview').change(function () {
            clearMsg();
            bankid = $("#selectStateview").val();
            fillRecord();
            if (recordExist == false) {
                $(".inputVal").val('');
//               bootbox.alert('Record Not Exist For This Branch.');
                return ErrorMsgFun('selectStateview', 'Record Not Exist For This Branch.');
            }
        });

        $('.paymodeBox').click(function () {
            if (this.checked != true) {
//                $("." + $(this).val() + "day").removeAttr('disabled');
//            }
//            else {
//                $("." + $(this).val() + "day").attr('disabled', 'disabled');
                $("." + $(this).val() + "day").val('');
            }
        });
        function validateState() {
            if ($("#selectStateview").val() == '') {
                return ErrorMsgFun('selectStateview', 'Please Select Branch.');
            }
            return true;
        }

        $('#viewButton').click(function () {
            if (validateState()) {
                var dataString = "dbser=" + $("#selectStateview").val() + "&AuthVar=" + AuthVar;
                var url = baseurl + "/getTimeListData";
                $('#loaderDiv').show();
                AsyncAjaxRequest(url, dataString, timeListfun);
            }
        });
        $('#submitbtn').click(function () {
            var paymode = '';
            var flag1 = 0;
            var flag2 = 0;
            var flag3 = 0;
            var flag4 = 0;
            var flag5 = 0;
            if ($("#selectState").val() == '') {
                return ErrorMsgFun('selectState', 'Please Select Atleast One State.');
            }
            $('.paymodeBox').each(function () {
                if (this.checked == true) {
                    paymode += ',' + $(this).val();
                }
            });
            if (paymode == '') {
                return ErrorMsgFun('', 'Please Select Atleast One Payment Mode!!!.');
            }
            for (var i = 1; i < j; i++) {
                if ($('#mode_1').is(':checked') && i <= 21) {
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() != "") {
                        flag1++;
                        if (Math.abs($('#' + i + "_f").val()) > Math.abs($('#' + i + "_t").val())) {
                            bootbox.alert('From Time Slot Should be Less Than Or Equal To Time Slot in  Cash (office) ');
                            return false;
                        }
                    }
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() == "") {
                        bootbox.alert('Please Select (To) Time Slot in  Cash (office)');
                        return false;
                    }
                    if ($('#' + i + "_f").val() == '' && $('#' + i + "_t").val() != "") {
                        bootbox.alert('Please Select (From) Time Slot in  Cash (office)');
                        return false;
                    }
                }
                if ($('#mode_2').is(':checked') && (i >= 22 && i <= 42)) {
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() != "") {
                        flag2++;
                        if (Math.abs($('#' + i + "_f").val()) > Math.abs($('#' + i + "_t").val())) {
                            bootbox.alert('From Time Slot Should be Less Than Or Equal To Time Slot in  Cash (bank) ');
                            return false;
                        }
                    }
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() == "") {
                        bootbox.alert('Please Select (To) Time Slot in  Cash (bank)');
                        return false;
                    }
                    if ($('#' + i + "_f").val() == '' && $('#' + i + "_t").val() != "") {
                        bootbox.alert('Please Select (From) Time Slot in Cash (bank)');
                        return false;
                    }
                }
                if ($('#mode_3').is(':checked') && (i >= 43 && i <= 63)) {
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() != "") {
                        flag3++;
                        if (Math.abs($('#' + i + "_f").val()) > Math.abs($('#' + i + "_t").val())) {
                            bootbox.alert('From Time Slot Should be Less Than Or Equal To Time Slot in Cheque ');
                            return false;
                        }
                    }
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() == "") {
                        bootbox.alert('Please Select (To) Time Slot in  Cheque');
                        return false;
                    }
                    if ($('#' + i + "_f").val() == '' && $('#' + i + "_t").val() != "") {
                        bootbox.alert('Please Select (From) Time Slot in  Cheque');
                        return false;
                    }
                }
                if ($('#mode_4').is(':checked') && (i >= 64 && i <= 84)) {
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() != "") {
                        flag4++;
                        if (Math.abs($('#' + i + "_f").val()) > Math.abs($('#' + i + "_t").val())) {
                            bootbox.alert('From Time Slot Should be Less Than Or Equal To Time Slot in  Net Banking ');
                            return false;
                        }
                    }
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() == "") {
                        bootbox.alert('Please Select (To) Time Slot in  Net Banking');
                        return false;
                    }
                    if ($('#' + i + "_f").val() == '' && $('#' + i + "_t").val() != "") {
                        bootbox.alert('Please Select (From) Time Slot in  Net Banking');
                        return false;
                    }
                }
                if ($('#mode_9').is(':checked') && (i >= 85 && i <= 105)) {
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() != "") {
                        flag5++;
                        if (Math.abs($('#' + i + "_f").val()) > Math.abs($('#' + i + "_t").val())) {
                            bootbox.alert('From Time Slot Should be Less Than Or Equal To Time Slot in  UPI ');
                            return false;
                        }
                    }
                    if ($('#' + i + "_f").val() != '' && $('#' + i + "_t").val() == "") {
                        bootbox.alert('Please Select (To) Time Slot in  UPI');
                        return false;
                    }
                    if ($('#' + i + "_f").val() == '' && $('#' + i + "_t").val() != "") {
                        bootbox.alert('Please Select (From) Time Slot in  UPI');
                        return false;
                    }
                }
            }
//            });
            if ($('#mode_1').is(':checked') && flag1 <= 0) {
                bootbox.alert('Please Select Atleast One Time Slot in Cash (office)');
                return false;
            }
            if ($('#mode_2').is(':checked') && flag2 <= 0) {
                bootbox.alert('Please Select Atleast One Time Slot in Cash (bank) ');
                return false;
            }
            if ($('#mode_3').is(':checked') && flag3 <= 0) {
                bootbox.alert('Please Select Atleast One Time Slot in Cheque');
                return false;
            }
            if ($('#mode_4').is(':checked') && flag4 <= 0) {
                bootbox.alert('Please Select Atleast One Time Slot  in  Net Banking');
                return false;
            }
            if ($('#mode_9').is(':checked') && flag5 <= 0) {
                bootbox.alert('Please Select Atleast One Time Slot  in  UPI');
                return false;
            }

            $('#mode').val(paymode);

            $(".inputVal").removeAttr("disabled");
            $("#paymentTimeLimit").submit();

        });
    });
    function timeListfun(status, data) {
        $('#loaderDiv').hide();
        if (status === 200) {
            var JSONObject = JSON.parse(data);
            if (JSONObject['tag'].toUpperCase().indexOf("#ERROR:") !== -1) {
                return false;
            } else {
                clearMsg();
                $('#timeListDiv').html('');
                if (JSONObject['data'] == '') {
                    return ErrorMsgFun('selectStateview', 'No Record Found For This State.');
                }
                else {
                    delete JSONObject["tag"];
                    var tableData = '<table  id=tablereport class="table table - striped" style="width:100%"><thead>';
                    tableData += "<tr class=headrow><th colspan=10><center> Payment Time Entries For " + $("#selectStateview option:selected").text() + "</center></th></tr><tr class=headrows><th>S.no.</th><th>State</th><th>Paymode</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr></thead><tbody>";
                    $.each(JSONObject['data'], function (row) {
                        var rowdata = JSONObject['data'][row];
                        tableData += "<tr><td>" + rowdata["Serno"] + "</td><td>" + rowdata["State"] + "</td><td>" + rowdata["Payment Mode"] + "</td><td >" + rowdata["Sunday"] + "</td><td>" + rowdata["Monday"] + "</td><td>" + rowdata["Tuesday"] + "</td><td>" + rowdata["Wednesday"] + "</td><td>" + rowdata["Thursday"] + "</td><td>" + rowdata["Firday"] + "</td><td>" + rowdata["Saturday"] + "</td></tr>";
                    });
                    $('#timeListDiv').append(tableData, '</tbody></table><br>');
                }
            }
        } else {
            return ErrorMsgFun('selectStateview', 'Error in Response.Please refresh and try again.');
        }
    }
    function fillRecord() {
        recordExist = false;
        $(".inputVal").val('');
        $(".paymodeBox").prop('checked', false);
        tempRecord = '';
        $.each(timeLimitData, function (branchid, data) {
            if (branchid == bankid) {
                recordExist = true;
                $.each(data, function (modeid, record) {
                    var timeslot = record['time_slot'];
                    tempRecord += "_" + timeslot;
                    var Arry = timeslot.split('#');
                    $.each(Arry, function (key, val) {
                        var daysArry = val.split('@');
                        var slotArry = daysArry[1].split(',');
                        $.each(slotArry, function (slotkey, slotval) {
                            $("#mode_" + modeid).prop('checked', true);
                            var fromToArry = slotval.split('-');
                            var from = fromToArry[0];
                            var to = fromToArry[1];
                            $(".from_modeid_" + modeid + "_slot_" + slotkey + "_dayid_" + daysArry[0]).val(from);
                            $(".to_modeid_" + modeid + "_slot_" + slotkey + "_dayid_" + daysArry[0]).val(to);
                        });

                    });
                });
            }
        });
    }
    function editFunc() {
        clearMsg();
        editmode = true;
        $(".paymodeBox").removeAttr('disabled');
        $("#submitbtn,#selectBranchDiv,#backbtn").show();
        $("#editbtn,#viewBranchDiv").hide();
        $('#selectState').val(bankid);
        $('#selectState').multiselect({
            columns: 1,
            placeholder: 'Select Branch',
            search: true,
            selectAll: true,
            refresh: true
        });
        $(".inputVal").removeAttr("disabled");
    }
    function submitFunc() {

    }
</script>
