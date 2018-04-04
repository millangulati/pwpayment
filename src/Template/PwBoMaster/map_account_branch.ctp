
<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";

$baseurl = $this->Html->url(array('controller' => 'getJson'), true);
$bankList = isset($response["banklist"]) ? $response["banklist"] : array();
$accountList = isset($response['accountList']) ? $response['accountList'] : array();
$activeAccountList = isset($response['activeAccountList']) ? $response['activeAccountList'] : array();
$branchList = isset($response["branchList"]) ? $response["branchList"] : array();
$branchList_count = count($branchList);
$mappedData = isset($response["mappedData"]) ? $response["mappedData"] : array();
//pr($mappedData);
//pr($activeAccountList);

echo $this->Html->css('modemap');
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-bank font-green-sharp"></i>';
echo $this->Html->tag('span', ' Map Account With Branch', array('class' => 'caption-subject font-green-sharp bold uppercase', 'id' => 'mainheading'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'submitbtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return submitFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Edit', array('id' => 'editbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return editFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //portlet-body
echo $this->Html->div('row'); //1-row
//echo $this->Html->div('col-sm-12'); 2

echo $this->Form->create('Bo', array("id" => "mapaccountbank", "target" => "_self", "autocomplete" => "off", "type" => "file"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));

echo $this->Form->hidden("activeString", array("id" => "activeString", 'value' => ''));
echo $this->Form->unlockField('activeString');

echo $this->Form->hidden("bankid", array("id" => "bankid", 'value' => ''));
echo $this->Form->unlockField('bankid');
echo $this->Form->hidden("flag", array("id" => "flag", 'value' => ''));
echo $this->Form->unlockField('flag');
echo $this->Form->end();
//echo $this->Html->div(''); //row
echo $this->Html->div('', NULL, array('id' => 'mapDiv')); //mapDiv
echo $this->Html->div('col-sm-4 col-xs-12 col-md-2 left'); //left
echo "<nav class=nav-sidebar>";
echo '<ul class="nav nav-tabs-justified">';
echo '<h4 style="color:#fff;"><center>Bank List</center></h4>';
$list = true;

foreach ($bankList as $key => $value) {
    echo '<li class = ' . ($list ? "active" : "") . '><a data-toggle="tab" href="#nav_' . $key . '" id="bankid' . $key . '" onclick = "return selectBankFunc(\'' . $value . '\',\'' . $key . '\');">' . $value . '</a></li>';
    $list = false;
}
echo '</ul>';
echo "</nav>";
echo $this->Html->useTag('tagend', 'div'); //left end

echo $this->Html->div('', null, array('id' => 'rightcontentDiv', 'class' => 'tab-content')); //rightcontentdiv
$chkAll = $this->Form->checkbox('checkAllprovider', array('id' => 'checkAllaccount', 'class' => "checkAll", 'onclick' => 'return checkAllRecord();'));
$chkLabel = $this->Form->label('checkAllaccount', 'Select All', array('id' => 'checkAllaccountlbl', 'class' => 'checkallAccountclass'));
//echo '<center><h4 class=headrightDiv id=headerid ></h4></center>';
echo '<center><h4 class=headrightDiv><span id =providerhead></span></h4></center>' . $chkAll . '' . $chkLabel;
$tab = true;

foreach ($bankList as $bankid => $value1) {
    echo $this->Html->div('', null, array('id' => "nav_" . $bankid, 'class' => ($tab ? "tab-pane active" : "tab-pane"))); //tab pane
    if (isset($accountList[$bankid])) {
        foreach ($accountList[$bankid] as $acc_no => $acc_no_data) {
            $pid = $acc_no_data['serno'];
            $chkId = $pid . "_" . $bankid;
            echo "<div id = $bankid" . '_DIV_' . "$pid>";
            echo $this->Html->div('col-xs-4 col-sm-2 col-md-1', $this->Form->checkbox($acc_no_data['serno'], array('id' => $bankid . '_' . $acc_no, 'class' => 'accountNumber' . $bankid, 'onclick' => 'return chkAccountFunc(\'' . $bankid . '\',\'' . $acc_no . '\',\'' . $acc_no_data['serno'] . '\');')));
            echo $this->Html->div('col-xs-8 col-sm-5 col-md-2 form-group', $this->Form->label($bankid . '_' . $acc_no, $acc_no, array('id' => 'checklabel', 'class' => 'chk')));
//            echo "<div class = 'col-md-3 col-sm-8 col-xs-8'><div class='form-group'><input name=$chkId id=$chkId autocomplete='off' type='checkbox' class='accountlist hidden ' ><div class='btn-group'><label for=$chkId class='btn green  '><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for=$chkId class='btn btn-default active  ' style='width: 240px;'>$acc_no</label></div></div></div>";
            echo $this->Html->div('col-xs-12 col-sm-4 col-md-2 form-group', $this->Form->button('Branches', array('id' => 'viewbtn' . $acc_no, 'type' => 'button', 'class' => 'btn btn-block btn-info form-control btnclassaccount', 'onclick' => 'return showBrancheFunc(\'' . $acc_no . '\',\'' . $pid . '\',\'' . $bankid . '\');')));
            echo "</div>";
        }
    } else {
        echo '<h4><center>Account Not Found.</center></h4>';
    }
    $tab = false;
    echo $this->Html->useTag('tagend', 'div'); //tab pane end
}
echo $this->Html->useTag('tagend', 'div'); //rightcontentdiv end
//echo $this->Html->useTag('tagend', 'div'); // end1-row
echo $this->Html->useTag('tagend', 'div'); // 2 end


echo $this->Html->useTag('tagend', 'div'); // end mapDiv
echo $this->Html->useTag('tagend', 'div'); //portlet-body end

echo $this->Form->create('formback', array("name" => "formback", 'id' => 'formback', "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->end();
?>
<div class="modal fade popup_view" id="popup_view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title" id ="modaltitle"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id = "bodyDiv">


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .alert {line-height: 3px;margin-bottom: -15px;}
    .tools{margin-right: 10px;display: none;}
    a {color: white;}
    .left{height: auto;}
    @media(max-width:766px){.left{height: auto;}}
    .headDiv,.headrightDiv { line-height: 40px;/*background-color: rgb(0, 173, 239);*/;font-weight: bold;color:#2b3b55;margin-bottom: 34px;}
    .headDiv{margin-bottom: 40px;}
    .nav-tabs-justified > li > a {border-radius:0px;}
    /*    .box-header.with-border {
            border-bottom: 1px solid #f4f4f4;
            background-color: aliceblue;
            height: 48px;
        }*/
    /*input[type="checkbox"] { display: none;}*/
    input[type="checkbox"] + .btn-group > label span {width: 20px; }
    input[type="checkbox"] + .btn-group > label span:first-child {display: none;}
    input[type="checkbox"] + .btn-group > label span:last-child {display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:first-child { display: inline-block;}
    input[type="checkbox"]:checked + .btn-group > label span:last-child {display: none;}
    /*    #searchId {
            min-width: 62px;
        }*/
</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var bankList = '<?= json_encode($bankList) ?>';
    var bankListNew = JSON.parse(bankList);
    var accountListStr = '<?= json_encode($accountList) ?>';
    var accountList = JSON.parse(accountListStr);
    var activeAccountListStr = '<?= json_encode($mappedData) ?>';
    var activeAccountList = '';
    var bankidnav = $('.tab-pane.active').prop('id').split("_");
    var bankid = bankidnav[1];
    var bankname = bankListNew[bankid];
    var branchStr = '<?= json_encode($branchList) ?>';
    var branchList = JSON.parse(branchStr);
    var branchList_count = '<?= json_encode($branchList_count) ?>';
    var editmode = false;
    var accountCount = 0;
    var account_num = '';
    var ser_no_id = '';
    var baseurl = "<?= $baseurl ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    $('#document').ready(function () {
        $('.headrightDiv').text(bankname + ' Account List');
        $("#submitbtn,#backbtn,.checkAll,.checkallAccountclass").hide();
        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
        $("#backbtn").click(function () {
            $('#formback').submit();
        });
        showRecordFunc();
//        $(".accountNumber" + bankid).click(function () {
//            alert('sds');
//        });
    });
    function selectBankFunc(bank_name, bank_id) {
        bankid = bank_id;
        bankname = bank_name;
        $('.headrightDiv').text(bankname + ' Account List');
        resetFun();
    }
    function showRecordFunc() {
        $(".accountNumber" + bankid).prop('checked', false);
        $(".accountNumber" + bankid).attr("disabled", true);
        $(".btnclassaccount").text('Branches');
        accountCount = 0;
//        accountList
        $.each(accountList, function (bank, bankval) {
            if (bank == bankid) {
                $.each(bankval, function (account, accountval) {
                    accountCount++;
                });
            }
        });
        activeAccountList = JSON.parse(activeAccountListStr);
        $.each(activeAccountList, function (bank, bankval) {
            if (bank == bankid) {
                $.each(bankval, function (account, accountval) {
                    var count = 0;
                    $.each(accountval, function (branch, branchval) {
                        count = count + 1;
                    });
                    if (count > 0) {
                        $("#viewbtn" + account).text('View Branches(' + count + ')');
                        $("#" + bankid + "_" + account).prop('checked', true);
                    }
                });
            }
        });
        chkUnchkSelectAllSigle();
    }
    function chkUnchkSelectAllSigle() {
        var activeAccountCount = 0;
        $(".accountNumber" + bankid).each(function () {
            var checkBox = $(this).attr('id');
            var val1 = $("#" + checkBox).prop('checked');
            if (val1) {
                activeAccountCount++;
            }
        });
        if (activeAccountCount == accountCount && activeAccountCount != 0) {
            $("#checkAllaccount").prop('checked', true);
        } else {
            $("#checkAllaccount").prop('checked', false);
        }
    }

    function showBrancheFunc(account_no, ser_no, bank_id) {
        account_num = account_no;
        ser_no_id = ser_no;
        bankid = bank_id;
        $("#bodyDiv").html('');
        $(".branch_list").prop('checked', false);
        if ($("#viewbtn" + ser_no) == 'Branches') {
            $("#modaltitle").html("There is no active Branch for <b>" + bankname + "</b>");
        } else {
            $("#modaltitle").html("Active Branches For: <b>" + bankname + "</b>");
        }
        var divdata = '';
        var savebtn = "<a class='btn btn-app' onclick = 'return savebtnfun();'><i class='fa fa-cloud-download'></i> Save</a>";
        divdata = "<div class='abc'><div class = 'col-md-6 col-sm-6 col-xs-6 '><div class='chkallclass form-group'><input name='chk_allbranch' id='chk_allbranch' autocomplete='off' type='checkbox' class='hidden' onclick = 'return chk_all();' ><div class='btn-group'><label for='chk_allbranch' class=' btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='chk_allbranch' class='btn btn-default active'>Select All </label></div></div></div><div class = 'col-md-4 col-sm-4 '></div><div class = 'col-md-2 col-sm-2 col-xs-6'><div id = 'saveDivBranch' class=hidden>" + savebtn + "</div></div></div><div class=''>";
        $.each(branchList, function (key, val) {
            divdata += "<div class = 'col-md-4 col-sm-4 col-xs-12'><div class='form-group'><input name='" + key + "' id='" + key + "' autocomplete='off' type='checkbox' class='branch_list hidden' onclick = 'return chkinputBox();'><div class='btn-group'><label for='" + key + "' class='btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='" + key + "' class='btn btn-default active' style='width: 180px;'>" + val + "</label></div></div></div>";
        });
        divdata += "</div>";
        $("#bodyDiv").append(divdata);
        var b_count = 0;
        activeAccountList = JSON.parse(activeAccountListStr);
        $.each(activeAccountList, function (bank, bankval) {
            if (bank == bankid) {
                $.each(bankval, function (account, accountval) {
                    if (account == account_no) {
                        $.each(accountval, function (branch, branchval) {
                            b_count = b_count + 1;
                            $("#" + branch).prop('checked', true);
                        });
                        return false;
                    }
                });
            }
        });
        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                $('#popup_view').modal('hide');
            }
        });
        if (b_count == branchList_count) {
            $("#chk_allbranch").prop('checked', true);
        }
        if (editmode == true) {
            $("#saveDivBranch").removeClass('hidden');
            $(".chkallclass").show();
            $(".branch_list").removeAttr("disabled");
        } else {
            $(".chkallclass").hide();
            $(".branch_list").attr("disabled", true);
        }
        $('#popup_view').modal('toggle');
    }
    function editFunc() {
        clearMsg();
        editmode = true;
        $("#backbtn,.checkAll,.checkallAccountclass,#submitbtn").show();
        $("#editbtn").hide();
        $(".accountNumber" + bankid).removeAttr("disabled");
    }
    function resetFun() {
        clearMsg();
        editmode = false;
        $("#editbtn").show();
        $("#backbtn,.checkAll,.checkallAccountclass,#submitbtn").hide();
        $(".accountNumber" + bankid).attr("disabled", true);
        activeAccountListStr = '<?= json_encode($mappedData) ?>';
        showRecordFunc();
    }
    function savebtnfun() {
        changerecord();
    }
    function changerecord() {
        var branchArr = {};
        var count = 0;
        var cls = 'branch_list';
        $('.' + cls).each(function () {
            var checkBox = $(this).attr('id');
            var val1 = $("#" + checkBox).prop('checked');
            if (val1) {
                branchArr[checkBox] = "Y";
                count = count + 1;
            }
        });
        var newarr = JSON.stringify(branchArr);
        var obj = JSON.parse(activeAccountListStr);
        if (count > 0) {
            if (typeof obj[bankid] === 'undefined') {
                obj[bankid] = {};
            }
            if (typeof obj[bankid][account_num] === 'undefined') {
                obj[bankid][account_num] = [];
            }
            obj[bankid][account_num] = (JSON.parse(newarr));
            activeAccountListStr = JSON.stringify(obj);
            $("#viewbtn" + account_num).text('View Branches(' + count + ')');
            $("#" + bankid + "_" + account_num).prop('checked', true);
        } else {
            delete obj[bankid][account_num];
            activeAccountListStr = JSON.stringify(obj);
            $("#viewbtn" + account_num).text('Branches');
            $("#" + bankid + "_" + account_num).prop('checked', false);
        }
        $('#popup_view').modal('toggle');
        chkUnchkSelectAllSigle();
    }
    function chkAccountFunc(bank_id, acc_nochk, ser_no) {
        account_num = acc_nochk;
        if ($("#" + bank_id + "_" + acc_nochk).prop('checked')) {
            var branchArr = {};
            var count = 0;
            for (i = 1; i <= branchList_count; i++) {
                branchArr[i] = "Y";
                count++;
            }
            var newarr = JSON.stringify(branchArr);
            var obj = JSON.parse(activeAccountListStr);
            if (typeof obj[bankid] === 'undefined') {
                obj[bankid] = {};
            }
            if (typeof obj[bankid][acc_nochk] === 'undefined') {
                obj[bankid][acc_nochk] = [];
            }
            obj[bankid][acc_nochk] = (JSON.parse(newarr));
            activeAccountListStr = JSON.stringify(obj);
            $("#viewbtn" + acc_nochk).text('View Branches(' + count + ')');
            $("#" + bankid + "_" + acc_nochk).prop('checked', true);
        }
        else {
            var obj = JSON.parse(activeAccountListStr);
            delete obj[bankid][acc_nochk];
            activeAccountListStr = JSON.stringify(obj);
            $("#viewbtn" + acc_nochk).text('Branches');
            $("#" + bankid + "_" + acc_nochk).prop('checked', false);
        }
        chkUnchkSelectAllSigle();
    }

    function checkAllRecord() {

        if ($("#checkAllaccount").prop('checked')) {
            var AccountbranchArr = {};
            $.each(accountList, function (bank, bankval) {
                if (bank == bankid) {
                    $.each(bankval, function (account, accountval) {
                        AccountbranchArr[account] = {};
                        for (j = 1; j <= branchList_count; j++) {
                            AccountbranchArr[account][j] = "Y";
                        }
                    });
                }
            });
            var newarrR = JSON.stringify(AccountbranchArr);
            var obj = JSON.parse(activeAccountListStr);
            if (typeof obj[bankid] === 'undefined') {
                obj[bankid] = {};
            }
            obj[bankid] = (JSON.parse(newarrR));
            activeAccountListStr = JSON.stringify(obj);
            $(".btnclassaccount").text('View Branches(' + branchList_count + ')');
            $(".accountNumber" + bankid).prop('checked', true);
        }
        else {
            var obj = JSON.parse(activeAccountListStr);
            delete obj[bankid];
            activeAccountListStr = JSON.stringify(obj);
            $(".btnclassaccount").text('Branches');
            $(".accountNumber" + bankid).prop('checked', false);
        }
    }
    function chkinputBox() {
        bra_count = 0;
        $('.branch_list').each(function () {
            if (this.checked == true) {
                bra_count++;
            }
        });
        if (bra_count == branchList_count) {
            $("#chk_allbranch").prop('checked', true);
        } else {
            $("#chk_allbranch").prop('checked', false);
        }
    }
    function chk_all() {
        var checked1 = $('#chk_allbranch').is(':checked');
        $('.branch_list').each(function () {
            var checkBox = $(this);
            if (checked1) {
                checkBox.prop('checked', true);
            } else {
                checkBox.prop('checked', false);
            }
        });
    }
    function submitFunc() {
        $("#bankid").val(bankid);
        $("#activeString").val(activeAccountListStr);
        $("#mapaccountbank").submit();
    }

</script>