<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$providerList = isset($response["providerList"]) ? $response["providerList"] : array();
$accountList = isset($response["accountList"]) ? $response["accountList"] : array();
$bankList = isset($response["banklist"]) ? $response["banklist"] : array();
$bankName = isset($response["bankName"]) ? $response["bankName"] : array();
$accountList_count = count($accountList);
echo $this->Html->script(array('jsvalidation', 'security.min'));

$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');

echo $this->Html->div('caption');
echo '<i class="fa fa-credit-card font-green-sharp"></i>';
echo $this->Html->tag('span', 'REQUEST - Payment Account Numbers', array('class' => 'caption-subject font-green-sharp bold uppercase', 'id' => 'pageHead'));
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

echo $this->Html->div('tools');
echo $this->Form->button('Update Status', array('id' => 'updateStatus', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //main portlet-body
echo $this->Form->create('Bo', array("id" => "addbankaccount", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->hidden("flag", array("value" => '', 'id' => 'flag'));
echo $this->Form->unlockField("flag");
echo $this->Form->hidden("statusflag", array("value" => '', 'id' => 'statusflag'));
echo $this->Form->unlockField("statusflag");
echo $this->Form->hidden("changeStatus", array("value" => '', 'id' => 'changeStatus'));
echo $this->Form->unlockField("changeStatus");
echo $this->Form->hidden("changeOfflineStatus", array("value" => '', 'id' => 'changeOfflineStatus'));
echo $this->Form->unlockField("changeOfflineStatus");
echo $this->Form->hidden("newAccountNumber", array("value" => '', 'id' => 'newAccountNumber'));
echo $this->Form->unlockField("newAccountNumber");
echo $this->Form->hidden("serno", array("value" => '', 'id' => 'serno'));
echo $this->Form->unlockField("serno");
echo $this->Form->hidden("updatedSerno_str", array("value" => '', 'id' => 'updatedSerno_str'));
echo $this->Form->unlockField("updatedSerno_str");



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
echo $this->Html->tag('label', 'Enter Account Number', array('for' => 'account'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-credit-card"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('account', array('id' => 'account', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'onkeyup' => 'EnterNumericKeyOnly(this)'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

$status = array('N' => 'Inactive', 'Y' => 'Active');
echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Select Offline Status ', array('for' => 'offlinestatus'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa  fa-check-square-o "></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('offlinestatus', array('id' => 'offlinestatus', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $status));
echo $this->Html->useTag('tagend', 'div');
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
echo"<table id='tablereport' class='table table - striped table-list-search'><thead class='header'><tr><th class='text-center'>Serial No.</th><th>Bank name</th><th>Account Number </th><th class='statusaccount'> Account Status <a class='btn btn-primary btn-xs' id='editaccbtn' href='#'><span class='glyphicon glyphicon-edit'></span> Edit</a></th><th class='text-center chkaccount'> Account Status<label class=labelclass><input type='checkbox' name='check' id='selectAllAcc' class='newaccountstatusall' > <span class='label-text'></span></label></th><th class='statusoffline'> Offline Status <a class='btn btn-primary btn-xs' href='#' id='editoffbtn'><span class='glyphicon glyphicon-edit'></span> Edit</a></th><th class='text-center chkoffline'> Offline Status<label class=labelclass><input type='checkbox' name='check' id='selectAllOff' class='newofflinestatusall' > <span class='label-text'></span></label></th>";
echo "</tr></thead><tbody>";
$i = 1;
foreach ($accountList as $row) {
    $rowid = $row['bankid'] . "##" . $row['accountno'] . "##" . $row['status'] . "##" . $row['serno'] . "##" . $row['offline_status'] . "##" . $row['provider_id'];
    $acc_chk_id = "newaccountstatus_" . $row['serno'];
    $off_chk_id = "newofflinestatus_" . $row['serno'];
    $status = array('Y' => 'Active', 'N' => 'Inactive');
    $editstatus = ($row['status'] == 'Y') ? 'checked' : '';
    $editaccount = "<td class='chkaccount form-check text-center'><label class=labelclass><input type='checkbox' name='check' id=$acc_chk_id class='newaccountstatus' $editstatus onclick = 'return chkinputBox();'> <span class='label-text'></span></label></td>";
    $offlinestatus = ($row['offline_status'] == 'Y') ? 'checked' : '';
    $editoffline = "<td class='chkoffline form-check text-center'><label class=labelclass><input type='checkbox' name='check'  id=$off_chk_id class='newofflinestatus' $offlinestatus onclick = 'return chkinputBox();'> <span class='label-text'></span></label></td>";
    echo "<tr id =$rowid class='tabcol'>";
    echo "<td class='text-center'>" . $i . "</td>";
    echo "<td>" . $bankName[$row['bankid']] . "</td>";
    echo "<td>" . $row['accountno'] . "</td>";
    echo "<td class='statusaccount'>" . $status[$row['status']] . "</td>";
    echo $editaccount;
    echo "<td class='statusoffline'>" . $status[$row['offline_status']] . "</td>";
    echo $editoffline;
    echo "</tr>";
    $i++;
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
                            <input class="form-control" id="newAccountNum" type="text" onkeyup= 'EnterNumericKeyOnly(this)')>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-6 col-md-6 form-group">
                        <label for="activeAcc">Account Status</label>
                        <button type="button" class="btn green" id="activeAcc"></button>
                    </div>
                    <div class="col-sm-6 col-md-6 form-group">
                        <label for="offlineActiveAcc">Offline Status</label>
                        <button type="button" class="btn green" id="offlineActiveAcc"></button>
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

<?php
echo $this->Form->create('formback', array("name" => "formback", 'id' => 'formback', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->end();
?>
<style>
    .custab{
        border: 1px solid #ccc;
        padding: 5px;
        margin: 5% 0;
        box-shadow: 3px 3px 2px #ccc;
        transition: 0.5s;
    }
    .custab:hover{
        box-shadow: 3px 3px 0px transparent;
        transition: 0.5s;
    }
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
    body{
        padding: 50px;
    }
    input[type="checkbox"], input[type="radio"]{
        position: absolute;
        right: 9000px;
    }
    /*Check box*/
    input[type="checkbox"] + .label-text:before{
        content: "\f096";
        font-family: "FontAwesome";
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing:antialiased;
        width: 1em;
        display: inline-block;
        margin-right: 5px;
    }

    input[type="checkbox"]:checked + .label-text:before{
        content: "\f14a";
        color: #2980b9;
        animation: effect 250ms ease-in;
    }

    input[type="checkbox"]:disabled + .label-text{
        color: #aaa;
    }

    input[type="checkbox"]:disabled + .label-text:before{
        content: "\f0c8";
        color: #ccc;
    }

    .labelclass{
        position: relative;
        cursor: pointer;
        color: #666;
        font-size: 25px;
        margin-top: -8px;
        margin-bottom: -8px;
    }
    @keyframes effect{
        0%{transform: scale(0);}
        25%{transform: scale(1.3);}
        75%{transform: scale(1.4);}
        100%{transform: scale(1);}
    }
    div label {
        padding: 0px 8px;
        white-space: nowrap;
    }
</style>
<script>
    var baseUrl = "<?= $ajaxbase ?>";
    var authvar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var bankList = JSON.parse('<?= json_encode($bankList) ?>');
    var bankName = JSON.parse('<?= json_encode($bankName) ?>');
    var currentclass = '';
    var list_count = '<?= json_encode($accountList_count) ?>';
    $('#document').ready(function () {
        $("[data-toggle=tooltip]").tooltip();
        $("#addDiv,#submitbtn,#viewBtn,#updateStatus,#backbtn,.chkaccount,.chkoffline").hide();
        $("#bank,#account,#provider").val('');
        $("#bank,#account,#system-search").click(function () {
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
            $("#addDiv,#submitbtn,#viewBtn,#backbtn").show();
            $("#viewDiv,#addBtn,#editBtn,#viewBtn").hide();
            $("#pageHead").html('REQUEST - Add Account Number');
        });
        $("#viewBtn").click(function () {
            clearMsg();
            $("#addDiv,#submitbtn,#viewBtn,#backbtn").hide();
            $("#viewDiv,#addBtn").show();
            $("#bank,#account,#system-search,#account,#provider").val('');
            $("#pageHead").html('REQUEST - Payment Account Numbers');
        });
        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        $("#editaccbtn").click(function () {
            currentclass = 'newaccountstatus';
            clearMsg();
            $("#addDiv,#submitbtn,#viewBtn,#addBtn,.statusaccount,#editoffbtn").hide();
            $("#updateStatus,#backbtn,.chkaccount").show();
            $("#bank,#account,#system-search,#account,#provider").val('');
            $("#pageHead").html('Update Status Of  Account Numbers');
            $("#statusflag").val('ACCOUNT');
            chkinputBox();

        });
        $("#editoffbtn").click(function () {
            currentclass = 'newofflinestatus';
            clearMsg();
            $("#addDiv,#submitbtn,#viewBtn,#addBtn,.statusoffline,#editaccbtn").hide();
            $("#updateStatus,#backbtn,.chkoffline").show();
            $("#bank,#account,#system-search,#account,#provider").val('');
            $("#pageHead").html('Update Offline Status Of  Account Numbers');
            $("#statusflag").val('OFFLINE');
            chkinputBox();
        });
        $("#updateStatus").click(function () {
            $("#flag").val('MULTIUPDATE');
            var updateserno_str = '';
            $("." + currentclass).each(function () {
                if (this.checked == true) {
                    var rowid = $(this).prop('id');
                    var rowserno = rowid.split("_");
                    updateserno_str += "," + rowserno[1];
                }
            });
            $("#updatedSerno_str").val(updateserno_str.substr(1));
            $("#addbankaccount").submit();
        });
        $("#selectAllAcc").click(function () {
            if (this.checked) {
                $(".newaccountstatus").prop('checked', true);
            } else {
                $(".newaccountstatus").prop('checked', false);
            }
        });
        $("#selectAllOff").click(function () {
            if (this.checked) {
                $(".newofflinestatus").prop('checked', true);
            } else {
                $(".newofflinestatus").prop('checked', false);
            }
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
            if (classnot != 'search-query-sf' && !$("#updateStatus").is(':visible')) {
                var row_id = $(this).prop('id');//search-query-sf
                var row_val = row_id.split("##");
                $('#popup_view').modal('toggle');
                $("#modaltitle").text(" Change Account Details [ Bank Name : " + bankName[row_val[0]] + "]");
                $("#newAccountNum").val(row_val[1]);
                $("#serno").val(row_val[3]);
                if (row_val[2] == 'Y') {
                    $("#activeAcc").text("Active");
                    $("#changeStatus").val('Y');
                } else {
                    $("#activeAcc").text("Inactive");
                    $("#changeStatus").val('N');
                }
                if (row_val[4] == 'Y') {
                    $("#offlineActiveAcc").text("Active");
                    $("#changeOfflineStatus").val('Y');
                } else {
                    $("#offlineActiveAcc").text("Inactive");
                    $("#changeOfflineStatus").val('N');
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
            $("#flag").val('UPDATE');
            if ($("#serno").val() == '') {
                alert('Please Select Account Number.');
                return false;
            }
            if ($("#newAccountNumber").val() == '') {
                alert('Please Enter Account Number.');
                return false;
            }
            if ($("#changeStatus").val() == '') {
                alert('Please Set Status.');
                return false;
            }
            if ($("#changeOfflineStatus").val() == '') {
                alert('Please Set Offline Status.');
                return false;
            }
            $('#popup_view').modal('hide');
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
                }
                else
                {
                    $('.search-query-sf').remove();
                }

                if (rowText.indexOf(inputText) == -1)
                {
                    tableRowsClass.eq(i).hide();
                }
                else
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
    function chkinputBox() {
        var pro_count = 0;
        $('.' + currentclass).each(function () {
            if (this.checked == true) {
                pro_count++;
            }
        });
        if (pro_count == list_count) {
            $("." + currentclass + "all").prop('checked', true);
        } else {
            $("." + currentclass + "all").prop('checked', false);
        }
    }
</script>