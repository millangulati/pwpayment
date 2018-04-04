
<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$providerTypeList = isset($response["result"]) ? $response["result"]["paymentMode"] : array();
$bankListProvider = isset($response["result"]) ? $response["result"]["bankListProvider"] : array();
//pr($bankListProvider);
$bankName = isset($response["result"]) ? $response["result"]["bankName"] : array();
$responseData = isset($response["responseData"]) ? $response["responseData"] : array();
$providerList = isset($response["result"]) ? $response["result"]["providerList"] : array();
$rev_List = \array_flip($providerList);
$bankList = isset($response["result"]) ? $response["result"]["bankList"] : array();
//pr($bankName);
echo $this->Html->script('jquery.tablednd.min');
echo $this->Html->css('modemap');
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-bank font-green-sharp"></i>';
echo $this->Html->tag('span', ' Payment Bank', array('class' => 'caption-subject font-green-sharp bold uppercase', 'id' => 'mainheading'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Add Bank', array('id' => 'addbankbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return addBankFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Reorder', array('id' => 'reorderbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return reorderFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Change Status', array('id' => 'editbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return editFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
//echo $this->Html->div('col-sm-12');
//echo $this->Html->tag('H3', 'Payment Bank');
//echo $this->Html->para(isset($response["color"]) ? $response["color"] : "text-red", isset($response["msg"]) ? $response["msg"] : "&nbsp;", array('id' => 'msgDiv', "style" => "text-align:center"));

echo $this->Form->create('Bo', array("id" => "paymentbank", "target" => "_self", "autocomplete" => "off", "type" => "file"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));

echo $this->Form->hidden("orderString", array("id" => "orderString", 'value' => ''));
echo $this->Form->unlockField('orderString');
echo $this->Form->hidden("activeString", array("id" => "activeString", 'value' => ''));
echo $this->Form->unlockField('activeString');
echo $this->Form->hidden("orderProvider", array("id" => "orderProvider", 'value' => ''));
echo $this->Form->unlockField('orderProvider');
echo $this->Form->hidden("updateId", array("id" => "updateId", 'value' => ''));
echo $this->Form->unlockField('updateId');
echo $this->Form->hidden("flag", array("id" => "flag", 'value' => ''));
echo $this->Form->unlockField('flag');

//echo $this->Html->div(''); //row
echo $this->Html->div('', NULL, array('id' => 'orderDiv'));
echo $this->Html->div('col-sm-4 col-xs-12 col-md-2 left');
echo "<nav class=nav-sidebar>";
echo '<ul class="nav nav-tabs-justified">';
echo '<h4 style="color:#fff;"><center>Provider List</center></h4>';
$list = true;

foreach ($providerList as $key => $value) {
    echo '<li class = ' . ($list ? "active" : "") . '><a data-toggle="tab" href="#' . $value . '" id="content' . $value . '" onclick = "return selectModeFunc(\'' . $value . '\',\'' . $key . '\');">' . $value . '</a></li>';
    $list = false;
}
echo '</ul>';
echo "</nav>";
echo $this->Html->useTag('tagend', 'div'); //left end

echo $this->Html->div('', null, array('id' => 'rightcontentDiv', 'class' => 'tab-content')); //rightcontentdiv
echo '<center><h4 class=headrightDiv ></h4></center>';
$tab = true;

foreach ($providerList as $key => $value) {
    echo $this->Html->div('', null, array('id' => $value, 'class' => ($tab ? "tab-pane active" : "tab-pane")));
    if (isset($bankList[$key])) {
        echo "<div class=table-responsive>";
        echo "<table id='tablereport_$value' class='table table-bordered abc' ><thead class='header'><tr style = 'width : 98.5%'><th style = 'width :10%'> S.No</th><th style = 'width :5%'> Logo</th><th>Bank Code</th><th>Bank Name</th><th class='headorder hidden'> Order </th><th class='newheadorder hidden'>New Order </th><th>Status</th></tr></thead><tbody>";
        $sno = '1';
        foreach ($bankList[$key] as $key1 => $val) {
            $status = array('Y' => 'Active', 'N' => 'Inactive');
            $rowid = $key1;
            if ($val['logo'] == '') {
                $img = '';
            } else {
                $img = $this->Html->image($val['logo'], array('class' => '', 'width' => '60', 'height' => '30'));
            }
            echo "<tr id =$rowid>";
            echo $this->Html->tag('td', $this->Form->input("sno", array("label" => FALSE, 'id' => $key1 . '_sno_' . $key, 'value' => $sno, 'class' => 'new', 'readonly' => true, 'div' => FALSE)));
//            echo $this->Html->tag('td', $sno);
            echo $this->Html->tag('td', $img);
            echo $this->Html->tag('td', $val['bankcode'], array('id' => $key1 . '_bankcode_' . $key, 'value' => $val['bankcode']));
            echo $this->Html->tag('td', $val['bankname'], array('id' => $key1 . '_bankname_' . $key, 'value' => $val['bankname']));
            echo $this->Html->tag('td', $val['uiorder'], array('id' => $key1 . '_uiorder_' . $key, 'value' => $val['uiorder'], 'class' => 'hidden'));
            echo "<td class =new1row hidden>";
            echo $this->Form->input("uiorder", array("label" => FALSE, 'id' => $key1 . '_newuiorder_' . $key, 'value' => $val['uiorder'], 'class' => 'new1', 'readonly' => true, 'div' => FALSE));
            echo "</td>";
            echo $this->Html->tag('td', $status[$val['status']], array('id' => $key1 . '_status_' . $key, 'value' => $status[$val['status']]));
            $sno = $sno + 1;
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</div>";
//        echo '<center>' . $this->Html->div('col-sm-1 col-md-3 form-group', '', array('style' => 'margin-top:10px;')) . $addnew . '' . $reorder . '</center>';
    } else {
        echo '<h4><center>Record Not Found.</center></h4>';
//        echo '<center>' . $this->Html->div('col-sm-3 col-md-4 form-group', '', array('style' => 'margin-top:10px;')) . $addnew . '</center>';
    }
    $tab = false;
    echo $this->Html->useTag('tagend', 'div'); //tab pane end
}
echo $this->Html->useTag('tagend', 'div'); //rightcontentdiv
////add bankdiv
echo $this->Html->div('', null, array('id' => 'BankDiv', 'class' => 'tab-content main')); //leftcontd
//$back = $this->Html->div('col-sm-2 form-group', $this->Form->button('Back', array('id' => 'backBtn', 'type' => 'button', 'class' => 'btn btn-danger form-control', 'onclick' => 'return backFunc();')));
//$update = $this->Html->div('col-sm-2 form-group', $this->Form->button('Update', array('id' => 'reorderbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return updateFunc(();')));
echo '<center><h4 class=headDiv >Add New Bank</h4></center>';
echo $this->Html->div('', NULL, array('id' => 'banknameDiv'));
echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('bankname', 'Bank Name*'));
echo $this->Form->input("bankname", array("id" => "bankname", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'value' => '', "class" => "form-control"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', NULL, array('id' => 'bankcodeDiv'));
echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('bankcode', 'Bank Code*'));
echo $this->Form->input("bankcode", array("id" => "bankcode", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'maxlength' => '12', 'value' => '', "class" => "form-control"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', NULL, array('id' => 'uniqueBankName'));
echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('cmnBankName', 'Common Bank Name*'));
echo $this->Form->input("cmnBankName", array("id" => "cmnBankName", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'value' => '', "class" => "form-control"));
echo $this->Html->useTag('tagend', 'div');

//echo $this->Html->div('', NULL, array('id' => 'statusDiv'));
//echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('order', 'Order*'));
//echo $this->Form->input("order", array("id" => "order", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'value' => '', "class" => "form-control" ));
//echo $this->Html->useTag('tagend', 'div');
//
//echo $this->Html->div('', NULL, array('id' => 'orderDiv'));
//echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('status', 'Status*'));
//echo $this->Form->input("status", array("id" => "status", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'options' => $status, 'empty' => 'Select Status', 'value' => '', "class" => "form-control" ));
//echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('', NULL, array('id' => 'logoDiv'));
echo $this->Html->div('col-sm-2 col-md-2 form-group', $this->Form->label('select', 'Select Logo'));

echo $this->Html->div('form-group  col-md-2');
//echo $this->Html->tag('label', 'Upload File', array('for' => 'uploadfile'));
echo $this->Html->div('input-group');
echo $this->Html->tag('div class=" fileUpload btn btn-primary btn-block glyphicon glyphicon-open"') . "<span id=btnid><font face=verdana >" . " Choose a file</font>" . $this->Form->input('uploadimage', array('id' => "uploadimage", 'type' => "file", 'class' => "upload", 'label' => FALSE, 'div' => FALSE)) . "</span>";

echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

//echo $this->Form->input("uploadimage", array("id" => "uploadimage", "label" => FALSE, 'div' => array('class' => 'col-sm-2 col-md-3 form-group'), 'type' => "file", "class" => "upload"));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('', NULL, array('id' => 'blankDiv'));
echo $this->Html->div('col-sm-2 col-md-5 form-group', $this->Form->label('blank', '&nbsp'));
echo $this->Html->useTag('tagend', 'div');

//echo $this->Html->div('col-sm-3 form-group', '') . $back . $update;
echo $this->Html->useTag('tagend', 'div'); //left content-end
////end add bankdiv div

echo $this->Html->useTag('tagend', 'div'); //row

echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('', NULL, array('id' => 'editDiv')); //edit div
$mainTab = 1; //
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <text class="navbar-brand" style='color: white'>Payment Type </text>
        </div>
        <ul class="nav navbar-nav">
            <?php
            foreach ($providerTypeList as $type => $pro) {
                echo '<li class= ' . ($mainTab > 0 ? "active" : "") . '><a data-toggle="tab" href="#' . $type . '"   onclick = "return selectTypeFun(\'' . $type . '\');">' . $type . '</a></li>';
                $mainTab = 0;
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right nav1">
            <li>
                <div class = "input-group input-group topmargin">
<!--                    <span class = "input-group-btn">
                        <button type = "button" class = "btn btn-info dropdown-toggle" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false" id = "adv-search-drop">
                            <i class = "fa fa-caret-down"></i>
                        </button>
                        <ul class = "dropdown-menu">
                    <?php
//                    foreach ($bankName as $key => $listData) {
//                        echo "<li><a class = 'searchList'  data-value =  '" . $key . "'> " . $listData . "</a></li>";
//                    }
                    ?>
                        </ul>
                    </span>-->
                    <input id = "searchId" class = "form-control" placeholder = "Search Bank"  type = "text" value="">
                    <span class = "input-group-btn">
                        <button class = "btn btn-primary" type = "button" id = "searchSubmit">
                            <i class = "glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </li>

        </ul>
    </div>
</nav>
<?php
echo "<div class='box box-success'>";
echo "<div class='box-header with-border'>";
echo $this->Html->div('row');
echo $this->Html->div('col-sm-3 col-md-3 col-xs-3 form-group', $this->Form->label('Bank Name', 'Bank Name'));
//echo $this->Html->div('col-xs-2 col-sm-0 col-md-0 ');
//echo"</div>";
echo $this->Html->div('col-sm-3 col-md-3 col-xs-3 form-group', $this->Form->label('Provider List', 'Provider List'));
echo $this->Html->useTag('tagend', 'div');
echo "</div>";
//echo "<hr>";
echo "<div class='box-body'>"; //box body

$first = 1;
echo $this->Html->div('', null, array('id' => 'contentDiv', 'class' => 'tab-content')); // 5
foreach ($providerTypeList as $type => $pro) {

    echo $this->Html->div('', null, array('id' => $type, 'class' => ($first > 0 ? "nav tab-pane active" : "nav tab-pane"))); // 6
    $first = 0;

    echo "<div class='' id='forsearch'>"; // foreach
    foreach ($bankListProvider as $key => $listData) {
        echo $this->Html->div('', null, array('serach_tag' => $bankName[$key]));
        $displaydata = '';
        $flag = 'false';
        $displaydata.= $this->Html->div('row');
        $displaydata.= $this->Html->div('col-sm-12 col-md-3', $this->Form->label($key, $bankName[$key]));
        $sno = 1;
        foreach ($listData as $listkey => $listvalue) {

            if (\in_array($listkey, array_keys($pro))) {
                $flag = 'true';
                $id = $type . "_" . $listvalue['provider_id'] . "_" . $listvalue['bankid'] . "_" . $listvalue['provider_bankcode'];
                $bankU = $listvalue['provider_bankcode'];
                $checked = ($listvalue['status'] == 'Y') ? 'checked' : '';
                $displaydata.= "<div class = 'col-md-3 col-sm-6 col-xs-12'><div class='form-group'><input name=$id id=$id autocomplete='off' type='checkbox' class='provider_$type $bankU hidden ' $checked  ><div class='btn-group'><label for=$id class='btn green  '><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for=$id class='btn btn-default active  ' style='width: 120px;'>$providerList[$listkey]</label></div></div></div>";

                if ($sno % 3 == 0) {
                    $displaydata.= $this->Html->div('col-md-3 col-sm-6 col-xs-12', '');
                }
                $sno++;
            }
        }
        $displaydata.= $this->Html->useTag('tagend', 'div');
        if ($flag == 'true') {
            echo $displaydata;
            echo "<hr>";
        }
        echo $this->Html->useTag('tagend', 'div');
    }
    echo "</div>"; // end foreach
    echo $this->Html->useTag('tagend', 'div');
}
echo $this->Html->useTag('tagend', 'div');

echo "</div>"; // end box body
echo $this->Html->useTag('tagend', 'div');

echo "</div>";
echo $this->Html->useTag('tagend', 'div'); ///edit div end
//echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Form->create('formback', array("name" => "formback", 'id' => 'formback', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->end();
?>

<style>
    .alert {line-height: 3px;margin-bottom: -15px;}
    .tools{margin-right: 10px;display: none;}
    a {color: white;}
    .table th{background-color: #2b3b55; border-bottom: 1px solid;color:#fff;}
    @media(max-width:766px){.left{height: auto;}}
    .abc tr:hover {background-color: #17c4bb; cursor: pointer; cursor: hand;}
    .headDiv,.headrightDiv { line-height: 40px;/*background-color: rgb(0, 173, 239);*/;font-weight: bold;color:#2b3b55;}
    .headDiv{margin-bottom: 40px;}
    .myDragClass {background-color: #17c4bb;font-size: 16pt;}
    .nav-tabs-justified > li > a {border-radius:0px;}
    .new,.new1 {background: none; border: none;width: 68px;text-align: center;}
    .table-responsive { height: 325px;overflow-y: auto;overflow-x: auto;}
    .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {border: 1px solid #c4d5d5;}
    .table th {background-color: #C0C0D3;border: 1px solid #f4f4f4;width: 82px;color: #515151;border-left: 1px solid;border-right: 1px solid; }
    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
        background-color: aliceblue;
        height: 48px;
    }
    .topmargin{
        margin-top: 9px;
        margin-right: 16px;
    }
    input[type="checkbox"] { display: none;}
    input[type="checkbox"] + .btn-group > label span {width: 20px; }
    input[type="checkbox"] + .btn-group > label span:first-child {display: none;}
    input[type="checkbox"] + .btn-group > label span:last-child {display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:first-child { display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:last-child {display: none;}
    /*    #searchId {
            min-width: 62px;
        }*/
    .hidden{display: none};
    .left{margin-bottom:10px;}
    .fileUpload {
        position: relative;overflow: hidden;
        /*margin-top: 30px;*/
    }
    .fileUpload input.upload {
        position: absolute;top: 0;right: 0;margin: 0;padding: 0;
        font-size: 20px;cursor: pointer;opacity: 0;}

</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var providerList = '<?= json_encode($rev_List) ?>';
    var providerList1 = JSON.parse(providerList);
    var requestType = $('.nav.tab-pane.active').prop('id');
    var mode = $('.tab-pane.active').prop('id');
    var orderStr = '';
    var modekey = providerList1[mode];
    $('#document').ready(function () {
        $("#backbtn,#editDiv").hide();
        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
        $("#bankname,#bankcode,#order,#status,#uploadimage,#cmnBankName").click(function () {
            clearMsg();
        });
//
        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        $('.headrightDiv').text(mode + ' Providers Bank List');
        $("#BankDiv").hide();
        $(".new1row1,.newheadorder1").hide();
        $('.table-responsive').on('click', 'tr:gt(0)', function () {
            clearMsg();
            if ($("#reorderbtn").text() == 'Reorder') {
                $("#mainheading").text('Update Payment Bank');
                $("#" + mode).hide();
                $("#addbankbtn").text('Update')
                $("#rightcontentDiv,#editbtn,#reorderbtn,#uniqueBankName").hide();
                $("#BankDiv").show();
                $('.headDiv').text('Update  Bank Details For ' + mode + ' Provider');
                $("#blankDiv,#logoDiv,#backbtn").show();
                var bank_id = $(this).prop('id');
                $("#updateId").val(bank_id);
                $("#bankname").val($('#' + bank_id + '_bankname_' + modekey).text());
                $("#bankcode").val($('#' + bank_id + '_bankcode_' + modekey).text());
            }
        });
        $('.provider_PAYMENT').click(function () {
            var checkBox = $(this).attr('id');
            var value = $("#" + checkBox).prop('checked');
            var rowId = checkBox.split("_");
            var reqType = rowId[0];
            var providerid = rowId[1];
            var bank_id = rowId[2];
            var bank_name = rowId[3];
//            alert(bank_name);
            if (value) {
                $('.provider_PAYMENT.' + bank_name).each(function () {
                    var checkBox1 = $(this).attr('id');
                    $("#" + checkBox1).prop('checked', false);
                });
                $("#" + checkBox).prop('checked', true);
            }
        });

        $('.table-responsive').on('click', function () {
            clearMsg();
        });
        $('#searchId').keyup(function (event) {
            if (event.which == 27 || event.which == 13) {
                return false;
            }
            else {
                searchFun();
            }
        });
        $('#searchSubmit').click(function () {
            if ($("#searchId").val() == '') {
                alert("Please Enter Any Bank Name.");
                return false;
            }
            else {
                searchFun();
            }
        });
//        $("#searchId,.spinnerclass").keypress(function (e) {
//            if (e.which == 13)
//                return false;
//        });
        var x = document.getElementById("uploadimage");
        $("#uploadimage").change(function () {

            var allowedExts = ["jpg", "jpeg", "pjpeg", "png"];
//            alert(allowedExts);
            var temp = x.files[0].name.split(".");
            var ext = temp[temp.length - 1];
            if (jQuery.inArray(ext, allowedExts) == -1) {
                $("#uploadimage").val('');
                return ErrorMsgFun('uploadimage', 'Uploaded Logo Should be in JPEG/PJEPG/PNG Format.');
            }
            else if (x.files[0].size > 524288 || x.files[0].size <= 0) {
                $("#uploadimage").val('');
                return ErrorMsgFun('uploadimage', 'Maximum Allowed Size For Image 512 Kb.');
            }
            else if (x.files[0].tmp_name == "") {
                $("#uploadimage").val('');
                return ErrorMsgFun('uploadimage', 'Invalid Image.');
            }
            else {
                var filename = $("#uploadimage").val();
                SuccMsgFun('uploadimage', 'Image Selected (' + filename + ")");
            }
        });
    });
    function addBankFunc() {
        clearMsg();
        if ($("#addbankbtn").text() == 'Add Bank') {
            $("#mainheading").text('Add Payment Bank');
            $("#" + mode).hide();
            $("#addbankbtn").text('Submit')
            $("#rightcontentDiv,#editbtn,#reorderbtn").hide();
            $("#BankDiv").show();
            $('.headDiv').text('Add New Bank For ' + mode + ' Provider');
            $("#bankname,#bankcode,#order,#status").val('');
            $("#blankDiv,#logoDiv,#backbtn").show();
        } else {
            $("#orderProvider").val(modekey);
            if ($("#orderProvider").val() == '') {
                return ErrorMsgFun('provider', 'Please Select Provider.');
            }
            if ($("#bankname").val() == '') {
                return ErrorMsgFun('bankname', 'Please Enter Bank Name.');
            }
            if ($("#bankcode").val() == '') {
                return ErrorMsgFun('bankcode', 'Please Enter Bankcode.');
            }
            $("#flag").val('UPDATE');
            if ($("#addbankbtn").text() == 'Submit') {
                if ($("#cmnBankName").val() == '') {
                    return ErrorMsgFun('cmnBankName', 'Please Enter Common Bank Name.');
                }
                $("#flag").val('ADD');
            }
            $("#paymentbank").submit();

        }
    }
    function reorderFunc() {
        clearMsg();
        id = mode;
        if ($("#reorderbtn").text() == 'Reorder') {
            $("#mainheading").text('Change Order Of Bank');
            $("#backbtn").show();
            $("#editbtn,#addbankbtn").hide();
            $("#tablereport_" + id).removeClass('abc');
            $("#reorderbtn").text('Update Order');
            dragDropFunc(id);
            SuccMsgFun('', 'Drag and Drop Table Rows To Reorder Them.');
            $(".new1row1,.newheadorder1").show();
            j = 1;
            $('#tablereport_' + id + ' tr input.new1').each(function () {
                $(this).val(j++);
            });
        } else if ($("#reorderbtn").text() == 'Update Order') {
            alert('Are You Sure Want To Update The Order');
            var orderStr = '';
            var bankorder = 1;
            $('#tablereport_' + id + ' tr').each(function () {
                if ($(this).prop('id') != '') {
                    bankid = $(this).prop('id') + '##' + bankorder;
                    orderStr += bankid + ',';
                    bankorder++;
                }
            });
            $("#flag").val('ORDER');
            $("#orderProvider").val(modekey);
            $("#orderString").val(orderStr);
            $("#reorderbtn").text('Reorder');
            $("#backbtn").hide();
            $("#editbtn,#addbankbtn").show();
            $("#paymentbank").submit();
        }
    }
    function selectModeFunc(modevalue, key) {
        clearMsg();
        $("#" + mode).hide();
        $("#BankDiv").hide();
        mode = modevalue;
        modekey = key;
        $("#rightcontentDiv,#" + modevalue).show();
        $("#editbtn,#addbankbtn,#reorderbtn").show();
        $('#reorderbtn').text('Reorder');
        $('#addbankbtn').text('Add Bank');
        $('.headrightDiv').text(modevalue + ' Providers Bank List');
        $(".new1row1,.newheadorder1,#backbtn").hide();
//        $("#msgDiv").html("&nbsp");
        $("#mainheading").text('Payment Bank');
    }
    function backFunc() {
        $("#rightcontentDiv").show();
        $("#BankDiv").hide();
        $("#" + mode).show();
    }
    function dragDropFunc(id) {
//        clearMsg();
        $("#tablereport_" + id).tableDnD({
            onDragClass: "myDragClass", onDrop: function (table, row) {
                clearMsg();
                var i = 1;
                var j = 1;
                $('#tablereport_' + id + ' tr input.new').each(function () {
                    $(this).val(i++);
                });
                $('#tablereport_' + id + ' tr input.new1').each(function () {
                    $(this).val(j++);
                });
            }
        });
    }
//    function dropcancel() {
//        $("#addBtn" + mode).text('Add Bank');
//        $("#reorderbtn" + mode).text('Reorder');
//        $("#tablereport_" + mode).tableDnD({
//            onDragClass: ""
//        });
//        $('#tablereport_' + mode + ' tr').css('cursor', 'default');
//        $("#tablereport_" + mode).addClass('abc');
//        selectModeFunc(mode, modekey);
//        $(".new1row,.newheadorder").hide();
//    }
    function editFunc() {
        clearMsg();
        id = mode;
        if ($("#editbtn").text() == 'Change Status') {
            $("#mainheading").text('Change Status Of Bank');
            $("#editbtn").text('Update');
            $("#backbtn,#editDiv").show();
            $("#reorderbtn,#addbankbtn,#orderDiv").hide();
        } else if ($("#editbtn").text() == 'Update') {
            alert('Are You Sure Want To Update The Status');
            chkActiveBank();

            $("#flag").val('ACTIVE');
            $("#paymentbank").submit();
        }
    }
    function selectTypeFun(type) {
        clearMsg();
        requestType = type;
        $('#searchId').val('');
        searchFun();
    }
    function searchFun() {
        var flag = false;
        if ($('#searchId').val() === '') {
            $('#forsearch div').show();
            flag = true;
        }
        $('#forsearch>div').each(function () {
            if ($(this).attr('serach_tag').toUpperCase().indexOf($('#searchId').val().toUpperCase()) !== -1) {
                $(this).show();
                flag = true;
            } else {
                $(this).hide();
            }
        });
        if (!flag) {
            alert("Oops! No Result Found.");
            return false;
        }
    }
    function chkActiveBank() {
        var activeOrder = '';
        var bankidStr = '';
        $('.provider_' + requestType).each(function () {
            var checkBox = $(this).attr('id');
            var value = $("#" + checkBox).prop('checked');
            var rowId = checkBox.split("_");
            var bank_id = rowId[2];
            if (value) {
                var status = "Y";
            } else {
                var status = "N";
            }
            bankidStr = bank_id + '##' + status;
            activeOrder += bankidStr + ',';
        });
        $("#activeString").val(activeOrder);
    }
</script>