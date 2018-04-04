<?php
$SuccessMessage = isset($response["successmsg"]) ? $response["successmsg"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$bankoptions = isset($response['banklist']) ? $response['banklist'] : array();
$bankaccountno = array('' => 'Select Account Number');
$banksAccounts = isset($response['bankaccountlist']) ? $response['bankaccountlist'] : array();
$banksAccountsStr = "";
foreach ($banksAccounts AS $val => $name)
    $banksAccountsStr .= "$$$" . $val;
//echo $this->Html->css('clockpicker.css');
echo $this->Html->script(array('jsvalidation', 'treeStructure', 'security.min'));
$ajaxbase = $this->Form->url(array('controller' => 'GetJson'));
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-credit-card font-green-sharp"></i>';
echo $this->Html->tag('span', 'Upload Bank Statement', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body-js portlet-body'); //main portlet-body
echo $this->Form->create('uploadBankStatement', array("id" => "form-uploadbankstatement", "target" => "_self", "autocomplete" => "off", "type" => "file"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
//echo $this->Html->div('portlet-body'); //
echo $this->Html->div('row'); //
echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Statement Date', array('for' => 'statementdate'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-calendar"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('statementdate', array('id' => 'statementdate', 'label' => false, 'div' => FALSE, 'class' => 'form-control', 'placeholder' => 'Select Statement Date'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Bank Name', array('for' => 'bank'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-university"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('bank', array('id' => 'bank', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankoptions, "empty" => "Select Bank"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group col-md-6');
echo $this->Html->tag('label', 'Bank Account No', array('for' => 'bankaccountno'));
echo $this->Html->div('input-group');
echo $this->Html->tag('span', '<i class="fa fa-navicon"></i>', array('class' => 'input-group-addon'));
echo $this->Form->input('bankaccountno', array('id' => 'bankaccountno', 'label' => false, 'div' => FALSE, 'class' => 'form-control', "type" => "select", 'options' => $bankaccountno));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('form-group  col-md-2');
echo $this->Html->tag('label', 'Upload File', array('for' => 'uploadfile'));
echo $this->Html->div('input-group');
echo $this->Html->tag('div class=" fileUpload btn btn-primary btn-block glyphicon glyphicon-open"') . "<span id=btnid><font face=verdana >" . " Choose a file</font>" . $this->Form->input('statementfile', array('id' => "statementfile", 'type' => "file", 'class' => "upload", 'label' => FALSE, 'div' => FALSE)) . "</span>";

echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('form-group col-md-4', NULL, array('id' => 'selectedfileDiv'));
echo $this->Html->tag('label', '&nbsp', array('for' => 'selectedfile'));
echo $this->Html->div('input-group');
echo $this->Html->tag('label', 'No File Selected', array('for' => 'selectedfile', 'id' => 'filename'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');




//echo $this->Html->div('form-group col-md-6', $this->Form->input('statementfile', array('id' => 'statementfile', 'label' => 'File', 'div' => FALSE, 'class' => 'form-control', "type" => "file")));
//echo $this->Html->useTag('tagend', 'div'); // login details end
echo $this->Html->useTag('tagend', 'div'); // row end
echo "<hr>";

echo $this->Html->div('form-actions'); //
echo $this->Form->button('Upload', array('id' => 'btnUploadBankStatement', 'type' => 'button', 'class' => 'btn green', 'onclick' => 'return saveUpdatedMenu();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div'); // main portlet-body end
$result = isset($response['resultdata']) ? $response['resultdata'] : '';
if (!empty($result)) {
    //$this->Js->buffer('$(".portlet-body-js").hide()');
    $this->Js->buffer('var y = $(window).scrollTop(); $(window).scrollTop(y+360);');
    echo $this->Form->create("successbankstatement", array("id" => "form-successbankstatement", "target" => "_self", "autocomplete" => "off", "type" => "file"));
    echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
    $this->Form->unlockField("AuthVar");
    echo $this->Form->input("datastr", array("label" => false, 'id' => 'datastr', "type" => "hidden", "value" => base64_encode(gzcompress(json_encode($result), 9))));
    $this->Form->unlockField("datastr");
    echo $this->Form->input("upload_flag", array("label" => false, "type" => "hidden", 'id' => 'upload_flag', "value" => ""));
    $this->Form->unlockField("upload_flag");
    echo "<div id='tableDiv'>";
    echo $this->Html->para("font-green-sharp bold", "Uploaded File Records", array("style" => "text-align:center;"));
    $Header = array_keys($result[0]);
    $i = 1;
    echo $this->Html->div('table-responsive');
    echo"<table id='tablereport' class='table table - striped'><thead class='header'><tr><th>S no.</th>";
    foreach ($Header as $key) {
        echo "<th>" . ucwords(str_replace("_", " ", $key)) . "</th>";
    }
    echo "</tr></thead>";
    foreach ($result as $resultData) {
        echo "<tr class='tabcol'><td>" . $i . "</td>";
        foreach ($Header as $key) {
            echo "<td>" . (isset($resultData[$key]) ? $resultData[$key] : "") . "</td>";
        }
        echo "</tr>";
        $i++;
    }
    echo "</table></div>";
    echo $this->Html->div('table-responsive');
    echo $this->Form->button("Cancel", array("class" => "button-js btn btn-danger", "button-type" => 'cancel', "type" => "button", "id" => "cancel", "style" => array('margin-left:42%')));
    echo $this->Form->button("Submit", array("class" => "button-js btn green", "button-type" => 'upload', "type" => "button", "id" => "submitButton", "style" => array('margin-left:3%;')));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
}
echo $this->Js->writeBuffer();
?>

<style>
    .fileUpload {
        position: relative;overflow: hidden;
        /*margin-top: 30px;*/
    }
    .fileUpload input.upload {
        position: absolute;top: 0;right: 0;margin: 0;padding: 0;
        font-size: 20px;cursor: pointer;opacity: 0;}

    .hidealert {
        display: none;
    }
    #filename{
        /*background-color: #3c8dbc;*/
        /*                    display: inline;
                            padding: .2em .6em .3em;
                            font-size: 100%;
                            font-weight: 700;*/
        line-height: 3;
        /*            color: #fff;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    border-radius: .25em;*/

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
    .alert {line-height: 0px;margin-bottom: -10px; text-align: center;}
    .table th{background-color: #2AB4C0; border-bottom: 1px solid;color:#fff;}

</style>
<script>
    var banksAccountsStr = "<?= $banksAccountsStr ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    $('#document').ready(function () {
        $('#selectedfileDiv').hide();
        $('#statementdate').datepicker({
            maxDate: 0,
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
        var x = document.getElementById("statementfile");
        $("#statementfile").change(function () {
            $('#selectedfileDiv').hide();
            $("#filename").text('No File Selected.');
            var allowedExts = ["xlsx", "xls"];
            var temp = x.files[0].name.split(".");
            var ext = temp[temp.length - 1];
            if (jQuery.inArray(ext, allowedExts) == -1) {
                return ErrorMsgFun('uploadimage', 'Uploaded File Should Be Excel File.');
            }
            if (x.files[0].size > 2000000 || x.files[0].size <= 0) {
                $("#uploadimage").val('');
                return ErrorMsgFun('uploadimage', 'Maximum Allowed Size For Image 2 Mb.');
            }
            if (x.files[0].tmp_name == "") {
                $("#uploadimage").val('');
                return ErrorMsgFun('uploadimage', 'Invalid Image.');
            }

            var imagename = $("#statementfile").val();
//            var short = imagename.substring(0, imagename.indexOf('.'));
//            short = short.split(/\\|\//);
//            short = $(short).last()[0];
            $('#selectedfileDiv').show();
            $("#filename").text(imagename);
        });
        $("#btnUploadBankStatement").click(function () {

            if ($("#statementdate").val() == '') {
                return ErrorMsgFun('statementdate', 'Please enter <b>Statement Date</b>.');
            } else if ($("#bank").val() == '') {
                return ErrorMsgFun('bank', 'Please select <b>Bank Name</b>.');
            } else if ($("#bankaccountno").val() == '') {
                return ErrorMsgFun('bankaccountno', 'Please select <b>Bank Account Number</b>.');
            } else if ($("#statementfile").val() == '') {
                return ErrorMsgFun('statementfile', 'Please upload <b>Bank Statment file</b>.');
            } else {
                $('.alert-danger').hide();
                $('.alert-success').html('Please wait...');
                $('.alert-success').show();
                $('#btnUploadBankStatement').prop('disabled', true);
                $('#form-uploadbankstatement').submit();
            }
        });

        $('.button-js').click(function () {
            var clickedbuttontype = $(this).attr("button-type");
            if (clickedbuttontype == 'upload') {
                $('#upload_flag').val('submitdata');
            } else {
                $('#upload_flag').val('canceldata');
            }
            $('#form-successbankstatement').submit();
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
        $("#statementdate,#bank,#bankaccountno,#statementfile,#ui-datepicker-div").click(function () {
            $("#msgDiv").removeClass('alert alert-danger alert-autocloseable-danger,alert alert-success alert-autocloseable-success');
            $("#msgDiv").html("&nbsp");

        });
        if (sucmsg != '') {
            SuccMsgFun('msgDiv', sucmsg);
        }
        if (msg != '') {
            $("#bank").val('');
            ErrorMsgFun('msgDiv', msg);
        }
    });
</script>