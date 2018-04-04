<?php

$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
//$banklist = array('*' => 'All');
$branchList = isset($response["branchList"]) ? $response["branchList"] : array();
$responseData = isset($response["responseData"]) ? $response["responseData"] : array();
$paymentModeList = isset($response["result"]) ? $response["result"]["paymentMode"] : array();

$providers = isset($response["result"]) ? $response["result"]["providerlist"] : array();

foreach($providers as $p=>$val) {
    foreach($val as $v=>$val1) {
        $paymentModeList[$p]['mode_type'][$val1['provider_id']] = $v;
    }

}
//pr($paymentModeList);
$ratelist = isset($response["result"]) ? $response["result"]["ratelist"] : array();
//pr($ratelist);
$BankList = isset($response["result"]) ? $response["result"]["BankList"] : array();
$BankAccountlist = isset($response["result"]) ? $response["result"]["BankAccountlist"] : array();
$BankListName = isset($response["result"]) ? $response["result"]["BankListName"] : array();
$apptype = array('Agent' => 'Agent', 'Retailer' => 'Retailer', 'Distributor' => 'Distributor');
$baseurl = $this->Html->url(array('controller' => 'getJson'), true);
$provider_count = count($providers);
$branchList_count = count($branchList);
$paymentModeListcount = count($paymentModeList);
$crdate = DateMethod::AddDate(date('d-m-Y'), 1);
$providersModeType = isset($response["providerMode"]) ? $response["providerMode"] : array();
//pr($providersModeType);
$ratemode = array('Amount' => 'Amount', 'Percentage' => 'Percentage');
//pr($BankListName);
//pr($paymentModeList);

$tax = array('Inclusive' => 'Inclusive', 'Exclusive' => 'Exclusive');
$request_type = isset($response["request_type"]) ? $response["request_type"] : '';
$provider_values = array();
if($request_type != '') {
    $provider_values = $paymentModeList[$request_type]['mode_type'];
}
$getRateData = isset($response["getRateData"]) ? $response["getRateData"] : array();

echo $this->Html->script('bootbox.min');
//echo $this->Html->script(array('jsvalidation'));
echo $this->Html->css('modemap');
echo "<div class='alert alert-danger alert-normal-danger' hidden='hidden'>";
echo"</div>";
echo "<div id='msgDiv' class=''>&nbsp</div>";
//echo $this->Html->para(isset($response["color"]) ? $response["color"] : "text-red", isset($response["msg"]) ? $response["msg"] : "&nbsp;", array('id' => 'msgDiv', "style" => "text-align:center"));
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-inr font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Rate List', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
echo $this->Html->div('col-sm-12');

//echo $this->Html->tag('H3', 'Payment Rate List');


/*echo $this->Form->hidden("serno", array("id" => "serno", 'value' => ''));
echo $this->Form->unlockField('serno');
echo $this->Form->hidden("payment_type", array("id" => "payment_type", 'value' => ''));
echo $this->Form->unlockField('payment_type');
echo $this->Form->hidden("mode_id", array("id" => "mode_id", 'value' => ''));
echo $this->Form->unlockField('mode_id');
echo $this->Form->hidden("rate_date", array("id" => "rate_date", 'value' => ''));
echo $this->Form->unlockField('rate_date');
echo $this->Form->hidden("rate_mode", array("id" => "rate_mode", 'value' => ''));
echo $this->Form->unlockField('rate_mode');
echo $this->Form->hidden("bank_name", array("id" => "bank_name", 'value' => ''));
echo $this->Form->unlockField('bank_name');
echo $this->Form->hidden("acnt_no", array("id" => "acnt_no", 'value' => ''));
echo $this->Form->unlockField('acnt_no');
echo $this->Form->hidden("gst_type", array("id" => "gst_type", 'value' => ''));
echo $this->Form->unlockField('gst_type');
echo $this->Form->hidden("app_type_id", array("id" => "app_type_id", 'value' => ''));
echo $this->Form->unlockField('app_type_id');
echo $this->Form->hidden("amt_frm", array("id" => "amt_frm", 'value' => ''));
echo $this->Form->unlockField('amt_frm');
echo $this->Form->hidden("amt_to", array("id" => "amt_to", 'value' => ''));
echo $this->Form->unlockField('amt_to');
echo $this->Form->hidden("amt_val", array("id" => "amt_val", 'value' => ''));
echo $this->Form->unlockField('amt_val');
echo $this->Form->hidden("provider_id", array("id" => "provider_id", 'value' => ''));
echo $this->Form->unlockField('provider_id');*/

