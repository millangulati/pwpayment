<?php
$SuccessMessage = isset($response["successmsg"]) ? $response["successmsg"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$paymentmodeoptions = isset($response['paymentmode']) ? $response['paymentmode'] : '';
$bankoptions = isset($response['banklist']) ? $response['banklist'] : array();
$branchlist = isset($response['branchlist']) ? $response['branchlist'] : array();
$bankaccountno = array('' => 'Select Account Number');
$banksAccounts = isset($response['bankaccountlist']) ? $response['bankaccountlist'] : array();
$entered_rs = isset($response['entered_rs']) ? $response['entered_rs'] : array();
$banksAccountsStr = "";
foreach ($banksAccounts AS $val => $name)
    $banksAccountsStr .= "$$$" . $val;
echo $this->Html->css('jBox.css');
echo $this->Html->script(array('jBox'));
echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'clockpicker', 'security.min'));
echo $this->Html->script('jquery.multiselect');
echo $this->Html->css('jquery.multiselect');
$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-sign-in font-green-sharp"></i>';
echo $this->Html->tag('span', 'Agent Payment Authentication', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Form->create('cancelRequest', array("id" => "form-cancelRequest", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->input("cancel_flag", array("label" => false, "type" => "hidden", 'id' => 'cancel_flag', "value" => ""));
$this->Form->unlockField("cancel_flag");
echo $this->Form->end();

$pendingRequestLists = isset($response['pendingRequestLists']) ? $response['pendingRequestLists'] : '';
if (!empty($pendingRequestLists)) {

    //pr($pendingRequestLists);
    $header = array("Branch", "Brand", "Date", "Remarks", "Deposit Date", "Agent", "Mode", "Bank Name", "Branch Code", "Cheque No.", "Amount");
    $header_value = array("branch_id", "brand", "dateval", "narration", "deposit_date", "countercode", "mode_id", "bankid", "deposit_branch_code", "chequeno", "amount", array("status", "receipt_url", "statement"));
    //$this->Js->buffer('$(".portlet-body-js").hide()');
    $this->Js->buffer('var y = $(window).scrollTop();');
    echo $this->Form->create("successbankstatement", array("id" => "form-successbankstatement", "target" => "_self", "autocomplete" => "off", "type" => "file"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    //echo $this->Form->input("flag", array("label"=>false, "type"=>"hidden", 'id'=>'flag',"value"=>""));
    //$this->Form->unlockField("flag");
    echo "<div id='tableDiv'>";
    echo $this->Html->para("font-green-sharp bold", "Payment List", array("style" => "text-align:center;"));
    //$Header = array_keys($result[0]);
    $k = 1;
    echo $this->Html->div('table-responsive');
    echo"<table id='tablereport' class='table table - striped'><thead class='header'><tr>";
    foreach ($header as $key) {
        echo "<th>" . ucwords(str_replace("_", " ", $key)) . "</th>";
    }
    echo "<th style='width:20%;'>Options</th>";
    echo "</tr></thead>";
    foreach ($pendingRequestLists as $row) {
        echo "<tr class='tabcol trcol" . $row['serno'] . "'>";
        foreach ($header_value as $key) {
            if (is_array($key)) {
                echo "<td class='optionstd'>";
                if ($response['branchcode'] != 'HO') {
                    for ($i = 0; $i < count($key); $i++) {
                        //if($response['isTime']) {
                        if ($row['mode_time_limit'] == 1) {
                            echo "You can't perform any action because of time limit settings.";
                            break;
                        } else {
                            if ($key[$i] == 'status') { //&& $response['branchcode'] != 'HO') {
                                //echo $this->Form->button( "Authorize", array("class"=>"btn-authorize button-action btn btn target-click", "button-data"=>$row[$key[$i]] ,"type"=>"button", "id"=>"slip_$k") );
                                if ($row[$key[$i]] == 'PENDING') {
                                    echo $this->Form->button("Revoke", array("class" => "btn-revoke button-action btn btn target-click", "onclick" => "return revoke(" . $row['serno'] . ",0);", "button-data" => $row[$key[$i]], "type" => "button", "id" => "slip_$k"));
                                } elseif ($row[$key[$i]] == 'AUTHENTICATED') {
                                    echo "Request is not granted yet from Head Office.";
                                    break;
                                }
                            } else if ($key[$i] == 'receipt_url' && $row[$key[$i]] != '') {

                                echo $this->Form->button("Slip", array("class" => "btn-slip button-action btn btn target-click", "button-data" => $row[$key[$i]], "type" => "button", "id" => "slip_$k"));
                            }
                            if ($response['offlinestatus'] && $key[$i] == 'statement') {
                                echo $this->Form->button("Authenticate", array("onclick" => "return authorize(" . $row['serno'] . ",0)", "class" => "btn-authorize button-action btn btn target-click", "type" => "button", "id" => "slip_$k"));
                            } else {
                                if ($key[$i] == 'statement') {
                                    echo $this->Form->button("View", array("class" => "btn-statement button-action btn btn target-click", "button-data" => $row[$key[$i]], "button-ser-no" => $row['serno'], "type" => "button", "id" => "slip_$k"));
                                }
                            }
                        }
                    }
                } else if ($response['branchcode'] == 'HO') {
                    for ($i = 0; $i < count($key); $i++) {
                        if ($key[$i] == 'status') { //&& $response['branchcode'] != 'HO') {
                            //if($response['isTime']) {
                            if ($row['mode_time_limit'] == 1) {
                                echo $this->Form->button("Revoke", array("class" => "btn-revoke button-action btn btn target-click", "onclick" => "return revoke(" . $row['serno'] . ",0);", "button-data" => $row[$key[$i]], "type" => "button", "id" => "slip_$k"));
                            } else {
                                if ($row[$key[$i]] == 'PENDING') {
                                    echo "Request is pending for authentication from branch office";
                                    break;
                                } else if ($row[$key[$i]] == 'AUTHENTICATED') {
                                    echo $this->Form->button("Revoke", array("class" => "btn-revoke button-action btn btn target-click", "onclick" => "return revoke(" . $row['serno'] . ",0);", "button-data" => $row[$key[$i]], "type" => "button", "id" => "slip_$k"));
                                }
                            }
                        } else if ($key[$i] == 'receipt_url' && $row[$key[$i]] != '') {

                            echo $this->Form->button("Slip", array("class" => "btn-slip button-action btn btn target-click", "button-data" => $row[$key[$i]], "type" => "button", "id" => "slip_$k"));
                        }
                        if ($response['offlinestatus'] && $key[$i] == 'statement') {
                            echo $this->Form->button("Grant", array("onclick" => "return grant(" . $row['serno'] . ",0)", "class" => "btn-authorize button-action btn btn target-click", "type" => "button", "id" => "slip_$k"));
                        } else {
                            if ($key[$i] == 'statement') {
                                echo $this->Form->button("View", array("class" => "btn-statement button-action btn btn target-click", "button-data" => $row[$key[$i]], "button-ser-no" => $row['serno'], "type" => "button", "id" => "slip_$k"));
                            }
                        }
                    }
                }
                echo "</td>";
            } else {
                echo "<td>" . $row[$key] . "</td>";
            }
        }
        echo "</tr>";
        $k++;
    }
    echo "</table></div>";
    echo $this->Html->div('table-responsive');
    echo $this->Form->button("Back", array("class" => "button-js btn btn-danger", "button-type" => 'cancel', "type" => "button", "id" => "cancel", "style" => array('margin-left:42%')));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
    echo $this->Js->writeBuffer();
} else {


    echo $this->Html->div('portlet-body-js portlet-body'); //main portlet-body
    echo $this->Form->create('agentPaymentAuthentication', array("id" => "form-agentPaymentAuthentication", "target" => "_self", "autocomplete" => "off", "type" => "file"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->input("pw_flag", array("label" => false, "type" => "hidden", 'id' => 'pw_flag', "value" => ""));
    $this->Form->unlockField("pw_flag");
    echo $this->Html->div('row'); //
    echo $this->Html->div('form-group col-md-6');
    echo $this->Html->tag('label', 'Payment Mode', array('for' => 'statementdate'));
    echo $this->Html->div('input-group');
    echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
//echo $this->Form->input('paymentmode', array('id' => 'paymentmode', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select",'options'=>$paymentmodeoptions, "empty"=>"Select Payment Mode"));
    echo $this->Form->input('paymentmode', array('id' => 'paymentmode', 'label' => false, 'div' => FALSE, 'multiple' => true, 'class' => 'form-control multiselectbox', "type" => "select", 'options' => $paymentmodeoptions, "empty" => "", 'selected' => ''));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('form-group col-md-6 bank-name-js');
    echo $this->Html->tag('label', 'Select Bank', array('for' => 'bank'));
    echo $this->Html->div('input-group');
    echo $this->Html->tag('span', '<i class="fa fa-university"></i>', array('class' => 'input-group-addon'));
    echo $this->Form->input('bank', array('id' => 'bank', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankoptions, "empty" => "Select Bank"));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('form-group col-md-6 account-no-js');
    echo $this->Html->tag('label', 'Bank Account No', array('for' => 'bankaccountno'));
    echo $this->Html->div('input-group');
    echo $this->Html->tag('span', '<i class="fa fa-navicon"></i>', array('class' => 'input-group-addon'));
    echo $this->Form->input('bankaccountno', array('id' => 'bankaccountno', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankaccountno));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->div('form-group col-md-6');
    echo $this->Html->tag('label', 'Branch', array('for' => 'bankaccountno'));
    echo $this->Html->div('input-group');
    echo $this->Html->tag('span', '<i class="fa fa-navicon"></i>', array('class' => 'input-group-addon'));
    echo $this->Form->input('branch', array('id' => 'branch', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $branchlist, "empty" => "Select Branch"));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
//echo $this->Html->useTag('tagend', 'div'); // login details end
    echo $this->Html->useTag('tagend', 'div'); // row end
    echo "<hr>";
    echo $this->Html->div('form-actions'); //
    echo $this->Form->button('Get Pending Requests', array('id' => 'btnPendingRequest', 'type' => 'button', 'class' => 'btn btn-danger'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
    echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
}
?>
<style>
    .ms-options-wrap > button:focus, .ms-options-wrap > button {
        border: 1px solid #ccc !important;
        padding: 6px 12px !important;
    }
    .button-action {margin-bottom: 5px; border: 1px #999 solid;}
    .account-no-js,.bank-name-js { display: none;}
    .marginLeft25 {margin-left: 25px;}
    .hidealert {
        display: none;
    }
    .input-group .input-group-addon { background-color: #eee !important; }
    input[type="file"] {padding:0px; border:none;}
    #tablereport .header td { font-weight: bold;}
    #tableDiv { padding-bottom: 20px;}
    .form-group label {
        padding-left: 0px;
    }
    .badgebox{opacity: 0;}
    .badgebox + .badge{text-indent: -999999px; width: 27px;}
    .badgebox:focus + .badge{ box-shadow: inset 0px 0px 5px;}
    .badgebox:checked + .badge{ text-indent: 0;}
    .fullbtn { background-color: #8D9BB2;        margin-top: 31px;width: 392px;}
    .aaa{background-color: #BCCAE1;}
    .abc { float:right; }
    .alert {line-height: 0px;margin-bottom: -10px; text-align: center;}
    .table th{background-color: #2AB4C0; border-bottom: 1px solid;color:#fff;}

</style>
<script>
    var baseurl = "<?= $ajaxbase ?>";
    var authcode = "<?= $response['authusercode'] ?>";
    var branchcode = "<?= $response['branchcode'] ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    var banksAccountsStr = "<?= $banksAccountsStr ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var entered_rs = JSON.parse('<?= json_encode($entered_rs) ?>');
    var myModal = new jBox('Modal', {
        width: 800,
        height: 400,
        blockScroll: false,
        animation: 'zoomIn',
        draggable: 'title',
        closeButton: true,
        overlay: false,
        reposition: false,
        repositionOnOpen: false
    });
    var myStatementModal = new jBox('Modal', {
        width: 1000,
        height: 200,
        blockScroll: false,
        animation: 'zoomIn',
        draggable: 'title',
        closeButton: true,
        overlay: false,
        reposition: false,
        repositionOnOpen: false
    });
    $('#document').ready(function () {

        $('#paymentmode').multiselect({
            columns: 1,
            placeholder: 'Select Payment Mode',
            search: true,
            selectAll: true,
            buttonTitle: function () {
            }

        });
        $('.btn-slip').click(function () {

            //myModal.attach('.btn-slip');
            myModal.setTitle('<i class="fa fa-arrows"></i> Attachment');
            myModal.setContent('<img style="width:100%;" src="http://www.paymentengine.com' + $(this).attr('button-data') + '" />');
            myModal.open({ignoreDelay: true});
        });
        $('.jBox-closeButton').click(function () {
            myModal.close();
            myStatementModal.close();
        });
        $('.btn-statement').click(function (e) {

            var dataString = "statementids=" + $(this).attr('button-data') + "&serno=" + $(this).attr('button-ser-no') + "&AuthVar=" + AuthVar;
            var url = baseurl + "/getStatementData";
            $('#loaderDiv').show();
            AsyncAjaxRequest(url, dataString, showStatement);
            e.preventDefault();
        });
        function showStatement(status, data) {

            if (status === 200) {
                var JSONObject = JSON.parse(data);
                if (JSONObject['tag'].toUpperCase().indexOf("#ERROR:") !== -1) {
                    return false;
                } else {
                    var count = 0;
                    var response = JSONObject['data'];
                    var serno = JSONObject['serno'];
                    var tabledata = "<div class='table-responsive'><table id='tablereport' class='table table - striped'>";
                    tabledata += "<thead class='header'><tr><td>Bank Name</td><td>Bank Account no</td><td>Amount</td><td>Remarks</td><td>Statement Date</td><td style='width:23%;'>Action</td></tr></thead>";
                    $.each(response, function (index, element) {
                        tabledata += "<tr>";
                        tabledata += "<td>" + element['BankStatementsData']['bankname'] + "</td>";
                        tabledata += "<td>" + element['BankStatementsData']['bank_account_no'] + "</td>";
                        tabledata += "<td>" + element['BankStatementsData']['credit_amount'] + "</td>";
                        tabledata += "<td>" + element['BankStatementsData']['remarks'] + "</td>";
                        tabledata += "<td>" + element['BankStatementsData']['statement_date'] + "</td>";
                        if (branchcode != 'HO') {
                            tabledata += "<td><button onclick='return authorize(" + serno + "," + element['BankStatementsData']['serno'] + "); ' class='btn-authorize button-action btn target-click' type='button'>Authenticate</button>";
                        } else {
                            tabledata += "<td><button onclick='return grant(" + serno + "," + element['BankStatementsData']['serno'] + "); ' class='btn-grant button-action btn target-click' type='button'>Grant</button>";
                        }
                        tabledata += "<button onclick='return revoke(" + serno + ",0); ' class='btn-revoke button-action btn target-click' type='button'>Revoke</button></td>";
                        tabledata += "</tr>";
                        count++;
                    });
                    if (count == 0) {
                        tabledata += "<tr><td colspan='6' align='center'>No record found in statement.</td></tr>"
                    }
                    tabledata += "<table></div>";
                    //myStatementModal.attach('.btn-statement');
                    myStatementModal.setTitle('<i class="fa fa-arrows"></i> Statement Data');
                    myStatementModal.setContent(tabledata);
                    myStatementModal.open({ignoreDelay: true});
                    //alert(JSON.stringify(JSONObject));
                }
                $('#loaderDiv').hide();
            } else {
//            $("#msgDiv").html("Error in Response.Please refresh and try again");
                $('.alert-normal-danger').show();
                $('#loaderDiv').hide();
                $('.alert-normal-danger').html('Error in Response.Please refresh and try again.');
                return false;
            }

        }

        $('#paymentmode').change(function () {
            $("#bank").val('');
            $("#bankaccountno").val('');
            var val = $(this).val();
            if (val == '') {
                $('.bank-name-js, .account-no-js').hide();
                ErrorMsgFun('msgDiv', '&nbsp;');
                $('#msgDiv').removeAttr("class");
            } else if (val == '1') { // Cash in office
                $('.bank-name-js, .account-no-js').hide();
            } else if (val == '2' || val == '3' || val == '4' || val == '9') {
                $('.bank-name-js, .account-no-js').show();
            } else {
                $('.bank-name-js, .account-no-js').show();
            }
        });
        $('.button-js').click(function () {
            var clickedbuttontype = $(this).attr("button-type");
            $('#pw_flag').val('canceldata');
            //}
            $('#form-cancelRequest').submit();
        });
        $("#btnPendingRequest").click(function () {

            if ($("#paymentmode").val() == '') {
                return ErrorMsgFun('paymentmode', 'Please select <b>Payment Mode</b>.');
            } else if ($("#bank").val() == '' && $("#bank").is(':visible') === true) {
                return ErrorMsgFun('bank', 'Please select <b>Bank Name</b>.');
            } else if ($("#bankaccountno").val() == '' && $("#bankaccountno").is(':visible') === true) {
                return ErrorMsgFun('bankaccountno', 'Please select <b>Bank Account Number</b>.');
            } else {
                $('#btnPendingRequest').prop('disabled', true);
                $('#pw_flag').val('pendingrequest');
                $('#form-agentPaymentAuthentication').submit();
            }
        });
        $("#bank").change(function () {
            $("#bankaccountno").html("<option value=''>Select Account Number</option>");
            //var bankname = $("#bank").find("option[value='" + $("#BoBank").val() + "']").html();
            var bankid = $("#bank").val();
            var banksAccounts = banksAccountsStr.split("$$$" + bankid + "###");
            for (var i = 1; i < banksAccounts.length; i++) {
                var optionStr = banksAccounts[i].split("$$$");
                optionStr = "<option value='" + optionStr[0] + "'>" + optionStr[0] + "</option>";
                $("#bankaccountno").append(optionStr);
            }
        });
        if (sucmsg != '') {
            SuccMsgFun('msgDiv', sucmsg);
        }
        if (msg != '') {
            $('#paymentmode').val('');
            $('#branch').val('');
            ErrorMsgFun('msgDiv', msg);
        }



    });
    function authorize(payment_ser_no, statement_no) {
        var conf = confirm("Sure, you want to authenticate ?");
        if (conf) {
            var dataString = "serno=" + payment_ser_no + "&statement_no=" + statement_no + "&authcode=" + authcode + "&entered_rs=" + JSON.stringify(entered_rs) + "&requestType='agent'&AuthVar=" + AuthVar;
            var url = baseurl + "/authorise";
            $('#loaderDiv').show();
            AsyncAjaxRequest(url, dataString, authorizerequest);
            return true;
        }
        return false;
    }

    function authorizerequest(status, data) {
        if (status === 200) {
            var JSONObject = JSON.parse(data);
            if (JSONObject['tag'].toUpperCase().indexOf("#ERROR:") !== -1) {
                ErrorMsgFun('msgDiv', "Something went wrong. Please try again later.");
                myStatementModal.close();
                $('#loaderDiv').hide();
                $(window).scrollTop(0);
                return false;
            } else {
                myStatementModal.close();
                var response = JSONObject['data'];
                $('#tablereport .trcol' + response + ' td.optionstd').html('Request is not granted yet from Head Office.');
                $('#tablereport .trcol' + response).css('backgroundColor', '#dedede');
                $('#tablereport .trcol' + response).animate({backgroundColor: "white"}, 1500);
                SuccMsgFun('msgDiv', "Request Authenticated Successfully.");
                $('#loaderDiv').hide();
                $(window).scrollTop(0);
            }
        } else {
            $('.alert-normal-danger').show();
            $('.alert-normal-danger').html('Error in Response.Please refresh and try again.');
            return false;
        }
    }


    function revoke(payment_ser_no, statement_no) {
        var conf = confirm("Sure, you want to revoke ?");
        if (conf) {
            var dataString = "serno=" + payment_ser_no + "&statement_no=" + statement_no + "&authcode=" + authcode + "&entered_rs=" + JSON.stringify(entered_rs) + "&requestType='agent'&AuthVar=" + AuthVar;
            var url = baseurl + "/revoke";
            $('#loaderDiv').show();
            AsyncAjaxRequest(url, dataString, revokerequest);
            return true;
        }
        return false;
    }

    function revokerequest(status, data) {
        if (status === 200) {
            var JSONObject = JSON.parse(data);
            if (JSONObject['tag'].toUpperCase().indexOf("#ERROR:") !== -1) {
                myStatementModal.close();
                $('#loaderDiv').hide();
                ErrorMsgFun('msgDiv', "Something went wrong. Please try again later.");
                $(window).scrollTop(0);
                return false;
            } else {
                myStatementModal.close();
                var response = JSONObject['data'];
                $('#tablereport .trcol' + response).remove();
                SuccMsgFun('msgDiv', "Request Revoked Successfully.");
                $('#loaderDiv').hide();
                $(window).scrollTop(0);
            }
        } else {
            $('.alert-normal-danger').show();
            $('.alert-normal-danger').html('Error in Response.Please refresh and try again.');
            return false;
        }
    }

    function grant(payment_ser_no, statement_no) {
        var conf = confirm("Sure, you want to grant ?");
        if (conf) {
            var dataString = "serno=" + payment_ser_no + "&statement_no=" + statement_no + "&authcode=" + authcode + "&entered_rs=" + JSON.stringify(entered_rs) + "&requestType=" + 'agent' + "&AuthVar=" + AuthVar;
            var url = baseurl + "/grant";
            $('#loaderDiv').show();
            AsyncAjaxRequest(url, dataString, grantrequest);
            return true;
        }
        return false;
    }

    function grantrequest(status, data) {
        if (status === 200) {
            var JSONObject = JSON.parse(data);
            if (JSONObject['tag'].toUpperCase().indexOf("#ERROR:") !== -1) {
                myStatementModal.close();
                var msgError = JSONObject['tag'].replace("#ERROR:", '');
                ErrorMsgFun('msgDiv', msgError);
                $(window).scrollTop(0);
                $('#loaderDiv').hide();
                return false;
            } else {
                myStatementModal.close();
                var response = JSONObject['data'];
                SuccMsgFun('msgDiv', "Request Granted Successfully.");
                $('#tablereport .trcol' + response).remove();
                $('#loaderDiv').hide();
                $(window).scrollTop(0);
            }
        } else {
            $('.alert-normal-danger').show();
            $('.alert-normal-danger').html('Error in Response.Please refresh and try again.');
            return false;
        }
    }
</script>
