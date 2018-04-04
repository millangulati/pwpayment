<?php
$agentTab = '';
$retailerTab = '';
if ($response['isRetailer']) {
    $retailerTab = 'active';
} else {
    $agentTab = 'active';
}

$SuccessMessage = isset($response["successmsg"]) ? $response["successmsg"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$generatereceipt = isset($response["generatereceipt"]) ? $response["generatereceipt"] : false;
$generatereceiptdata = isset($response["generatereceiptdata"]) ? $response["generatereceiptdata"] : '';
// 5da07
$agentinfo = isset($response['response']['result']) ? $response['response']['result'] : '';
//510571
$retailerinfo = isset($response['responseretailer']['result']) ? $response['responseretailer']['result'] : '';
$paymentmodeoptions = isset($response['paymentmode']) ? $response['paymentmode'] : '';
$bankoptions = isset($response['banklist']) ? $response['banklist'] : array();
$bankaccountno = array('' => 'Select Account Number');
$banksAccounts = isset($response['bankaccountlist']) ? $response['bankaccountlist'] : array();
$banksAccountsStr = "";
foreach ($banksAccounts AS $val => $name) {

    $banksAccountsStr .= "$$$" . $val;
}
$retailernames = array('' => 'Select Agent', '1' => 'Dummy Name');
$payOptions = array("paymentupto" => "A/C Upto", "ac_receipt" => "On A/c Receipt (From Agent)<br>", "debit_note" => "Debit Note<br>", "credit_note" => "Credit Note<br>", "modify" => "Modify Last Transaction<br>");
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'security.min'));
//echo $this->Html->css(array('clockpicker'));
$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-files-o font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Request', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
if ($generatereceipt && !empty($generatereceiptdata)) {
    ?>
    <div style="padding: 0px 20px;" class="contentDiv">
        <center>
            <span class="style20"><b>SUGAL AND DAMANI UTILITY SERVICES PVT. LTD.</b></span>
            <br>
            <span class="style18">6/35, W.E.A. KAROL BAGH, NEW DELHI - 110005</span>
            <br>
            <br>

            <div class="pageContentDiv style16">
                <p style="margin-top:0px;" class="reportHeader1">Request generated</p>
                <table class="table-responsive" cellspacing="0" border="0" style="width: 100%; ">
                    <tr class="trtop">
                        <td><label>Name:</label> <span><?php echo $generatereceiptdata['agentname']; ?></span></td>
                        <td><label>Voucher Date:</label> <span><?php echo date('d-m-Y'); ?></span></td>
                    </tr>
                    <tr class="trothers">
                        <td><label>Amount:</label> <span><?php echo $generatereceiptdata['cashamount']; ?></span></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="trothers">
                        <td><label>Bank Name:</label> <span><?php echo isset($generatereceiptdata['bankname']['BankMaster']['bankname']) ? $generatereceiptdata['bankname']['BankMaster']['bankname'] : 'N/A'; ?></span></td>
                        <td><label>Bank Account No:</label> <span><?php echo $generatereceiptdata['bankaccountno']; ?></span></td>
                    </tr>
                    <tr class="trothers">
                        <td><label>Cheque No:</label> <span><?php echo $generatereceiptdata['chequenumber']; ?></span></td>
                        <td><label>Cheque Date:</label> <span><?php echo $generatereceiptdata['chequedate']; ?></span></td>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            <span class="style20">
                <b>This Is A Temporary Receipt.</b>
            </span>
            <br>
            <span class="style18">
                <b>Your Receipt Has Been Saved Successfully For Authorization.</b>
            </span>
            <br>
            <?php
            echo $this->Form->create('cancelRequest', array("id" => "form-cancelRequest", "target" => "_self", "autocomplete" => "off"));
            echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
            $this->Form->unlockField("AuthVar");
            echo $this->Form->input("cancel_flag", array("label" => false, "type" => "hidden", 'id' => 'cancel_flag', "value" => ""));
            $this->Form->unlockField("cancel_flag");
            echo $this->Form->button('Back', array('id' => 'cancelrequest', 'type' => 'button', 'class' => 'btn btn-danger marginLeft25', 'style' => 'margin-top:10px;'));
            echo $this->Form->end();
            ?>
            <br>
        </center>
    </div>

    <?php
} else {


    echo '<ul class="nav nav-tabs">
        <li class="ta ' . $agentTab . '">
            <a aria-expanded="true" href="#portlet_agent_receipt" data-toggle="tab">
                Agent Receipt
            </a>
        </li>
        <li class="ta ' . $retailerTab . '">
            <a aria-expanded="false" href="#portlet_retailer_receipt" data-toggle="tab">
                Retailer Receipt
            </a>
        </li>
    </ul>';
    echo $this->Html->div('portlet-body-js portlet-body'); //main portlet-body
    echo $this->Html->div('tab-content'); //tab-content
    echo $this->Html->div("tab-pane " . $agentTab, NULL, array("id" => "portlet_agent_receipt"));

    echo $this->Form->create('cancelRequest', array("id" => "form-cancelRequest", "target" => "_self", "autocomplete" => "off"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->input("cancel_flag", array("label" => false, "type" => "hidden", 'id' => 'cancel_flag', "value" => ""));
    $this->Form->unlockField("cancel_flag");
    echo $this->Form->end();

// Agent Search Form
    echo $this->Form->create('generateAgentReceipt', array("id" => "form-generateAgentReceipt", "target" => "_self", "autocomplete" => "off", "type" => "file"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->input("agent_flag", array("label" => false, "type" => "hidden", 'id' => 'agent_flag', "value" => ""));
    $this->Form->unlockField("agent_flag");
    echo $this->Html->div('row'); //
    if (empty($agentinfo)) {
        echo $this->Html->div('form-group col-md-6');
        echo $this->Html->tag('label', 'Login Name or Party Code', array('for' => 'agent'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-list"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('agent', array('id' => 'agent', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Search agent login name or party code', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');
    }

    if (!empty($agentinfo)) {

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('agent-name', '<b>Agent Name:</b>');
        echo $this->Html->tag('span', $agentinfo['agentname'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('agent-code', '<b>Agent Code:</b>');
        echo $this->Html->tag('span', $agentinfo['agentcode'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('login-name', '<b>Login Name:</b>');
        echo $this->Html->tag('span', $agentinfo['loginname'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6');
        echo $this->Html->tag('label', 'Payment mode', array('for' => 'payment-mode'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-credit-card"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('paymentmode', array('id' => 'paymentmode', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $paymentmodeoptions, "empty" => "Select Payment Mode"));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 amount-js');
        echo $this->Html->tag('label', 'Amount', array('for' => 'cash-amount'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('cashamount', array('id' => 'cashamount', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Amount', 'onkeyup' => 'EnterNumericKeyOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 bank-name-js');
        echo $this->Html->tag('label', 'Bank Name', array('for' => 'bank'));
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

        echo $this->Html->div('form-group col-md-6 deposit-date-js');
        echo $this->Html->tag('label', 'Deposit Date', array('for' => 'reference-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('depositdate', array('id' => 'depositdate', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Deposit Date'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-number-js');
        echo $this->Html->tag('label', 'Cheque Number', array('for' => 'cheque-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('chequenumber', array('id' => 'chequenumber', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque number', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-date-js');
        echo $this->Html->tag('label', 'Cheque Date', array('for' => 'cheque-date'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('chequedate', array('id' => 'chequedate', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque date'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-bank-name-js');
        echo $this->Html->tag('label', 'Cheque Bank Name', array('for' => 'cheque-bank-name'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('chequebankname', array('id' => 'chequebankname', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque Bank Name', 'onkeyup' => 'EnterAlphaOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 reference-number-js');
        echo $this->Html->tag('label', 'Reference Number', array('for' => 'reference-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('referencenumber', array('id' => 'referencenumber', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Reference number', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 deposit-branch-code-js');
        echo $this->Html->tag('label', 'Deposit Branch Code', array('for' => 'deposit-branch-code'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-building-o"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('depositbranchcode', array('id' => 'depositbranchcode', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter branch code', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 remarks');
        echo $this->Html->tag('label', 'Remarks', array('for' => 'remarks'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('remarks', array('id' => 'remarks', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Remarks', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 slipfile-js', $this->Form->input('slipfile', array('id' => 'slipfile', 'label' => 'File', 'div' => FALSE, 'class' => 'form-control', "type" => "file")));

        echo $this->Form->hidden("agentcodehidden", array("value" => $agentinfo["agentcode"]));
        $this->Form->unlockField("agentcodehidden");
        echo $this->Form->hidden("agentnamehidden", array("value" => $agentinfo["agentname"]));
        $this->Form->unlockField("agentnamehidden");
        echo $this->Form->hidden("agentdbsernohidden", array("value" => $agentinfo["db_serno"]));
        $this->Form->unlockField("agentdbsernohidden");
        echo $this->Form->hidden("agentbranchcodehidden", array("value" => $agentinfo["branchcode"]));
        $this->Form->unlockField("agentbranchcodehidden");
        echo $this->Form->hidden("agentcounterhidden", array("value" => $agentinfo["agentcounter"]));
        $this->Form->unlockField("agentcounterhidden");
    }

    echo $this->Html->useTag('tagend', 'div'); // login details end
    echo "<hr>";
    echo $this->Html->div('form-actions'); //
    if (!empty($agentinfo)) {
        $this->Js->buffer('$("#agent").prop("disabled","true");');
        echo $this->Form->button('Submit Request', array('id' => 'submitagentrequest', 'type' => 'button', 'class' => 'btn green'));
        echo $this->Form->button('Cancel Request', array('id' => 'cancelrequest', 'type' => 'button', 'class' => 'btn btn-danger marginLeft25'));
    } else {
        echo $this->Form->button('Search Agent', array('id' => 'btnSearchAgent', 'type' => 'button', 'class' => 'btn green'));
    }
    echo $this->Js->writeBuffer();
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
// Agent Form Ends

    echo $this->Html->useTag('tagend', 'div'); //portlet_agent_receipt

    echo $this->Html->div("tab-pane " . $retailerTab, NULL, array("id" => "portlet_retailer_receipt"));
    echo $this->Form->create('generateRetailerReceipt', array("id" => "form-generateRetailerReceipt", "target" => "_self", "autocomplete" => "off", "type" => "file"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->input("flagretailer", array("label" => false, "type" => "hidden", 'id' => 'flagretailer', "value" => ""));
    $this->Form->unlockField("flagretailer");
    echo $this->Html->div('row'); //
    if (empty($retailerinfo)) {
        echo $this->Html->div('form-group col-md-6');
        echo $this->Html->tag('label', 'Retailer Name or Code', array('for' => 'retailer-name'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-list"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('retailer', array('id' => 'retailer', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Search retailer name or retailer code', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');
    }
    if (!empty($retailerinfo)) {

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('agent-name', '<b>Retailer Name:</b>');
        echo $this->Html->tag('span', $retailerinfo['agentname'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('agent-code', '<b>Retailer Code:</b>');
        echo $this->Html->tag('span', $retailerinfo['agentcode'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('col-md-4');
        echo $this->Html->div('form-group');
        echo $this->Form->label('login-name', '<b>Login Name:</b>');
        echo $this->Html->tag('span', $retailerinfo['loginname'], array('class' => 'strong'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6');
        echo $this->Html->tag('label', 'Payment mode', array('for' => 'payment-mode'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-credit-card"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_paymentmode', array('id' => 'r_paymentmode', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $paymentmodeoptions, "empty" => "Select Payment Mode"));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 amount-js');
        echo $this->Html->tag('label', 'Amount', array('for' => 'cash-amount'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_cashamount', array('id' => 'r_cashamount', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Amount', 'onkeyup' => 'EnterNumericKeyOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 bank-name-js');
        echo $this->Html->tag('label', 'Bank Name', array('for' => 'bank'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-university"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_bank', array('id' => 'r_bank', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankoptions, "empty" => "Select Bank"));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 account-no-js');
        echo $this->Html->tag('label', 'Bank Account No', array('for' => 'bankaccountno'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-navicon"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_bankaccountno', array('id' => 'r_bankaccountno', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankaccountno));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 deposit-date-js');
        echo $this->Html->tag('label', 'Deposit Date', array('for' => 'reference-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_depositdate', array('id' => 'r_depositdate', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Deposit Date'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-number-js');
        echo $this->Html->tag('label', 'Cheque Number', array('for' => 'cheque-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_chequenumber', array('id' => 'r_chequenumber', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque number', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-date-js');
        echo $this->Html->tag('label', 'Cheque Date', array('for' => 'cheque-date'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_chequedate', array('id' => 'r_chequedate', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque date'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 cheque-bank-name-js');
        echo $this->Html->tag('label', 'Cheque Bank Name', array('for' => 'cheque-bank-name'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_chequebankname', array('id' => 'chequebankname', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Cheque Bank Name', 'onkeyup' => 'EnterAlphaOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 reference-number-js');
        echo $this->Html->tag('label', 'Reference Number', array('for' => 'reference-number'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_referencenumber', array('id' => 'r_referencenumber', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Reference number', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 deposit-branch-code-js');
        echo $this->Html->tag('label', 'Deposit Branch Code', array('for' => 'deposit-branch-code'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-building-o"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_depositbranchcode', array('id' => 'r_depositbranchcode', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter branch code', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 remarks');
        echo $this->Html->tag('label', 'Remarks', array('for' => 'remarks'));
        echo $this->Html->div('input-group');
        echo $this->Html->tag('span', '<i class="fa fa-money"></i>', array('class' => 'input-group-addon'));
        echo $this->Form->input('r_remarks', array('id' => 'r_remarks', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Enter Remarks', 'onkeyup' => 'EnterAlphaNumericOnly(this)'));
        echo $this->Html->useTag('tagend', 'div');
        echo $this->Html->useTag('tagend', 'div');

        echo $this->Html->div('form-group col-md-6 slipfile-js', $this->Form->input('r_slipfile', array('id' => 'r_slipfile', 'label' => 'File', 'div' => FALSE, 'class' => 'form-control', "type" => "file")));

        echo $this->Form->hidden("r_agentcodehidden", array("value" => $retailerinfo["agentcode"]));
        $this->Form->unlockField("r_agentcodehidden");
        echo $this->Form->hidden("r_agentnamehidden", array("value" => $retailerinfo["agentname"]));
        $this->Form->unlockField("r_agentnamehidden");
        echo $this->Form->hidden("r_agentdbsernohidden", array("value" => $retailerinfo["db_serno"]));
        $this->Form->unlockField("r_agentdbsernohidden");
        echo $this->Form->hidden("r_agentbranchcodehidden", array("value" => $retailerinfo["branchcode"]));
        $this->Form->unlockField("r_agentbranchcodehidden");
        echo $this->Form->hidden("r_agentcounterhidden", array("value" => $retailerinfo["agentcounter"]));
        $this->Form->unlockField("r_agentcounterhidden");
    }

    echo $this->Html->useTag('tagend', 'div'); // login details end
    echo "<hr>";
    echo $this->Html->div('form-actions'); //
    if (!empty($retailerinfo)) {
        $this->Js->buffer('$("#retailer").prop("disabled","true");');
        echo $this->Form->button('Submit Request', array('id' => 'submitretailerrequest', 'type' => 'button', 'class' => 'btn green'));
        echo $this->Form->button('Cancel Request', array('id' => 'r_cancelrequest', 'type' => 'button', 'class' => 'btn btn-danger marginLeft25'));
    } else {
        echo $this->Form->button('Search Retailer', array('id' => 'btnSearchRetailer', 'type' => 'button', 'class' => 'btn green'));
    }
    echo $this->Js->writeBuffer();
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();

    echo $this->Html->useTag('tagend', 'div'); // portlet_retailer_receipt

    echo $this->Html->useTag('tagend', 'div'); /// tab-contentend
    echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
} // genereate receipt else statement
?>

<style>

    .table-responsive .trtop {
        width: 80%;
        border-bottom: 1px solid #ccc;
    }
    .table-responsive .trtop td {
        width: 40%;
        padding-bottom: 30px;
        margin-left: 65px;
        float: left;
    }
    .table-responsive tr td label {
        font-weight: bold;
    }
    .table-responsive .trothers td {
        width: 40%;
        padding-top: 10px;
        margin-left: 65px;
        float: left;
    }

    .pageContentDiv {
        min-width: 500px;
        max-width: 1200px;
        border-radius: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }
    .style16 {
        font-family: Calibri;
        color: #666666;
        font-size: 16px;
    }
    .reportHeader1 {
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #eee), color-stop(1, #eee) );
        background: -moz-linear-gradient( center top, #eee 5%, #eee 100% );
        background-color: #eee;
        border-radius: 10px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        text-indent: 0;
        color: #444444;
        font-family: calibri;
        font-size: 20px;
        font-style: normal;
        height: 40px;
        line-height: 40px;
        text-decoration: none;
        text-align: center;
    }
    .style20 {
        font-family: Calibri;
        color: #666666;
        font-size: 20px;
    }
    .style18 {
        font-family: Calibri;
        color: #666666;
        font-size: 18px;
    }


    .marginLeft25 {margin-left: 25px;}
    .amount-js, .bank-name-js, .account-no-js, .cheque-number-js, .reference-number-js,
    .slipfile-js, .remarks,.deposit-date-js, .cheque-date-js,.deposit-branch-code-js,.cheque-bank-name-js {
        display: none;
    }
    .mutiple-select {height: 200px;}
    .nav-tabs { background-color: #eee; border-bottom: 1px solid #ccc;}
    .nav-tabs > li.active { font-weight:bold; }
    .hidealert {
        display: none;
    }
    .input-group .input-group-addon { background-color: #eee !important; }
    input[type="file"] {padding:0px; border:none;}
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
    .alert {line-height: 3px;margin-bottom: -15px;}
    .table th{background-color: #2AB4C0; border-bottom: 1px solid;color:#fff;}

</style>
<script>
    var banksAccountsStr = "<?= $banksAccountsStr ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    $('#document').ready(function () {

        $('#agent,#paymentmode,#cashamount,#bank,#bankaccountno,#depositbranchcode,#remarks,#slipfile,#chequenumber,#referencenumber,#depositdate, #chequedate, #r_depositdate, #r_chequedate,\n\
        #retailer,#r_paymentmode,#r_cashamount,#r_bank,#r_bankaccountno,#r_depositbranchcode,#r_remarks,#r_slipfile,#r_chequenumber,#r_referencenumber').click(function () {
            clearMsg();
        });
        $('#depositdate, #chequedate, #r_depositdate, #r_chequedate').datepicker({
            maxDate: 0,
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true
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

        $("#r_bank").change(function () {
            $("#r_bankaccountno").html("<option value=''>Select Account Number</option>");
            //var bankname = $("#bank").find("option[value='" + $("#BoBank").val() + "']").html();
            var bankid = $("#r_bank").val();
            var banksAccounts = banksAccountsStr.split("$$$" + bankid + "###");
            for (var i = 1; i < banksAccounts.length; i++) {
                var optionStr = banksAccounts[i].split("$$$");
                optionStr = "<option value='" + optionStr[0] + "'>" + optionStr[0] + "</option>";
                $("#r_bankaccountno").append(optionStr);
            }
        });

        /*$('#cashamount').keypress(function (e) {
         var regex = new RegExp("^[0-9]+$");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
         return true;
         }

         e.preventDefault();
         return false;
         });*/


        $('#paymentmode, #r_paymentmode').change(function () {

            var val = $(this).val();
            if (val == '') {
                $('.amount-js, .bank-name-js, .account-no-js,.cheque-date-js, .cheque-number-js, .reference-number-js, .remarks, .slipfile-js,.deposit-date-js,.deposit-branch-code-js,.cheque-bank-name-js').hide();
                ErrorMsgFun('msgDiv', '&nbsp;');
                $('#msgDiv').removeAttr("class");
            } else if (val == '1') { // Cash in office
                $('.bank-name-js, .account-no-js,.cheque-date-js, .cheque-number-js, .reference-number-js, .slipfile-js,.deposit-date-js,.deposit-branch-code-js,.cheque-bank-name-js').hide();
                $('.amount-js, .remarks').show();
            } else if (val == '2') { // Cash in bank
                $('.amount-js, .bank-name-js, .account-no-js, .remarks, .slipfile-js,.deposit-date-js,.deposit-branch-code-js').show();
                $('.reference-number-js, .cheque-number-js, .cheque-date-js,.cheque-bank-name-js').hide();
            } else if (val == '3') { // Cheque
                $('.amount-js, .bank-name-js, .account-no-js,.cheque-date-js, .cheque-number-js, .remarks, .slipfile-js,.deposit-date-js,.deposit-branch-code-js,.cheque-bank-name-js').show();
                $('.reference-number-js').hide();
            } else if (val == '4') { // Net Banking
                $('.amount-js, .bank-name-js, .account-no-js, .reference-number-js, .remarks, .slipfile-js,.deposit-date-js,.deposit-branch-code-js').show();
                $('.cheque-number-js, .cheque-date-js,.cheque-bank-name-js').hide();
            } else if (val == '9') { // UPI
                $('.amount-js, .bank-name-js, .account-no-js, .reference-number-js, .remarks, .slipfile-js,.deposit-date-js,.deposit-branch-code-js').show();
                $('.cheque-number-js, .cheque-date-js,.cheque-bank-name-js').hide();
            }

        });
        $('#btnSearchAgent').click(function () {
            if ($('#agent').val() == '') {
                return ErrorMsgFun('agent', 'Please enter <b>Agent Name</b> or <b>Agent Code</b>.');
            } else {
                $('#agent_flag').val('searchagent');
                $('#form-generateAgentReceipt').submit();
            }
        });

        $('#btnSearchRetailer').click(function () {
            if ($('#retailer').val() == '') {
                return ErrorMsgFun('retailer', 'Please enter <b>Retailer Name</b> or <b>Reatiler Code</b>.');
            } else {
                $('#flagretailer').val('searchretailer');
                $('#form-generateRetailerReceipt').submit();
            }
        });


        $('#submitagentrequest').click(function () {
            if ($('#paymentmode').val() == '') {
                return ErrorMsgFun('paymentmode', 'Please select <b>Payment Mode</b>.');
            } else if ($('#cashamount').val() == '') {
                return ErrorMsgFun('cashamount', 'Please enter <b>Amount</b>.');
            } else if ($('#bank').val() == '' && $("#bank").is(':visible') === true) {
                return ErrorMsgFun('bank', 'Please select <b>Bank</b>.');
            } else if ($('#bankaccountno').val() == '' && $("#bankaccountno").is(':visible') === true) {
                return ErrorMsgFun('bankaccountno', 'Please select <b>Bank Account Number</b>.');
            } else if ($('#remarks').val() == '') {
                return ErrorMsgFun('remarks', 'Please enter <b>Remarks</b>.');
            } else if ($('#depositdate').val() == '' && $("#depositdate").is(':visible') === true) {
                return ErrorMsgFun('depositdate', 'Please select <b>Deposit Date</b>.');
            } else if ($('#chequenumber').val() == '' && $("#chequenumber").is(':visible') === true) {
                return ErrorMsgFun('chequenumber', 'Please enter <b>Cheque Number</b>.');
            } else if ($('#chequedate').val() == '' && $("#chequedate").is(':visible') === true) {
                return ErrorMsgFun('chequedate', 'Please select <b>Cheque Date</b>.');
            } else if ($('#referencenumber').val() == '' && $("#referencenumber").is(':visible') === true) {
                return ErrorMsgFun('referencenumber', 'Please enter <b>Reference Number</b>.');
            } else {
                $('#agent_flag').val('agentrequest');
                $('#agent').prop('disabled', false);
                $('#form-generateAgentReceipt').submit();
            }
        });

        $('#submitretailerrequest').click(function () {
            if ($('#r_paymentmode').val() == '') {
                return ErrorMsgFun('r_paymentmode', 'Please select <b>Payment Mode</b>.');
            } else if ($('#r_cashamount').val() == '') {
                return ErrorMsgFun('r_cashamount', 'Please enter <b>Amount</b>.');
            } else if ($('#r_bank').val() == '' && $("#r_bank").is(':visible') === true) {
                return ErrorMsgFun('r_bank', 'Please select <b>Bank</b>.');
            } else if ($('#r_bankaccountno').val() == '' && $("#r_bankaccountno").is(':visible') === true) {
                return ErrorMsgFun('r_bankaccountno', 'Please select <b>Bank Account Number</b>.');
            } else if ($('#r_remarks').val() == '') {
                return ErrorMsgFun('r_remarks', 'Please enter <b>Remarks</b>.');
            } else {
                $('#flagretailer').val('retailerrequest');
                $('#retailer').prop('disabled', false);
                $('#form-generateRetailerReceipt').submit();
            }
        });
        $('#cancelrequest').click(function () {
            $('#cancel_flag').val('cancelFromAgentTab');
            $('#form-cancelRequest').submit();

        });

        $('#r_cancelrequest').click(function () {
            $('#cancel_flag').val('cancelFromRetailerTab');
            $('#form-cancelRequest').submit();

        });

        if (sucmsg != '') {
            SuccMsgFun('msgDiv', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('msgDiv', msg);
        }

    });

</script>