echo $this->Html->div("row"); //3
echo $this->Html->div('col-sm-12 col-md-12'); //4
//echo $this->Html->div("nav-tabs-custom");
$mainTab = 1; //
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <text class="navbar-brand" style='color: white'>Payment Type </text>
        </div>
        <ul class="nav navbar-nav">
            <?php
            foreach ($paymentModeList as $type => $mode) {
                echo '<li class= ' . ($mainTab > 0 ? "active" : "") . '><a data-toggle="tab" class="headtab" href="#' . $type . '"   onclick = "return selectTypeFun(\'' . $type . '\');">' . $type . '</a></li>';
                $mainTab = 0;
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right nav1">
        <?php
            if(isset($response["getRateData"]) && empty($getRateData)) {
        ?>
            <li class ='activel' id="saveicon"><a class="js-saveRate" href="javascript:void(0);"><span class="glyphicon  glyphicon-save"></span> Save Rate</a></li>
            <?php } else if(isset($response["getRateData"]) && !empty($getRateData)) { ?>
            <li class ='activel' id="updateicon"><a class="js-updateRate" href="javascript:void(0);"><span class="glyphicon  glyphicon-save"></span> Update Rate</a></li>
            <?php } ?>

        </ul>
    </div>
</nav>
<?php
$first = $second = 1;
echo $this->Html->div('', null, array('id' => 'contentDiv', 'class' => 'tab-content')); // 5

/*foreach ($paymentModeList as $type => $mode) {

    echo $this->Html->div('', null, array('id' => $type, 'class' => ($first > 0 ? "tab-pane active" : "tab-pane"))); // 6

    $first = 0;

    echo $this->Html->div('col-sm-12 col-xs-12 col-md-2 left'); // 7
    echo "<nav class=nav-sidebar>";
    echo '<ul class="nav nav-tabs-justified">';
    echo '<h4 style="color:#fff;"><center>Payment Mode</center></h4>';
    foreach ($mode as $modename => $modevalue) {
        $cl = ($second > 0 ? "listmode active" : "listmode");
        echo '<li class = "' . $cl . '" id="' . $type . $modename . '" ><a data-toggle="tab" href="#' . $modename . '"  onclick = "return selectModeFunc(\'' . $modevalue['mode_id'] . '\',\'' . $type . '\',\'' . $modename . '\');">' . $modename . '</a></li>';
        $second = 0;
    }
    echo '</ul>';

    echo "</nav>";
    echo $this->Html->useTag('tagend', 'div'); //7 end
    echo '<h4 class=headrightDiv><center><span id =headingLine' . $type . ' >Select  Payment Mode</span></center></h4><hr>';

    echo $this->Html->div('', null, array('id' => 'viewRateListDiv' . $type, 'class' => 'tab-content')); // viewRateListDiv
    echo "<div class=table-responsive>";
    echo $this->Html->div('', null, array('class' => 'paymentdiv', 'id' => 'paymentdiv' . $type));
    echo $this->Html->useTag('tagend', 'div');
    echo "</div>";
    echo $this->Html->useTag('tagend', 'div'); // viewRateListDiv end


    echo $this->Html->useTag('tagend', 'div'); //6 end
}
*/
/*echo $this->Html->div('', null, array('id' => 'addRateListDiv', 'class' => 'tab-content main')); //11
echo "<div id = bankDiv>"; //bankdiv
echo $this->Html->div("row");


echo $this->Html->div('', null, array('id' => 'requestDiv')); //requestDiv

echo $this->Html->div('', null, array('id' => 'serviceProvider'));
echo $this->Html->div('col-sm-6 col-md-3 form-group', $this->Form->label('serviceprovider', '  Service Provider'));

echo $this->Html->div('col-md-6 col-sm-6 form-group', $this->Form->label('providerVal', '', array("id" => "providerVal")));
//echo $this->Form->input("serviceprovider", array("id" => "serviceprovider", "label" => FALSE, 'div' => array('class' => 'col-md-4 col-sm-6 form-group'), 'options' => $providers, 'empty' => 'Select Service Provider', "class" => "form-control serviceprovider"));
echo $this->Html->useTag('tagend', 'div');



echo $this->Html->div('', null, array('id' => 'bankacntdiv')); //bankacntdiv
echo $this->Html->div('', null, array('id' => 'Reqbank'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('bankname', 'Bank Name*'));
echo $this->Form->input("Reqbankname", array("id" => "Reqbankname", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'options' => '', 'empty' => 'Select Bank', "class" => "form-control bankname"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('col-md-1 col-sm-0', '');
echo $this->Html->div('', NULL, array('id' => 'accountDiv'));
echo $this->Html->div('col-md-2 col-sm-3 form-group', $this->Form->label('accountno', 'Account No.*'));
echo $this->Form->input("accountno", array("id" => "accountno", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'empty' => "Select Account", 'options' => '', "class" => "form-control accountno"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div'); //end bankacntdiv
echo $this->Html->useTag('tagend', 'div'); //end requestDiv
echo $this->Html->div('', null, array('id' => 'PayCollDiv')); //PayCollDiv
echo $this->Html->div('', null, array('id' => 'service_ProviderRow'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('service_Providerlabel', 'Service Provider*'));
echo $this->Form->input("service_Provider", array("id" => "service_Provider", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'options' => '', 'empty' => '', "class" => "form-control serviceprovider"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('col-md-1 col-sm-0', '');

echo $this->Html->div('', null, array('id' => 'bank'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('bankname', 'Bank Name*'));
echo $this->Form->input("bankname", array("id" => "bankname", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'options' => '', 'empty' => 'Select Bank', "class" => "form-control bankname"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div'); //end PayCollDiv

echo $this->Html->div('', null, array('id' => 'ratediv'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('ratedate', 'Rate Date*'));
echo $this->Form->input("ratedate", array("id" => "ratedate", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'value' => $crdate, "class" => "form-control ratedate"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('col-md-1 col-sm-0', '');

echo $this->Html->div('', NULL, array('id' => 'taxdiv'));
echo $this->Html->div('col-md-2 col-sm-3 form-group', $this->Form->label('tax', 'Tax*', array('id' => 'taxlabel')));
echo $this->Form->input("tax", array("id" => "tax", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'empty' => "--Select--", 'options' => $tax, "class" => "form-control tax"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', null, array('id' => 'amtfiledfrom'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('amtfrom', 'Minimum Amount*'));
echo $this->Form->input("amtfrom", array("id" => "amtfrom", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'maxlength' => '12', 'value' => '', "class" => "form-control amtfrom", "onkeypress" => 'return numericWithDotconly(event,this.id);'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('col-md-1 col-sm-0', '');
echo $this->Html->div('', NULL, array('id' => 'amtfiledto'));
echo $this->Html->div('col-md-2 col-sm-3 form-group', $this->Form->label('amtto', 'Maximum Amount*'));
echo $this->Form->input("amtto", array("id" => "amtto", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'maxlength' => '12', 'value' => '', "class" => "form-control amtto", "onkeypress" => 'return numericWithDotconly(event,this.id);'));
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('', null, array('id' => 'ratemodefield'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('ratemode', 'Rate Mode*'));
echo $this->Form->input("ratemode", array("id" => "ratemode", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'empty' => "--Select Type--", 'options' => $ratemode, "class" => "form-control ratemode"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('col-md-1 col-sm-0', '');
echo $this->Html->div('', NULL, array('id' => 'amountfield'));
echo $this->Html->div('col-md-2 col-sm-3 form-group', $this->Form->label('amountlabel', 'Commission*', array('id' => 'amountlabel')));
echo $this->Form->input("amount", array("id" => "amount", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'maxlength' => '12', 'value' => '', "class" => "form-control amount", "onkeypress" => 'return numericWithDotconly(event,this.id);'));
echo $this->Html->useTag('tagend', 'div');
//echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', null, array('id' => 'apptypefield'));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->label('apptype', 'App Type*'));
echo $this->Form->input("apptype", array("id" => "apptype", "label" => FALSE, 'div' => array('class' => 'col-md-2 col-sm-3 form-group'), 'empty' => "--Select Mode--", 'options' => $apptype, "class" => "form-control apptype"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo"</div>"; // close bankdiv

echo $this->Html->useTag('tagend', 'div'); // 11 end
//////addRateListDiv end
*/
$ll=0;
foreach ($paymentModeList as $type => $mode) {

    //pr($mode);
    echo $this->Html->div('', null, array('id' => $type, 'class' => ($first > 0 ? "tab-pane active" : "tab-pane"))); // 6
    echo $this->Form->create('ratelistform_'.$type, array("id" => "ratelistform_".$type, "target" => "_self", "autocomplete" => "off"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    echo $this->Form->hidden("submitflag", array("id" => "submitflag", 'value' => $type));
    echo $this->Form->unlockField('submitflag');

    $first = 0;
?>

<div class="row">
    <div class="col-md-3 col-sm-3 form-group">
        <label for="provider">Payment Mode</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-credit-card"></i>
            </span>
            <?php
                $mode_type = implode("##",$mode['mode_type']);
                $modeoptions = array();
                foreach ($mode as $modename => $modevalue) {

                    if($modename!='mode_type') {
                        $cl = ($second > 0 ? "listmode active" : "listmode");
                        $modeoptions[$modevalue['mode_id'].','.$type.','.$mode_type]= $modename;
                        $second = 0;
                    }
                }
                echo $this->Form->input('payment_mode', array('id' => 'payment_mode', 'label' => false, 'div' => FALSE, 'class' => 'payment_mode form-control', "type" => "select", 'options' => $modeoptions, "empty" => "Select Payment Mode"));
            ?>
            <!--<select name="data[payment_mode]" id="payment_mode" class="payment_mode form-control">
                <option value="">Select mode</option>
            <?php
            $mode_type = implode("##",$mode['mode_type']);
            foreach ($mode as $modename => $modevalue) {

                if($modename!='mode_type') {
                    $cl = ($second > 0 ? "listmode active" : "listmode");
                    echo "<option value='".$modevalue['mode_id'].','.$type.','.$mode_type."'>".$modename."</option>";
                    $second = 0;
                }
            }
            ?>
            </select>-->

        </div>
    </div>
    <div class="col-md-3 col-sm-3 form-group">
        <label for="provider">Provider</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-sitemap"></i>
            </span>
            <?php
                echo $this->Form->input('provider', array('id' => 'provider', 'label' => false, 'div' => FALSE, 'class' => 'provider form-control', "type" => "select", 'options' => $provider_values, "empty" => "Select Provider"));
            ?>
            <!--<select name="data[provider_<?php echo $type; ?>]" id="provider_<?php echo $type; ?>" class="form-control">
                <option value="">Select Provider</option>
            </select>-->
        </div>
    </div>

    <div class="col-md-3 col-sm-3 form-group">
        <label for="provider">Applicable Date</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <?php
                echo $this->Form->input('applicable_date', array('id' => 'applicable_date_'.$type, 'label' => false, 'div' => FALSE, 'class' => 'form-control'));
            ?>

        </div>

    </div>
    <div class="col-md-2 col-sm-2 form-group">
        <label for="provider">&nbsp;</label>
        <button id="js-submit-btn_<?php echo $type; ?>" data-value='<?php echo $type; ?>' type="button" class="btn green form-control js-submit-btn">Submit</button>
    </div>
</div>

<?php
echo $this->Form->end();
//echo '<h4 class=headrightDiv><center><span id =headingLine' . $type . ' >Select  Payment Mode</span></center></h4><hr>';
//
//echo $this->Html->div('', null, array('id' => 'viewRateListDiv' . $type, 'class' => 'tab-content')); // viewRateListDiv
//echo "<div class=table-responsive>";
//    echo $this->Html->div('', null, array('class' => 'paymentdiv', 'id' => 'paymentdiv' . $type));
//    echo $this->Html->useTag('tagend', 'div');
//    echo "</div>";
//echo $this->Html->useTag('tagend', 'div'); // viewRateListDiv end


echo $this->Html->useTag('tagend', 'div'); //6 end


}
?>



<hr />

<?php
echo $this->Form->create('ratedataform', array("id" => "ratedataform", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
echo $this->Form->hidden("selected_mode", array("id" => "selected_mode"));
echo $this->Form->unlockField('selected_mode');
echo $this->Form->hidden("selected_provider", array("id" => "selected_provider"));
echo $this->Form->unlockField('selected_provider');
echo $this->Form->hidden("selected_applicable_date", array("id" => "selected_applicable_date"));
echo $this->Form->unlockField('selected_applicable_date');
echo $this->Form->hidden("rateDataFlag", array("id" => "rateDataFlag"));
echo $this->Form->unlockField('rateDataFlag');

$options_taxes = array('INCLUSIVE'=>'Inclusive','EXCLUSIVE'=>'Exclusive');
$options_comm_mode = array('AMOUNT'=>'Fixed','PERCENTAGE'=>'Percentage');
$showRateStructure = isset($response["showRateStructure"]) ? $response["showRateStructure"] : array();
$selectedProvider = isset($response["selectedProvider"]) ? $response["selectedProvider"] : '';
if(!empty($showRateStructure) && $showRateStructure!='' && $selectedProvider!='') {
    if($showRateStructure == 'pwoffice') {
?>
<div class="form-group">
    <fieldset>
        <legend>PWOffice</legend>
        <div id="outerDiv1">
            <?php
                if(!empty($getRateData)) {
                    foreach($getRateData as $rd) {
            ?>
            <div class="row slab-row1" row-num='1'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['minslabamt']; ?>'  data-value='<?php echo $rd['minslabamt']; ?>'  class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['maxslabamt']; ?>' data-value='<?php echo $rd['maxslabamt']; ?>' class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <select class="form-control js-highlight-chng-val" data-value='<?php echo $rd['ratemode']; ?>' name="data[mode]">
                        <option value='AMOUNT'>Fixed</option>
                        <option value='PERCENTAGE'>Percentage</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['comm_amount']; ?>' data-value='<?php echo $rd['comm_amount']; ?>'  class="js-highlight-chng-val form-control" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <select class="form-control js-highlight-chng-val" name="data[mode]">
                        <option>Inclusive</option>
                        <option>Exclusive</option>
                    </select>
                </div>
            </div>
            <?php
                    } // end foreach
                } /* endIf  */ else {
                    // for empty data, show single row
            ?>
            <div class="row slab-row1" row-num='1'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <?php
                        //echo $this->Form->input('minamt', array('id' => 'minamt', 'value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'provider form-control', "type" => "select", 'options' => $provider_values, "empty" => "Select Provider"));
                        echo $this->Form->input('minamt', array('id' => 'minamt', 'name'=>'data[slab][minamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>

                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <?php
                        echo $this->Form->input('maxamt', array('id' => 'maxamt', 'name'=>'data[slab][maxamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <?php
                        echo $this->Form->input('comm_mode', array('id' => 'comm_mode', 'name'=>'data[slab][comm_mode][]' ,'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $options_comm_mode));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <?php
                        echo $this->Form->input('comm_amount', array('id' => 'comm_amount', 'name'=>'data[slab][comm_amount][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <?php
                        echo $this->Form->input('gst_tax', array('id' => 'gst_tax','name'=>'data[slab][gst_tax][]', 'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $options_taxes));
                    ?>
                </div>
            </div>
                <?php

                }
                ?>

        </div>
        <div class="row last_row1">
            <div class="col-sm-5 col-md-7">
                <a href="javascript:void(0);" class="js_add-slab-link" link-data='1'><span class="glyphicon glyphicon-plus"></span>&nbsp;Add slab</a>
            </div>
            <div class="col-sm-3 col-md-2">
            </div>
            <div class="col-sm-3 col-md-2">
                <!--<div class="checkbox checkbox-primary">
                    <input name="data[tired_comm]" id="tired_comm" value="0" class="menurights-js" checked="checked" type="checkbox">
                    <label for="menucode9">Tiered Commission</label>
                </div>-->
            </div>
            <div class="col-sm-1 col-md-1">
                <label for="sbi_minamt">&nbsp;</label>

            </div>

        </div>



    </fieldset>
</div>
<?php
    } else if($showRateStructure == 'pwbank') {
 ?>
<div class="form-group">
<?php
    if(isset($BankList[$selectedProvider]) && $BankList[$selectedProvider]!='') {
        $bankids = explode(",",$BankList[$selectedProvider]);

        for($l=0;$l<count($bankids);$l++) {

            $bankid = $bankids[$l];

            if($l==0) {
?>
    <fieldset>
        <legend>Default</legend>
        <div id="outerDiv1" class="default_fieldset">

            <div class="row slab-row1" row-num='1'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <?php
                        //echo $this->Form->input('minamt', array('id' => 'minamt', 'value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'provider form-control', "type" => "select", 'options' => $provider_values, "empty" => "Select Provider"));
                        echo $this->Form->input('default_minamt', array('id' => 'default_minamt', 'name'=>'data[default]['.$bankid.'][minamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>

                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <?php
                        echo $this->Form->input('default_maxamt', array('id' => 'default_maxamt', 'name'=>'data[default]['.$bankid.'][maxamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <?php
                        echo $this->Form->input('default_comm_mode', array('id' => 'default_comm_mode', 'name'=>'data[default]['.$bankid.'][comm_mode][]' ,'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $options_comm_mode));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <?php
                        echo $this->Form->input('default_comm_amount', array('id' => 'default_comm_amount', 'name'=>'data[default]['.$bankid.'][comm_amount][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <?php
                        echo $this->Form->input('default_gst_tax', array('id' => 'default_gst_tax','name'=>'data[default]['.$bankid.'][gst_tax][]', 'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $options_taxes));
                    ?>
                </div>
            </div>
        </div>
        <div class="row last_row1">
            <div class="col-sm-5 col-md-7">
                <a href="javascript:void(0);" class="js_default_add-slab-link" link-data='1'><span class="glyphicon glyphicon-plus"></span>&nbsp;Add slab</a>
            </div>
            <div class="col-sm-3 col-md-2">

    <!--<input id="checkbox2" type="checkbox" checked="false">-->
    <!--<input name="data[apply_for_all]" id="apply_for_all" value="9" class="menurights-js" type="checkbox">-->


                <div class="checkbox checkbox-primary">

                    <input name="data[menucodes]" id="menucode8" value="" data-value="new" class="menurights-js" type="checkbox">
                    <label for="menucode8">Apply for all</label>
                </div>

            </div>
            <div class="col-sm-3 col-md-2">
                <div class="checkbox checkbox-primary">
                    <input name="data[tired_comm]" id="tired_comm" value="0" class="menurights-js"  type="checkbox">
                    <label for="menucode9">Tiered Commission</label>
                </div>
            </div>
            <div class="col-sm-1 col-md-1">
                <label for="sbi_minamt">&nbsp;</label>

            </div>

        </div>
    </fieldset>
<?php
            }
?>
    <fieldset>
        <legend><?php echo $BankListName[$bankid]; ?></legend>
        <div id="outerDiv<?php echo $l+1; ?>" class="other_banks_div">
            <?php
                $rowcount =1;
                if(!empty($getRateData) && isset($getRateData[$bankid]) && !empty($getRateData[$bankid])) {
                    foreach($getRateData[$bankid] as $key=>$rd) {

            ?>
            <div class="row slab-row<?php echo $rowcount; ?>" row-num='<?php echo $rowcount; ?>'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['minslabamt']; ?>'  data-value='<?php echo $rd['minslabamt']; ?>'  class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['maxslabamt']; ?>' data-value='<?php echo $rd['maxslabamt']; ?>' class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <select class="form-control js-highlight-chng-val" data-value='<?php echo $rd['ratemode']; ?>' name="data[mode]">
                        <option value='AMOUNT'>Fixed</option>
                        <option value='PERCENTAGE'>Percentage</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <input type="text" name="data[minamt]" value='<?php echo $rd['comm_amount']; ?>' data-value='<?php echo $rd['comm_amount']; ?>'  class="js-highlight-chng-val form-control" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <select class="form-control js-highlight-chng-val" name="data[mode]">
                        <option>Inclusive</option>
                        <option>Exclusive</option>
                    </select>
                </div>
            </div>
            <?php
                    }
                } else {
            ?>
            <div class="row slab-row1" row-num='1'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <?php
                        //echo $this->Form->input('minamt', array('id' => 'minamt', 'value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'provider form-control', "type" => "select", 'options' => $provider_values, "empty" => "Select Provider"));
                        echo $this->Form->input('minamt', array('id' => 'minamt', 'name'=>'data[slab]['.$bankid.'][minamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'js_empty_min_amt form-control', "type" => "text"));
                    ?>

                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <?php
                        echo $this->Form->input('maxamt', array('id' => 'maxamt', 'name'=>'data[slab]['.$bankid.'][maxamt][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'js_empty_max_amt form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <?php
                        echo $this->Form->input('comm_mode', array('id' => 'comm_mode', 'name'=>'data[slab]['.$bankid.'][comm_mode][]' ,'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'js_empty_comm_mode form-control', "type" => "select", 'options' => $options_comm_mode));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <?php
                        echo $this->Form->input('comm_amount', array('id' => 'comm_amount', 'name'=>'data[slab]['.$bankid.'][comm_amount][]' ,'value'=>'','data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'js_empty_comm_amt form-control', "type" => "text"));
                    ?>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <?php
                        echo $this->Form->input('gst_tax', array('id' => 'gst_tax','name'=>'data[slab]['.$bankid.'][gst_tax][]', 'data-value'=>'', 'label' => false, 'div' => FALSE, 'class' => 'js_empty_gst form-control', "type" => "select", 'options' => $options_taxes));
                    ?>
                </div>
            </div>
            <?php
                }
            ?>

        </div>
        <div class="row last_row1">
            <div class="col-sm-5 col-md-7">
                <a href="javascript:void(0);" class="js_add-slab-link" link-data='<?php echo $l+1; ?>'><span class="glyphicon glyphicon-plus"></span>&nbsp;Add slab</a>
            </div>
            <div class="col-sm-3 col-md-2">
            </div>
            <div class="col-sm-3 col-md-2">
                <!--<div class="checkbox checkbox-primary">
                    <input name="data[tired_comm]" id="tired_comm" value="0" class="menurights-js" checked="checked" type="checkbox">
                    <label for="menucode9">Tiered Commission</label>
                </div>-->
            </div>
            <div class="col-sm-1 col-md-1">
                <label for="sbi_minamt">&nbsp;</label>

            </div>

        </div>
    </fieldset>
    <?php
    }
    }
    ?>

</div>

<?php
    }
    else {
?>
<div class="form-group">
    <fieldset>
        <legend>State Bank of India</legend>
        <div id="outerDiv1">
            <div class="row slab-row1" row-num='1'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <input type="text" name="data[minamt]" value='2000'  data-value='2000'  class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <input type="text" name="data[minamt]" value='' data-value='' class="form-control js-highlight-chng-val" />
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <select class="form-control js-highlight-chng-val" data-value='' name="data[mode]">
                        <option value=''>Fixed</option>
                        <option value='1'>Percentage</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <input type="text" name="data[minamt]" class="form-control" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <select class="form-control" name="data[mode]">
                        <option>Inclusive</option>
                        <option>Exclusive</option>
                    </select>
                </div>


            </div>

            <div class="row slab-row2" row-num='2'>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Min. Amount</label>
                    <input type="text" name="data[minamt]" class="form-control" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Max. Amount</label>
                    <input type="text" name="data[minamt]" class="form-control" />
                </div>
                <div class="col-sm-3 col-md-3">
                    <label for="sbi_minamt">Mode</label>
                    <select class="form-control" name="data[mode]">
                        <option>Fixed</option>
                        <option>Percentage</option>
                    </select>
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">Commission Amount</label>
                    <input type="text" name="data[minamt]" class="form-control" />
                </div>
                <div class="col-sm-2 col-md-2">
                    <label for="sbi_minamt">GST</label>
                    <select class="form-control" name="data[mode]">
                        <option>Inclusive</option>
                        <option>Exclusive</option>
                    </select>
                </div>
                <div class="col-sm-1 col-md-1">
                    <label for="sbi_minamt">&nbsp;</label>
                    <a class="form-control js-cross-icon" link-data="1,2"><i class="fa fa-close" style="font-size:24px;color:red;"></i></a>
                </div>

            </div>
        </div>
        <div class="row last_row1">
            <div class="col-sm-5 col-md-7">
                <a href="javascript:void(0);" class="js_add-slab-link" link-data='1'><span class="glyphicon glyphicon-plus"></span>&nbsp;Add slab</a>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="checkbox checkbox-primary">

                    <input name="data[apply_for_all]" id="apply_for_all" value="9" class="menurights-js" checked="checked" type="checkbox">
                    <label for="menucode9">Apply for all</label>
                </div>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="checkbox checkbox-primary">
                    <input name="data[tired_comm]" id="tired_comm" value="0" class="menurights-js" checked="checked" type="checkbox">
                    <label for="menucode9">Tiered Commission</label>
                </div>
            </div>
            <div class="col-sm-1 col-md-1">
                <label for="sbi_minamt">&nbsp;</label>

            </div>

        </div>



    </fieldset>
</div>
<?php
    }
}
echo $this->Form->end();

echo $this->Html->useTag('tagend', 'div');  //5 end
//echo $this->Html->useTag('tagend', 'div'); //nav-tabs-custom test
echo $this->Html->useTag('tagend', 'div'); //4 end
echo $this->Html->useTag('tagend', 'div'); // 3 end
echo $this->Html->useTag('tagend', 'div'); // 2 end
echo $this->Html->useTag('tagend', 'div'); // row-1 end
echo $this->Html->useTag('tagend', 'div'); // 1 end
//echo $this->Form->end();
?>

<style>
    .activel{background-color: rgba(65, 72, 95, 0.49);}
    #tax_amount{min-width: 40px;}
    /*#paymentdiv{overflow-x: auto;overflow-y: auto;margin-bottom: 12px;}*/
    #tablereport{overflow: auto;width: 98%;overflow-x: auto;}
    .table th{background-color: #2b3b55; border-bottom: 2px solid; color:#fff;}
    .table tr{border-bottom: 1px solid ;color:black}
    .bodyclass tr:hover {background-color: #2ab4c0; cursor: pointer; cursor: hand;}
    .table-responsive { height: 325px;overflow-y: auto;overflow-x: auto;}
    .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #c4d5d5;
    }
    .table th {
        background-color: #C0C0D3;
        border: 1px solid #f4f4f4;
        width: 82px;
        color: #515151;
        border-left: 1px solid;
        border-right: 1px solid;
    }
    .alert {line-height: 3px;margin-bottom: -15px;}
    .tools{margin-right: 10px;display: none;}
    div label { font-weight: bold;}
    fieldset
    {
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;
        position: relative;
        border-radius:4px;
        background-color:#f6f6f6;
        padding-left:10px!important;
        margin-bottom: 20px;
        margin-top: 35px;
    }

    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px;
        width: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 5px 5px 10px;
        background-color: #ddd;
        /*border: none;*/
        padding-right: 10px;

    }
    .js_add-slab-link, .js_default_add-slab-link {
        color: #17c4bb;
        float: left;
        padding: 20px 0px;
    }
    .js_add-slab-link:hover, .js_default_add-slab-link:hover {
        text-decoration: underline;
        color: #17c4bb;

    }
    .checkbox-primary {
        padding: 20px 0px 20px 20px;
        margin-top: 0px;

    }


    div[class^='slab-row'], div[class*=' slab-row'] {
        margin: 0px;
        /*padding-bottom: 10px;*/

    }
    .row div[class^='col-'] {
        padding-bottom: 10px;
    }
    div[class^='last_row'], div[class*=' last_row'] {
        margin: 0px;
    }
    .js-cross-icon {
        border: none;
        background-color: #f6f6f6;
    }
    .highlighted {
        background-color: #999;
    }

</style>
<script>
    $(document).ready(function () {
        $('.js_add-slab-link').click(function () {

            var data = $(this).attr('link-data');
            var count = parseInt(($('#outerDiv' + data + ' div.row:last-child').attr('row-num'))) + 1;
            $('#outerDiv' + data).append("<div class='row slab-row" + count + "' row-num='" + count + "'><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Min. Amount</label>" +
                    "<input type='text' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Max. Amount</label>" +
                    "<input type='text' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-3 col-md-3'>" +
                    "<label for='sbi_minamt'>Mode</label>" +
                    "<select class='form-control' name='data[mode]'><option>Fixed</option><option>Percentage</option></select>" +
                    "</div><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Commission Amount</label>" +
                    "<input type='text' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>GST</label>" +
                    "<select class='form-control' name='data[mode]'><option>Inclusive</option><option>Exclusive</option></select>" +
                    "</div><div class='col-sm-1 col-md-1'><label for='sbi_minamt'>&nbsp;</label>" +
                    "<a class='form-control js-cross-icon' link-data='" + data + "," + count + "'><i class='fa fa-close' style='font-size:24px;color:red;'></i></a>" +
                    "</div>");
            //$('.slab-row12').css('background-color', '#999').fadeOut(1000);
            /*$(".slab-row" + count).animate({
             "background-color": "#ddd"
             }, 1000)
             .delay(1000)
             .animate({
             "background-color": "#f6f6f6"
             }, 1000);*/

        });

        $('.js_default_add-slab-link').click(function () {

            var data = $(this).attr('link-data');
            var count = parseInt(($('#outerDiv' + data + ' div.row:last-child').attr('row-num'))) + 1;
            $('#outerDiv' + data).append("<div class='row slab-row" + count + "' row-num='" + count + "'><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Min. Amount</label>" +
                    "<input type='text' id='default_minamt' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Max. Amount</label>" +
                    "<input type='text' id='default_maxamt' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-3 col-md-3'>" +
                    "<label for='sbi_minamt'>Mode</label>" +
                    "<select class='form-control' id='default_comm_mode' name='data[mode]'><option>Fixed</option><option>Percentage</option></select>" +
                    "</div><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Commission Amount</label>" +
                    "<input type='text' id='default_comm_amount' name='data[minamt]' class='form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>GST</label>" +
                    "<select class='form-control' id='default_gst_tax' name='data[mode]'><option>Inclusive</option><option>Exclusive</option></select>" +
                    "</div><div class='col-sm-1 col-md-1'><label for='sbi_minamt'>&nbsp;</label>" +
                    "<a class='form-control js-cross-icon' link-data='" + data + "," + count + "'><i class='fa fa-close' style='font-size:24px;color:red;'></i></a>" +
                    "</div>");
            //$('.slab-row12').css('background-color', '#999').fadeOut(1000);
            /*$(".slab-row" + count).animate({
             "background-color": "#ddd"
             }, 1000)
             .delay(1000)
             .animate({
             "background-color": "#f6f6f6"
             }, 1000);*/

        });

        $(document).on('click', '.js-cross-icon', function () {

            var data = $(this).attr('link-data');
            var ids = data.split(","); // first array is bank_id and second array is slab id
            $("#outerDiv" + ids[0] + " .slab-row" + ids[1]).remove();

        });

        $(document).on('blur', '.js-highlight-chng-val', function () {

            var data = $(this).attr('data-value');
            var curr_val = $(this).val();
            if (data != curr_val) {
                if (curr_val == '') {
                    $(this).parent().animate({'background-color': 'red'}, 1000);
                } else {
                    $(this).parent().animate({'background-color': '#efad8f'}, 1000);
                }
            } else {
                $(this).parent().animate({'background-color': '#f6f6f6'}, 1000);
            }

        });

        $('.payment_mode').change(function () {
            var mode;
            var option;
            var val = $(this).val();
            if (val != '') {
                var splitval = val.split(",");
                mode = splitval[2].split("##");
                $("#ratelistform_" + splitval[1] + " #provider").html("<option value=''>Select Provider</option><option value='all_providers'>All</option>");
                if (splitval[1] == 'REQUEST') {
                    if (splitval[0] == 1) {// 1 -> cashinoffice
                        $("#ratelistform_" + splitval[1] + " #provider").append("<option value='1'>" + mode[0] + "</option>");
                    } else {
                        $("#ratelistform_" + splitval[1] + " #provider").append("<option value='2'>" + mode[1] + "</option>");
                    }
                } else if (splitval[1] == 'PAYMENT' || splitval[1] == 'COLLECT') {

                    for (var i = 0; i < mode.length; i++) {
                        option = "<option value='" + mode[i] + "'>" + mode[i] + "</option>";
                        $("#ratelistform_" + splitval[1] + " #provider").append(option);
                    }
                }
            } else {
                $(".provider").html("<option value=''>Select Provider</option>");
            }

        });
        $("[id^=applicable_date_]").datepicker({dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, minDate: 1});

        $('.js-submit-btn').click(function () {
            var data_value = $(this).attr('data-value');
            var mode = $("#ratelistform_" + data_value + " #payment_mode").val();
            var provider = $("#ratelistform_" + data_value + " #provider").val();

            if (mode == '') {
                return ErrorMsgFun("#ratelistform_" + data_value + " #payment_mode", 'Please select <b>Payment Mode</b>.');
            }
            if (provider == '') {
                return ErrorMsgFun("#ratelistform_" + data_value + " #provider", 'Please select <b>Provider</b>.');
            }
            $('#ratelistform_' + data_value).submit();


        });

        $('.js-saveRate').click(function () {

            var type = '';
            var selectedmode = $('#payment_mode').val();
            var splitinfo = selectedmode.split(",");
            if (splitinfo.length != '3') {
                return ErrorMsgFun("", 'Something went wrong. Please try again later.');
            } else {
                type = splitinfo[1];
            }
            var selectedprovider = $('#provider').val();

            var selecteddate = $('#applicable_date_' + type).val();
            $('#selected_mode').val(splitinfo[0]);
            $('#selected_provider').val(selectedprovider);
            $('#selected_applicable_date').val(selecteddate);
            $('#rateDataFlag').val('saveRateData');
            $('#ratedataform').submit();

        });

        $('.menurights-js').click(function () {

            var dataValue = $(this).attr('data-value');
            if ($(this).is(":checked")) {
                var conf = confirm("Sure, you want to insert Default values in all Banks?");
                if (conf) {

                    var count = parseInt($('.default_fieldset .row').length);

                    addRowsinAll(count);
                    for (var i = 1; i <= count; i++) {

                        var minamt = $('.default_fieldset .slab-row' + i + ' #default_minamt').val();
                        var maxamt = $('.default_fieldset .slab-row' + i + ' .js_empty_max_amt').val();
                        var mode = $('.default_fieldset .slab-row' + i + ' .js_empty_comm_mode').val();
                        var comm_amt = $('.default_fieldset .slab-row' + i + ' .js_empty_comm_amt').val();
                        var gst = $('.default_fieldset .slab-row' + i + ' .js_empty_gst').val();
                        alert(minamt);
                        if (dataValue == 'new') {
                            $('.other_banks_div .slab-row1 .js_empty_min_amt').val(minamt);
                            $('.other_banks_div .slab-row' + i + ' .js_empty_max_amt').val(maxamt);
                            $('.other_banks_div .slab-row' + i + ' .js_empty_comm_mode').val(mode);
                            $('.other_banks_div .slab-row' + i + ' .js_empty_comm_amt').val(comm_amt);
                            $('.other_banks_div .slab-row' + i + ' .js_empty_gst').val(gst);

                        }
                    }


                    //return false;

                    $("#loaderDiv").show();
                    var minamt = $('#default_minamt').val();
                    var maxamt = $('#default_maxamt').val();
                    var mode = $('#default_comm_mode').val();
                    var comm_amt = $('#default_comm_amount').val();
                    var gst = $('#default_gst_tax').val();

                    if (dataValue == 'new') {
                        $('.js_empty_min_amt').val(minamt);
                        $('.js_empty_max_amt').val(maxamt);
                        $('.js_empty_comm_mode').val(mode);
                        $('.js_empty_comm_amt').val(comm_amt);
                        $('.js_empty_gst').val(gst);

                        //$('.js_empty_min_amt').parent().animate({'background-color': '#efad8f'}, 1000);
                    }
                    $("#loaderDiv").hide();
                } else {
                    return false;
                }

            } else {
                var conf = confirm("Sure, you want to empty all the filled values?");
                if (conf) {
                    $("#loaderDiv").show();
                    if (dataValue == 'new') {
                        $('.js_empty_min_amt').val('');
                        $('.js_empty_max_amt').val('');
                        $('.js_empty_comm_mode').val('');
                        $('.js_empty_comm_amt').val('');
                        $('.js_empty_gst').val('');

                        //$('.js_empty_min_amt').parent().animate({'background-color': '#efad8f'}, 1000);
                    }
                    $("#loaderDiv").hide();
                } else {
                    return false;
                }
            }


        });
    });

    function addRowsinAll(count) {

        for (var j = 2; j <= count; j++) {
            $('.other_banks_div').append("<div class='row slab-row" + j + "' row-num='" + j + "'><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Min. Amount</label>" +
                    "<input type='text' name='data[minamt]' class='js_empty_min_amt form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Max. Amount</label>" +
                    "<input type='text' name='data[minamt]' class=' js_empty_max_amt form-control' /></div>" +
                    "<div class='col-sm-3 col-md-3'>" +
                    "<label for='sbi_minamt'>Mode</label>" +
                    "<select class='js_empty_comm_mode form-control' name='data[mode]'><option>Fixed</option><option>Percentage</option></select>" +
                    "</div><div class='col-sm-2 col-md-2'><label for='sbi_minamt'>Commission Amount</label>" +
                    "<input type='text' name='data[minamt]' class='js_empty_comm_amt form-control' /></div>" +
                    "<div class='col-sm-2 col-md-2'><label for='sbi_minamt'>GST</label>" +
                    "<select class='js_empty_gst form-control' name='data[mode]'><option>Inclusive</option><option>Exclusive</option></select>" +
                    "</div><div class='col-sm-1 col-md-1'><label for='sbi_minamt'>&nbsp;</label>" +
                    "<a class='form-control js-cross-icon' link-data='" + +"," + j + "'><i class='fa fa-close' style='font-size:24px;color:red;'></i></a>" +
                    "</div>");
        }
    }
</script>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var providerStr = '<?= json_encode($providers) ?>';
    var providerList = JSON.parse(providerStr);
    var branchStr = '<?= json_encode($branchList) ?>';
    var branchList = '';
    var baseurl = "<?= $baseurl ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    var branchMapped = '';
    var pmttype = 'REQUEST';
    var modetype = '';
    var modeid = '';
    var provider_id = '';
    var provider_count = '<?= json_encode($provider_count) ?>';
    var branchList_count = '<?= json_encode($branchList_count) ?>';
    var paymentModeListcount = '<?= json_encode($paymentModeListcount) ?>';
    var paymentModeListStr = '<?= json_encode($paymentModeList) ?>';
    var paymentModeList = JSON.parse(paymentModeListStr);
    var ratelistrStr = '<?= json_encode($ratelist) ?>';
    var ratelist = JSON.parse(ratelistrStr);
    var button_flag = '';
    var banksListStr = '<?= json_encode($BankList) ?>';

    var BankListNameStr = '<?= json_encode($BankListName) ?>';
    var banksListName = JSON.parse(BankListNameStr);
    var providerStrType = '<?= json_encode($providersModeType) ?>';
    var providerListType = JSON.parse(providerStrType);

    var BankAccountlist = '<?= json_encode($BankAccountlist) ?>';
    var BankAccountlistStr = JSON.parse(BankAccountlist);

    var pro_id = '';
    var ser_pro = '';
    var curdate = "<?= $crdate ?>";
    $('#document').ready(function () {
        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
        $("#ratedate").datepicker({dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, minDate: 1});
        $(".serviceprovider,#service_Provider,.ratedate,.bankname,#Reqbankname,.accountno,.tax,.apptype,.amtfrom,.amtto,.amount,#ratemode,.nav-tabs-justified,.headtab").click(function () {
            clearMsg();
        });
        selectTypeFun(pmttype);
        $("#addRateListDiv").hide();
        $('.paymentdiv').on('click', 'tr:gt(0)', function () {
            var dataarr = $(this).prop('id').split("~!~");
            dateFirst = dataarr[1].split('-');
            dateSecond = curdate.split('-');
            var value = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
            var current = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);
            var timeDiff = (current.getTime() - value.getTime());
            var diffDays = timeDiff / (1000 * 3600 * 24);
            if (diffDays > 0) {
                return ErrorMsgFun('', 'You Can Not Update  Entry Whose Rate Date Is Less Than Or Equal To Current Date');
            } else {
                $("#loaderDiv").show();
                clearMsg();
                changeDiv('Update');
                $(".serviceprovider,#service_Provider,.ratedate,.bankname,#Reqbankname,.accountno,.tax,.apptype,.amtfrom,.amtto,.amount,#ratemode").val('');
                button_flag = "UPDATE";
                FillProviderBox();

                $('#serno').val(dataarr[0]);
                $('.ratedate').val(dataarr[1]);
                $('.serviceprovider').val(dataarr[5]);
                $("#service_Provider").val(dataarr[5]);
                if (modeid != '1') {
                    addBank(pro_id);
                }
                $('#bankname').val(dataarr[2]);
                $("#Reqbankname").val(dataarr[2]);
                if (pmttype == 'REQUEST' && modeid != '1') {
                    addAccount();
                }
                if (dataarr[3] == 'Amount') {
                    $("#amountlabel").text("Commission Amount*");
                } else if (dataarr[3] == 'Percentage') {
                    $("#amountlabel").text("Commission Percentage*");
                }
                $('.ratemode').val(dataarr[3]);
                $('.accountno').val(dataarr[4]);
                $(".amtfrom").val(dataarr[6]);
                $(".amtto").val(dataarr[7]);
                $(".tax").val(dataarr[8]);
                $(".amount").val(dataarr[10]);
                $(".apptype").val(dataarr[9]);
                $("#loaderDiv").hide();
            }
        });
        $("#service_Provider").change(function () {
            if (pmttype != 'REQUEST') {
                addBank(pro_id);
            }
        });
        $("#Reqbankname").change(function () {
            addAccount();
        });
        $("#ratemode").change(function () {
            if ($("#ratemode").val() == 'Amount') {
                $("#amountlabel").text("Commission Amount*");
            } else if ($("#ratemode").val() == 'Percentage') {
                $("#amountlabel").text("Commission Percentage*");
            } else {
                alert("Please Select Rate Mode.");
            }
        });
    });
    function addRateFun(option) {
        //$(".bankname").html("<option value=''>Select Bank</option>");
        changeDiv('add');
        //FillProviderBox();
    }
    function RateSubmit(option) {
        $("#subflag").val(option);
        $('#rate_date').val($('#ratedate').val());
        if (pmttype == 'REQUEST') {
            $('#bank_name').val($('#Reqbankname').val());
        } else {
            $('#bank_name').val($('#bankname').val());
        }
        $('#rate_mode').val($('#ratemode').val());
        $('#acnt_no').val($('#accountno').val());
        $('#provider_id').val($('#service_Provider').val());
        $('#amt_frm').val($("#amtfrom").val());
        $('#amt_to').val($("#amtto").val());
        $('#gst_type').val($("#tax").val());
        $('#amt_val').val($("#amount").val());
        $('#app_type_id').val($("#apptype").val());
        $('#payment_type').val(pmttype);
        $('#mode_id').val(modeid);

        if ($('#provider_id').val() == '') {
//            alert('sdfsdf');
            return ErrorMsgFun('service_Provider', 'Please Select Provider.');
        }
        if (modeid != 1) {
            if ($('#bank_name').val() == '') {
                return ErrorMsgFun('bankname', 'Please Select Bank');
            }
            if (pmttype == 'REQUEST') {
                if ($('#acnt_no').val() == '') {
                    return ErrorMsgFun('accountno', 'Account Number Field Is Empty');
                }
            }
        }
        if ($('#rate_date').val() == '') {
            return ErrorMsgFun('ratedate', 'Please Select Rate date');
        }
//        else {
//            if ($('#rate_date').datepicker('getDate') < new Date) {
//                return ErrorMsgFun('ratedate', 'Rate Date Should Be Graeter Than Current Date');
//            }
//        }
        if ($('#gst_type').val() == '') {
            return ErrorMsgFun('tax', 'Please Select GST ');
        }
        if ($('#amt_frm').val() == '') {
            return ErrorMsgFun('amtfrm', 'Minimum Amount Field Is Empty.');
        }
        if ($('#amt_to').val() == '') {
            return ErrorMsgFun('amtto', 'Maximum Amount Field Is Empty.');
        }
        if ($('#rate_mode').val() == '') {
            return ErrorMsgFun('ratemode', 'Please Select Rate Mode ');
        }
        if ($('#amt_val').val() == '') {
            return ErrorMsgFun('amount', 'Commission Amount Field Is Empty.');
        }
        if ($('#app_type_id').val() == '') {
            return ErrorMsgFun('apptype', 'Please Select App Type.');
        }
        $("#ratelistform").submit();
    }
    function changeDiv(viewDiv) {

        if (viewDiv == 'Update') {
            $("#viewRateListDiv" + pmttype).hide();
            $("#addRateListDiv").show();
            $('#headingLine' + pmttype).text(" Update Rate  For " + modetype);
            // mm $("#addicon,#saveicon").hide();
            // mm $("#updateicon").show();
        } else if (viewDiv == 'view') {
            $("#addicon").show();
            // mm $("#saveicon,#updateicon").hide();
            $('#headingLine' + pmttype).text("Rate List For " + modetype);
            $("#viewRateListDiv" + pmttype).show();
            $("#addRateListDiv").hide();
        } else if (viewDiv == 'add') {
            //$("#viewRateListDiv" + pmttype).hide();
            //$("#addRateListDiv").show();
            //$('#headingLine' + pmttype).text(" Add Rate  For " + modetype);
            // mm $("#addicon,#updateicon").hide();
            // mm $("#saveicon").show();
        }
    }
    function selectTypeFun(id) {
//        clearMsg();
        pmttype = id;
        $('#headingLine' + pmttype).text(" Select Payment Mode ");
        //        backFunc(pmttype);
        $.each(paymentModeList, function (key, val) {
            if (key == pmttype) {
                $.each(val, function (key1, key1val) {
                    modetype = key1;
                    modeid = key1val['mode_id'];
                    $('.listmode').removeClass('active').addClass('inactive');
                    $('#' + pmttype + key1).removeClass('inactive').addClass('active');
                    return false;
                });
            }
        });
        $('#headingLine' + pmttype).text("Rate List For " + modetype);
        showRateListFun(pmttype);
        ratelistEntry();
    }
    function selectModeFunc(id, type, name) {
//        clearMsg();
        pmttype = type;
        modetype = name;
        modeid = id;
        showRateListFun(type);
        $('#headingLine' + pmttype).text("Rate List For " + name);
        ratelistEntry();
    }
    function showRateListFun(id) {
        $("#viewRateListDiv" + id).show();
        //        $(".left").height(380);
        $("#addRateListDiv").hide();
        // mm $("#saveicon").hide();
        $("#addicon").show();
    }
    function backForm() {
        $("#formback").submit();
    }
    function ratelistEntry() {
        if (pmttype != 'REQUEST') {
            $("#requestDiv").hide();
            $("#PayCollDiv").show();
        } else {
            $("#requestDiv").show();
            $("#PayCollDiv").hide();
        }
        if (modeid == '1') {
            $("#bankacntdiv").hide();
        } else {
            $("#bankacntdiv").show();
        }
        $(".serviceprovider,#service_Provider,.ratedate,.bankname,#Reqbankname,.accountno,.tax,.apptype,.amtfrom,.amtto,.amount").val('');
        changeDiv('view');
        $("#paymentdiv" + pmttype).html('');
        var sno = 1;
        var divdata = '';
        $.each(ratelist, function (key, val) {
            if (modeid == key) {
                divdata = "<table id=tablereport align=center width =98% class='table table-bordered abc' ><thead class=header><tr><th> S.No.</th><th>Rate Date</th><th>Service Provider</th><th>Rate Mode</th><th>Min Amt</th><th>Max Amt</th><th> GST</th><th>Amount</th><th>App Type</th>";
                if (modeid != 1) {
                    divdata += "<th>Bank Name</th>";
                    if (pmttype == 'REQUEST') {
                        divdata += "<th>Account No.</th>";
                    }
                }
                divdata += "</thead><tbody class='bodyclass'>";
                $.each(val, function (key1, val1) {
                    var rowdata = val1;
                    var tdate = rowdata['ratedate'].split("-");
                    var rowid = rowdata['serno'] + "~!~" + tdate[2] + '-' + tdate[1] + '-' + tdate[0] + "~!~" + rowdata['bank_id'] + "~!~" + rowdata['ratemode'] + "~!~" + $.trim(rowdata['account_no']) + "~!~" + rowdata['provider_id'] + "~!~" + rowdata['minslabamt'] + "~!~" + rowdata['maxslabamt'] + "~!~" + rowdata['gst'] + "~!~" + rowdata['app_type'] + "~!~" + rowdata['amount'];
                    divdata += "<tr class='tabcol' id='" + rowid + "'><td>" + sno + "</td><td>" + rowdata['ratedate'] + "</td><td>" + providerList[rowdata['provider_id']] + "</td><td>" + rowdata['ratemode'] + "</td><td>" + rowdata['minslabamt'] + "</td><td>" + rowdata['maxslabamt'] + "</td><td>" + rowdata['gst'] + "</td><td>" + rowdata['amount'] + "</td><td>" + rowdata['app_type'] + "</td>";
                    if (modeid != 1) {
                        divdata += "<td>" + banksListName[rowdata['bank_id']] + "</td>";
                        if (pmttype == 'REQUEST') {
                            divdata += "<td>" + rowdata['account_no'] + "</td>";
                        }
                    }
                    divdata += "</tr>";
                    sno = sno + 1;
                });
            }
        });
        if (divdata != '')
            $("#paymentdiv" + pmttype).append(divdata + "</tbody></table>");
        else
            $("#paymentdiv" + pmttype).append("<center><h4>No Rate List Found.</h4></center>");
    }
    function addBank(proid) {
        $(".bankname").html("<option value=''>Select Bank</option>");
        if (proid == '') {
            ser_pro = $("#service_Provider").val();
        } else {
            ser_pro = proid;
        }
        if (modeid != '1') {
            if (ser_pro != "") {
                var banksList = JSON.parse(banksListStr);
                if (banksList[ser_pro] != 'undefined') {
                    var BanksL = banksList[ser_pro].split(',');
                    var len = BanksL.length;
                    if (len > 1) {
                        $(".bankname").append("<option value='*'> All </option>");
                    }
                    for (var i = 0; i < len; i++) {
                        $(".bankname").append("<option value='" + BanksL[i] + "'>" + banksListName[BanksL[i]] + "</option>");
                    }
                } else {
                    alert('No bank List Available For This Service');
                    return false;
                }
            }
        }
    }

    function addAccount() {
        $("#accountno").html("<option value=''>Select Account</option>");
        var bank_Id = $("#Reqbankname").val();
        if (bank_Id != "") {
            if (bank_Id != '*') {
                var AccountL = BankAccountlistStr[bank_Id].split(',');
                var Alen = AccountL.length;
                if (Alen == 0) {
                    $("#accountno").html("<option value=''>Accounts Not Available.</option>");
                } else {
                    if (Alen > 1) {
                        $("#accountno").append("<option value='*'> All Accounts</option>");
                    }
                    for (var i = 0; i < Alen; i++) {
                        $("#accountno").append("<option value='" + AccountL[i] + "'>" + AccountL[i] + "</option>");
                    }
                }
            } else {
                $("#accountno").html("<option value='*'>All Accounts</option>");
            }
        }
    }
    function FillProviderBox() {
        if (pmttype == 'REQUEST') {
            $.each(providerListType[pmttype], function (providerkey, providerdata) {
                if (modeid == '1') {
                    if (providerdata['provider_id'] == '1') {
                        $("#providerVal").text(providerkey);
                        $("#service_Provider").val(providerdata['provider_id']);
                        pro_id = '1';
                    }
                } else {
                    if (providerdata['provider_id'] == '2') {
                        $("#providerVal").text(providerkey);
                        $("#service_Provider").val(providerdata['provider_id']);
                        pro_id = '2';
                        addBank(pro_id);
                    }
                }
                $("#service_Provider").append("<option value='" + providerdata['provider_id'] + "'>" + providerkey + "</option>");
                $("#service_Provider").val(pro_id);
            });
        } else {
            pro_id = '';
            $("#service_Provider").html("<option value=''>Select Provider</option>");
            $.each(providerListType[pmttype], function (providerkey, providerdata) {
                $("#service_Provider").append("<option value='" + providerdata['provider_id'] + "'>" + providerkey + "</option>");
            });
        }
    }
    function numericWithDotconly(evt, id) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode === 46 && $("#" + id).val().split('.').length === 2) {
            return false;
        }
        if ((charCode > 47 && charCode < 58) || charCode === 8 || charCode === 46 || charCode === 9 || charCode === 13)
            return true;
        return false;
    }
</script>