<?php

$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$providerList = isset($response["providerList"]) ? $response["providerList"] : array();
$accountList = isset($response["accountList"]) ? $response["accountList"] : array();
$bankList = isset($response["banklist"]) ? $response["banklist"] : array();
$bankName = isset($response["bankName"]) ? $response["bankName"] : array();
echo $this->Html->script(array('jsvalidation', 'security.min'));

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');

echo $this->Html->div('caption');
echo '<i class="fa fa-user-plus font-green-sharp"></i>';
echo $this->Html->tag('span', 'ECOLLECT - Add Account Number', array('class' => 'caption-subject font-green-sharp bold uppercase', 'id' => 'pageHead'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Add Account', array('id' => 'addBtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('View Accounts', array('id' => 'viewBtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //main portlet-body
echo $this->Form->create('Bo', array("id" => "addbankaccount", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->hidden("flag", array("value" => '', 'id' => 'flag'));
echo $this->Form->unlockField("flag");
echo $this->Form->hidden("changeStatus", array("value" => '', 'id' => 'changeStatus'));
echo $this->Form->unlockField("changeStatus");
echo $this->Form->hidden("newIfsc_Code", array("value" => '', 'id' => 'newIfsc_Code'));
echo $this->Form->unlockField("newIfsc_Code");
echo $this->Form->hidden("newAccountNumber", array("value" => '', 'id' => 'newAccountNumber'));
echo $this->Form->unlockField("newAccountNumber");

echo $this->Form->hidden("serno", array("value" => '', 'id' => 'serno'));
echo $this->Form->unlockField("serno");


echo $this->Html->div('row', null, array('id' => 'addDiv')); //addDiv
echo $this->Html->div('row');
echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Select Provider', array('for' => 'provider'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-send"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('provider', array('id' => 'provider', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $providerList, "empty" => "Select Provider"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Select Bank ', array('for' => 'bank'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa  fa-bank "></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('bank', array('id' => 'bank', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => '', "empty" => "Select Bank"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('row');

echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Enter IFSC Code', array('for' => 'account'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-credit-card"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('ifsc_code', array('id' => 'ifsc_code', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Enter Virtual Account Number', array('for' => 'account'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-credit-card"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('account', array('id' => 'account', 'label' => false, 'div' => FALSE, 'class' => 'form-control'));
echo $this->Html->useTag('tagend', 'div');
echo "<span style='font-size:10px;font-style:italic;'>Provided by respective bank and add {CODE} text so that it will be replace with actual party code in frontend. Sample Formats: PAYYES{CODE}, PAY{CODE}YES</span>";
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div'); // addDiv end
echo $this->Form->end();
echo $this->Html->div('row', null, array('id' => 'viewDiv')); //viewDiv
echo $this->Html->div('');
echo $this->Html->div('', null, array('id' => 'tableDiv')); //table

?>
<div class="row form-group">
    <div class="col-md-9 col-sm-6"></div>
    <div class="col-md-3 col-sm-6">
        <form action="#" method="get">
            <div class="input-group">
                <!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
                <input class="form-control" id="system-search" name="q" placeholder="Search for" required="">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </div>
</div>
<?php
echo "<div class=table-responsive>";
echo"<table id='tablereport' class='table table - striped table-list-search'><thead class='header'><tr><th>Serial No.</th><th>Bank name</th><th>Account Number</th><th>IFSC Code</th><th>Status</th>";
echo "</tr></thead><tbody>";
$i = 1;
if(!empty($accountList)) {
foreach ($accountList as $row) {
    $rowid = $row['bankid'] . "##" . $row['accountno'] . "##" . $row['status'] . "##" . $row['serno']. "##" . $row['ifsc_code'];
    $status = array('Y' => 'Active', 'N' => 'Inactive');
    echo "<tr id =$rowid class='tabcol'><td>" . $i . "</td>";
    echo "<td>" . $bankName[$row['bankid']] . "</td>";
    echo "<td>" . $row['accountno'] . "</td>";
    echo "<td>" . $row['ifsc_code'] . "</td>";
    echo "<td>" . $status[$row['status']] . "</td>";
    echo "</tr>";
    $i++;
}
} else {
    echo "<tr class='search-query-sf'><td colspan='5' style='text-align:center;'>No Record Found.</td></tr>";
}
echo "</tbody></table></div>";

echo $this->Html->useTag('tagend', 'div'); //table
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div'); // viewDiv end
//echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
?>

<div class="modal fade popup_view" id="popup_view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title" id ="modaltitle"></h4>
            </div>
            <div class="modal-body form-group">

                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 form-group">
                        <label for="newAccountNum">Account Number</label>
                        <div class="input-group">
                            <span class="input-group-addon info"><span class="fa fa-credit-card"></span></span>
                            <input class="form-control" id="newAccountNum" type="text">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6 col-md-6 form-group">
                        <label for="activeAcc">Account Status</label>
                        <button type="button" class="btn green" id="activeAcc"></button>
                    </div>
                    <div class="col-sm-6 col-md-6 form-group">
                        <label for="ifsccode">IFSC Code</label>
                        <div class="input-group">
                            <span class="input-group-addon info"><span class="fa fa-credit-card"></span></span>
                            <input class="form-control" id="newIfscCode" type="text" onkeyup= 'EnterAlphaNumericOnly(this)')>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green" id="saveAccount">Save changes</button>
            </div>

        </div>
    </div>
</div>

<style>
    .alert {line-height: 3px;margin-bottom: -15px;}
    .tools{margin-right: 10px;display: none;}
    .table th{background-color: #2AB4C0; border-bottom: 1px solid;color:#fff;}
    .input-group-addon.info {background-color: rgb(57, 179, 215);border-color: rgb(38, 154, 188);}
    /*.modal-body {position: relative;padding: 36px;}*/
    .table tr:hover {background-color: #17c4bb; cursor: pointer; cursor: hand;}
    #activeAcc,#offlineActiveAcc {
        width: -moz-available;
    }
    .modal-footer {
        margin-top: -42px;
    }
</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var bankList = JSON.parse('<?= json_encode($bankList) ?>');
    var bankName = JSON.parse('<?= json_encode($bankName) ?>');
    $('#document').ready(function () {
        $("#addDiv,#submitbtn,#viewBtn").hide();
        $("#bank,#ifsc_code,#account,#provider").val('');
        $("#bank,#ifsc_code,#account,#system-search").click(function () {
            clearMsg();
        });
        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
        $("#bank").click(function () {
            if ($("#provider").val() == '') {
                return ErrorMsgFun('provider', 'Please Select Provider Before Choosing Bank.');
            }
        });
        $("#addBtn").click(function () {
            clearMsg();
            $("#addDiv,#submitbtn,#viewBtn").show();
            $("#viewDiv,#addBtn").hide();
            $("#pageHead").html('ECOLLECT - Add Account Number');
        });
        $("#viewBtn").click(function () {
            clearMsg();
            $("#addDiv,#submitbtn,#viewBtn").hide();
            $("#viewDiv,#addBtn").show();
            $("#pageHead").html('Payment Account Numbers');
        });
        $("#provider").change(function () {
            var bankExist = false;
            var providerid = $("#provider").val();
            if (providerid == '') {
                return ErrorMsgFun('provider', 'Please Select Provider');
            }
            $("#bank").html("<option value=''>Select Bank</option>");
            $.each(bankList, function (providerKey, bankname) {
                if (providerid == providerKey) {
                    bankExist = true;
                    $.each(bankname, function (bankid, bankname) {
                        $("#bank").append("<option value='" + bankid + "'>" + bankname + "</option>");
                    });
                    SuccMsgFun('bank', 'Select Bank');
                }
            });
            if (bankExist == false) {
                $("#bank").html("<option value=''>Banks Are Not Available For This Provider.</option>");
                return ErrorMsgFun('bank', 'Banks Are Not Available For This Provider');
            }
        });
        $('.table-responsive').on('click', 'tr:gt(0)', function () {
            clearMsg();
            var classnot = $(this).prop('class');
            if (classnot != 'search-query-sf') {
                var row_id = $(this).prop('id');//search-query-sf
                var row_val = row_id.split("##");
                $('#popup_view').modal('toggle');
                $("#modaltitle").text(" Change Account Details [ Bank Name : " + bankName[row_val[0]] + "]");
                $("#newAccountNum").val(row_val[1]);
                $('#newIfscCode').val(row_val[4]);
                $("#serno").val(row_val[3]);
                if (row_val[2] == 'Y') {
                    $("#activeAcc").text("Active");
                    $("#changeStatus").val('Y');
                } else {
                    $("#activeAcc").text("Inactive");
                    $("#changeStatus").val('N');
                }

            }
        });
        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                $('#popup_view').modal('hide');
            }
        });
        $("#submitbtn").click(function () {
            if ($("#provider").val() == '') {
                return ErrorMsgFun('provider', 'Please Select Provider.');
            }
            if ($("#bank").val() == '') {
                return ErrorMsgFun('bank', 'Please Select Bank.');
            }
            if ($("#account").val() == '') {
                return ErrorMsgFun('account', 'Please Enter Account Number.');
            } else {
                var substr = "{CODE}";
                var str = $("#account").val();
                if (str.indexOf(substr) != -1) {
                    // found
                } else {
                    return ErrorMsgFun('account', 'Invalid format Account Number. Please add {CODE} text.');
                }
            }




            $("#flag").val('ADD');
            $("#addbankaccount").submit();
        });
        $("#activeAcc").click(function () {
            if ($("#activeAcc").text() == 'Active') {
                $("#activeAcc").text("Inactive");
                $("#changeStatus").val('N');
            } else {
                $("#activeAcc").text("Active");
                $("#changeStatus").val('Y');
            }
        });
        $("#offlineActiveAcc").click(function () {
            if ($("#offlineActiveAcc").text() == 'Active') {
                $("#offlineActiveAcc").text("Inactive");
                $("#changeOfflineStatus").val('N');
            } else {
                $("#offlineActiveAcc").text("Active");
                $("#changeOfflineStatus").val('Y');
            }
        });
        $("#saveAccount").click(function () {
            $("#newAccountNumber").val($("#newAccountNum").val());
            $("#newIfsc_Code").val($("#newIfscCode").val());
            $("#flag").val('UPDATE');
            if ($("#serno").val() == '') {
                alert('Please Select Account Number.');
                return false;
            }
            if ($("#newAccountNumber").val() == '') {
                alert('Please Enter Account Number.');
                return false;
            } else {
                var substr = "{CODE}";
                var str = $("#newAccountNumber").val();
                if (str.indexOf(substr) != -1) {
                    // found
                } else {
                    alert('Invalid format Account Number. Please add {CODE} text.');
                    return false;
                }
            }
            if ($("#changeStatus").val() == '') {
                alert('Please Set Status.');
                return false;
            }
            $("#addbankaccount").submit();
        });
        //        var activeSystemClass = $('.list-group-item.active');
        $('#system-search').keyup(function () {
            var that = this;
            var tableBody = $('.table-list-search tbody');
            var tableRowsClass = $('.table-list-search tbody tr');
            $('.search-sf').remove();
            tableRowsClass.each(function (i, val) {
                var rowText = $(val).text().toLowerCase();
                var inputText = $(that).val().toLowerCase();
                if (inputText != '')
                {
                    $('.search-query-sf').remove();
                    tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
                            + $(that).val()
                            + '"</strong></td></tr>');
                } else
                {
                    $('.search-query-sf').remove();
                }

                if (rowText.indexOf(inputText) == -1)
                {
                    tableRowsClass.eq(i).hide();
                } else
                {
                    $('.search-sf').remove();
                    tableRowsClass.eq(i).show();
                }
            });
            if (tableRowsClass.children(':visible').length == 0)
            {
                tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
            }
        });
    });

</script>
