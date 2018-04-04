<?php
$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$branchList = isset($response["branchList"]) ? $response["branchList"] : array();
$paymentModeList = isset($response["paymentMode"]) ? $response["paymentMode"] : array();
$providers = isset($response["providers"]) ? $response["providers"] : array();
$providersModeType = isset($response["providerMode"]) ? $response["providerMode"] : array();
$providerMapped = isset($response["mappedData"]) ? $response["mappedData"]["providerdata"] : array();
$branchMapped = isset($response["mappedData"]) ? $response["mappedData"]["branchdata"] : array();
$result = isset($response["result1"]) ? $response["result1"] : '';
$baseurl = $this->Html->url(array('controller' => 'getJson'), true);
$provider_count = count($providers);
$branchList_count = count($branchList);
echo $this->Html->script('bootbox.min');
echo $this->Html->css('modemap');
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-sitemap font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Mode and Provider Mapping', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Edit', array('id' => 'editbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return editupdateFunc();'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('tools');
echo $this->Form->button('Back', array('id' => 'backbtn', 'type' => 'button', 'class' => 'btn btn-primary form-control', 'onclick' => 'return backForm();'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
//echo $this->Html->div('col-sm-12'); //2

echo $this->Form->create('paymentmode', array("id" => "paymentmode", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
echo $this->Form->unlockField('AuthVar');
echo $this->Form->hidden("subflag", array("id" => "subflag", 'value' => ''));
echo $this->Form->unlockField('subflag');
echo $this->Form->hidden("mapped_json", array("id" => "mapped_json", 'value' => ''));
echo $this->Form->unlockField('mapped_json');
echo $this->Form->hidden("mappedMode", array("id" => "mappedMode", 'value' => ''));
echo $this->Form->unlockField('mappedMode');
echo $this->Form->hidden("mappedType", array("id" => "mappedType", 'value' => ''));
echo $this->Form->unlockField('mappedType');
echo $this->Form->hidden("mode_id", array("id" => "mode_id", 'value' => ''));
echo $this->Form->unlockField('mode_id');
echo $this->Form->hidden("provider_str", array("id" => "provider_str", 'value' => ''));
echo $this->Form->unlockField('provider_str');
//    response
echo $this->Form->end();
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
                echo '<li class= ' . ($mainTab > 0 ? "typehead active" : "typehead ") . '><a data-toggle="tab" href="#' . $type . '"   onclick = "return selectTypeFun(\'' . $type . '\');">' . $type . '</a></li>';
                $mainTab = 0;
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right nav1">
            <li class = 'active'><a href="#provider" onclick = "return changeView('provider');"><span class="glyphicon glyphicon-user"></span> Provider View </a></li>
            <li><a href="#branch" onclick = "return changeView('branch');"><span class="glyphicon  glyphicon-home"></span> Branch View</a></li>

        </ul>
    </div>
</nav>
<?php
$first = $second = 1;
echo $this->Html->div('', null, array('id' => 'contentDiv', 'class' => 'tab-content')); // 5
foreach ($paymentModeList as $type => $mode) {

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
///////////view option  provider view
    echo $this->Html->div('', null, array('id' => 'providerviewDiv' . $type, 'class' => 'tab-content')); // 8
//    echo $this->Html->div('', null, array('id' => 'activediv' . $type, 'class' => "tab-pane active")); //9
    $chkAll1 = $this->Form->checkbox('checkAllprovider' . $type, array('id' => 'checkAllprovider' . $type, 'class' => "checkAll", 'onclick' => 'return checkAllRecord();'));
    $chkLabel1 = $this->Form->label('checkAllprovider' . $type, 'Select All', array('id' => 'checkAllprovider' . $type, 'class' => 'chk1'));
    echo $this->Html->div(''); //10
    echo '<h4 class=headrightDiv><center><span id =providerhead' . $type . ' >Select  Payment Mode</span></center></h4>' . $chkAll1 . '' . $chkLabel1 . '<hr>';

    foreach ($providersModeType[$type] as $key => $value) {
        $pid = $value['provider_id'];
        echo "<div id = $type" . '_' . "$pid>";
        echo $this->Html->div('col-xs-4 col-sm-2 col-md-1', $this->Form->checkbox($key, array('id' => 'p_' . $type . '_' . $value['provider_id'], 'class' => "providername" . $type, 'onclick' => 'return chkProviderFunc(\'' . $type . '\',\'' . $value['provider_id'] . '\',\'' . $key . '\');')));
        echo $this->Html->div('col-xs-8 col-sm-5 col-md-2 form-group', $this->Form->label('p_' . $type . '_' . $value['provider_id'], $key, array('id' => 'checklabel', 'class' => 'chk')));
        echo $this->Html->div('col-xs-12 col-sm-5 col-md-2 form-group', $this->Form->button('Branches', array('id' => 'viewbtn' . $type . '_' . $value['provider_id'], 'type' => 'button', 'class' => 'btn btn-block btn-info form-control btnclassprovider', 'onclick' => 'return showBrancheFunc(\'' . $type . '\',\'' . $value['provider_id'] . '\',\'' . $key . '\');')));
        echo "</div>";
    }
//        echo $type;
    echo "<div>";
    echo "</div>";

    echo $this->Html->useTag('tagend', 'div'); // 10 end
//    echo $this->Html->useTag('tagend', 'div'); // 9 end
    echo $this->Html->useTag('tagend', 'div'); // 8 end
    /////view option  provider view end
    ////view option branch view
    echo $this->Html->div('', null, array('id' => 'branchViewDiv' . $type, 'class' => 'tab-content main')); //11
    $chkAll = $this->Form->checkbox('checkAllbranch' . $type, array('id' => 'checkAllbranch' . $type, 'class' => "checkAll", 'onclick' => 'return checkAllRecord();'));
    $chkLabel = $this->Form->label('checkAllbranch' . $type, 'Select All', array('id' => 'checkAllbranch' . $type, 'class' => 'chk1'));
    echo $this->Html->div(''); // 12
    echo '<h4 class=headrightDiv><center><span id=branchhead' . $type . '> Select  Payment Mode</span></center></h4>' . $chkAll . '' . $chkLabel . '<hr>';
    foreach ($branchList as $key => $value) {
        echo $this->Html->div('col-xs-4 col-sm-2 col-md-1', $this->Form->checkbox($value, array('id' => 'b_' . $type . '_' . $key, 'class' => "branchname" . $type, 'onclick' => 'return chkBranchFunc(\'' . $type . '\',\'' . $key . '\',\'' . $value . '\');')));
        echo $this->Html->div('col-xs-8 col-sm-5 col-md-2 form-group', $this->Form->label('b_' . $type . '_' . $key, $value, array('id' => 'checklabel', 'class' => 'chk')));
        echo $this->Html->div('col-xs-12 col-sm-5 col-md-2 form-group', $this->Form->button('Providers', array('id' => 'viewbtnbranch' . $type . '_' . $key, 'type' => 'button', 'class' => 'btn btn-block btn-info form-control btnclassbranch', 'onclick' => 'return showproviderFunc(\'' . $type . '\',\'' . $key . '\',\'' . $value . '\');')));
    }
    echo "<div>";
    echo "</div>";

    echo $this->Html->useTag('tagend', 'div'); // 12 end
    echo $this->Html->useTag('tagend', 'div'); // 11 end
////view option branch view end

    echo $this->Html->useTag('tagend', 'div'); //6 end
}

echo $this->Html->useTag('tagend', 'div');  //5 end
//echo $this->Html->useTag('tagend', 'div'); //nav-tabs-custom test
echo $this->Html->useTag('tagend', 'div'); //4 end
echo $this->Html->useTag('tagend', 'div'); // 3 end
//echo $this->Html->useTag('tagend', 'div'); // 2 end
echo $this->Html->useTag('tagend', 'div'); // 1-row end
echo $this->Html->useTag('tagend', 'div'); // 1 end
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
</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    var providerStr = '<?= json_encode($providers) ?>';
    var providerList = JSON.parse(providerStr);
    var providerStrType = '<?= json_encode($providersModeType) ?>';
    var providerListType = JSON.parse(providerStrType);
    var branchStr = '<?= json_encode($branchList) ?>';
    var branchList = '';
    var paymentModeListStr = '<?= json_encode($paymentModeList) ?>';
    var paymentModeList = JSON.parse(paymentModeListStr);
    var providerMappedStr = '<?= json_encode($providerMapped) ?>';
    var providerMapped = '';
    var branchMappedStr = '<?= json_encode($branchMapped) ?>';
    var baseurl = "<?= $baseurl ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    var branchMapped = '';
    var pmttype = 'REQUEST';
    var viewmode = 'provider';
    var modetype = '';
    var modeid = '1';
    var provider_id = '';
    var branch_id = '';
    var code = '';
    var list = '';
    var provider_count = '';
    var branchList_count = '<?= json_encode($branchList_count) ?>';
    var editmode = false;
    var selectAll = false;
    var curr_count = provider_count;
    var provider_str = '';
    $('#document').ready(function () {
//        $('.typehead').attr('href', '#');
//        $(".typehead,.container-fluid").attr("disabled", true);
//        $('.typehead').addClass('ui-disabled');
        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
        selectTypeFun(pmttype);
        $("#backbtn,.checkAll,.chk1,#saveDivprovider,#saveDivbranch").hide();
        $("." + viewmode + "name" + pmttype).attr("disabled", true);
        $("#branchViewDivREQUEST,#branchViewDivPAYMENT,#branchViewDivCOLLECT").hide();
        $('.nav1 li').click(function () {
            $('.nav1 li').removeClass('active');
            $(this).addClass('active');
        });
        $('.typehead,#editbtn,.btnclassprovider,.btnclassbranch').click(function () {
            clearMsg();
        });
        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                $('#popup_view').modal('hide');
            }
        });
    });
    function showBrancheFunc(id, listid, name) {
        provider_id = listid;
        $("#bodyDiv").html('');
        $(".branch_list").prop('checked', false);
        if ($("#viewbtn" + id + "_" + listid).text() == 'Branches') {
            $("#modaltitle").html("There is no active Branch for <b>" + name + "</b>");
        } else {
            $("#modaltitle").html("Active Branches For: <b>" + name + "</b>");
        }
        pmttype = id;
        var divdata = '';
        var savebtn = "<a class='btn btn-app' onclick = 'return savebtn();'><i class='fa fa-cloud-download'></i> Save</a>";
        divdata = "<div class='abc'><div class = 'col-md-6 col-sm-6 col-xs-6 '><div class='chkallclass form-group'><input name='chk_allprovider' id='chk_allprovider' autocomplete='off' type='checkbox' class='hidden' onclick = 'return chk_all();' ><div class='btn-group'><label for='chk_allprovider' class=' btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='chk_allprovider' class='btn btn-default active'>Select All </label></div></div></div><div class = 'col-md-4 col-sm-4 '></div><div class = 'col-md-2 col-sm-2 col-xs-6'><div id = 'saveDivprovider' class=hidden>" + savebtn + "</div></div></div><div class=''>";
        var branchList = JSON.parse(branchStr);
        $.each(branchList, function (key, val) {
            divdata += "<div class = 'col-md-4 col-sm-4 col-xs-12'><div class='form-group'><input name='" + key + "' id='" + key + "' autocomplete='off' type='checkbox' class='branch_list hidden' onclick = 'return chkinputBox();'><div class='btn-group'><label for='" + key + "' class='btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='" + key + "' class='btn btn-default active' style='width: 180px;'>" + val + "</label></div></div></div>";
        });
        divdata += "</div>";
        $("#bodyDiv").append(divdata);
        var b_count = 0;
        providerMapped = JSON.parse(providerMappedStr);
        $.each(providerMapped, function (mode, modeval) {
            if (mode == modeid) {
                $.each(modeval, function (provider, providerval) {
                    if (provider == listid) {
                        $.each(providerval, function (branch, val) {
                            b_count = b_count + 1;
                            $("#" + branch).prop('checked', true);
                        });
                        return false;
                    }
                });
            }
        });
        if (b_count == branchList_count) {
            $("#chk_allprovider").prop('checked', true);
        }
        if (editmode == true) {
            $("#saveDiv" + viewmode).removeClass('hidden');
            $(".chkallclass").show();
            $(".branch_list").removeAttr("disabled");
        } else {
            $(".chkallclass").hide();
            $(".branch_list").attr("disabled", true);
        }
        $('#popup_view').modal('toggle');
    }

    function showproviderFunc(id, listid, name) {
        branch_id = listid;
        $("#bodyDiv").html('');
        $(".provider_list").prop('checked', false);
        pmttype = id;
        if ($("#viewbtnbranch" + id + "_" + listid).text() == 'Providers') {
            $("#modaltitle").html("Their Are No Active Providers For <b>" + name + "</b>");
        } else {
            $("#modaltitle").html("Active Providers For: <b>" + name + "</b>");
        }

        var divdata = '';
//        var editbtn = "<a class='btn btn-app' onclick = 'return editbtn();'><i class='fa fa-edit'></i> Edit</a>";
        var savebtn = "<a class='btn btn-app' onclick = 'return savebtn();'><i class='fa fa-cloud-download'></i> Save</a>";
        divdata = "<div class=''><div class = 'col-md-6 col-sm-6 col-xs-6'><div class='chkallclass form-group'><input name='chk_allbranch' id='chk_allbranch' autocomplete='off' type='checkbox' class='hidden' onclick = 'return chk_all();'><div class='btn-group'><label for='chk_allbranch' class='btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='chk_allbranch' class='btn btn-default active'>Select All </label></div></div></div><div class = 'col-md-4 col-sm-4'></div><div class = 'col-md-2 col-sm-2 col-xs-6'><div id = 'saveDivbranch' class=hidden>" + savebtn + "</div></div></div><div class=''>";
        $.each(providerListType[pmttype], function (key, val) {
            var flag_allow = true;
            if (pmttype == 'REQUEST') {
                if (modeid == '1') {
                    if (val['provider_id'] == '2') {
                        flag_allow = false;
                    }
                }
                else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                    if (val['provider_id'] == '1') {
                        flag_allow = false;
                    }
                }

            }
            if (flag_allow) {
                divdata += "<div class = 'col-md-4 col-sm-4 col-xs-12'><div class='form-group'><input name='" + val['provider_id'] + "' id='" + val['provider_id'] + "' autocomplete='off' type='checkbox' class='provider_list hidden' onclick = 'return chkinputBoxProvider();'><div class='btn-group'><label for='" + val['provider_id'] + "' class='btn green'><span class='glyphicon glyphicon-ok'></span><span>&nbsp;</span></label><label for='" + val['provider_id'] + "' class='btn btn-default active' style='width: 180px;'>" + key + "</label></div></div></div>";
            }
        });
        divdata += "</div>";
        $("#bodyDiv").append(divdata);
        var pr_count = 0;
        if (editmode == true) {
            $("#saveDiv" + viewmode).removeClass('hidden');
            $(".chkallclass").show();
            $(".provider_list").removeAttr("disabled");
        } else {
            $(".chkallclass").hide();
            $(".provider_list").attr("disabled", true);
        }
        var branchMapped = JSON.parse(branchMappedStr);
        $.each(branchMapped, function (mode, modeval) {
            if (mode == modeid) {
                $.each(modeval, function (branch, branchval) {
                    if (branch == listid) {
                        $.each(branchval, function (provider, val) {
                            $("#" + provider).prop('checked', true);
                            pr_count = pr_count + 1;
                        });
                        return false;
                    }
                });
            }
        });
        if (pr_count == provider_count) {
            $("#chk_allbranch").prop('checked', true);
        }
        if (provider_count == '1') {
            $(".chkallclass").hide();
        }
        $('#popup_view').modal('toggle');
    }
    function chk_all() {
        var checked1 = $('#chk_all' + viewmode).is(':checked');
        var currentname1 = 'provider_list';
        if (viewmode == 'provider') {
            currentname1 = 'branch_list';
        }
        $('.' + currentname1).each(function () {
            var checkBox = $(this);
//            console.debug(checkBox);
            if (checked1) {
                checkBox.prop('checked', true);
            } else {
                checkBox.prop('checked', false);
            }
        });
    }
    function selectModeFunc(id, type, name) {
        clearMsg();
        pmttype = type;
        modetype = name;
        modeid = id;
        if (viewmode == 'provider') {
            backFuncProvider(type);
        } else {
            backFuncBranch(type);
        }
        $('#providerhead' + pmttype).text("Provider List For " + name);
        $('#branchhead' + pmttype).text("Branch List For " + name);
        backFunc(pmttype);
        showRecordFunc();
    }
    function backFuncProvider(id) {
        $("#providerviewDiv" + id).show();
        $(".left").height(380);
        $("#branchViewDiv" + id).hide();
    }
    function backFuncBranch(id) {
        $("#branchViewDiv" + id).show();
        $(".left").height(820);
        $("#providerviewDiv" + id).hide();
    }
    function selectTypeFun(id) {
//        clearMsg();
        pmttype = id;
        provider_str = '';
        provider_count = 0;
        $('#providerhead' + pmttype).text(" Select Payment Mode ");
        $('#branchhead' + pmttype).text("Select Payment Mode");
        backFunc(pmttype);
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
        $.each(providerListType[pmttype], function (key, val) {
            var count_allow = true;
            if (pmttype == 'REQUEST') {
                if (modeid == '1') {
                    if (val['provider_id'] == '2') {
                        count_allow = false;
                    }
                }
                else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                    if (val['provider_id'] == '1') {
                        count_allow = false;
                    }
                }
            }
            if (count_allow) {
                provider_str += "," + val['provider_id'];
                provider_count++;
            }
        });
        $("#provider_str").val(provider_str.substr(1));
        if (viewmode == 'provider') {
            backFuncProvider(id);
            curr_count = provider_count;
        } else {
            backFuncBranch(id);
            curr_count = branchList_count;
        }
        $('#providerhead' + pmttype).text("Provider List For " + modetype);
        $('#branchhead' + pmttype).text("Branch List For " + modetype);
        showRecordFunc();
    }
    function changeView(view) {
//        clearMsg();
        viewmode = view;
        if (view == 'branch') {
            $("#providerviewDiv" + pmttype).hide();
            $(".left").height(820);
            $("#branchViewDiv" + pmttype).show();
            curr_count = branchList_count;
        } else {
            $("#providerviewDiv" + pmttype).show();
            $(".left").height(380);
            $("#branchViewDiv" + pmttype).hide();
            curr_count = provider_count;
        }
        showRecordFunc();
    }
    function editupdateFunc(id) {
        id = pmttype;
//        provider_str = '';
        if ($("#editbtn").text() == 'Edit') {
            editmode = true;
            if (modetype == '') {
                bootbox.alert('Please Select Paymnet Mode.');
                return false;
            }
            $("#editbtn").text('Update');
            $("#backbtn,.checkAll,.chk1").show();
            $(".providername" + pmttype).removeAttr("disabled");
            $(".branchname" + pmttype).removeAttr("disabled");
        } else {
//            showRecordFunc('provider');
            $("#subflag").val('SUBMIT');
            $("#mappedType").val(pmttype);
            $("#mappedMode").val(modetype);
            $("#mode_id").val(modeid);
//            $("#provider_id").val(modetype);
            $("#mapped_json").val(providerMappedStr);
//            $(".providername" + pmttype).each(function () {
//                var checkBoxP = $(this).attr('id');
//                var valueP = $("#" + checkBoxP).prop('checked');
//                var rowIdP = checkBoxP.split("_");
//                var reqTypeP = rowIdP[2];
//                if (valueP) {
//                    provider_str += "," + reqTypeP;
//                }
//            });
//            $("#provider_str").val(provider_str);
            $("#paymentmode").submit();
        }
    }
    function backFunc(id) {
        editmode = false;
        $("#editbtn").text('Edit');
        $("#backbtn,.checkAll,.chk1").hide();
        $(".providername" + pmttype + ",.branchname" + pmttype).attr("disabled", true);
        reset();
        showRecordFunc();
    }
    function savebtn() {
        $("#saveDiv" + viewmode).addClass('hidden');
        $(".chkallclass").hide();
        if (viewmode == 'branch') {
            list = 'provider';
        } else {
            list = 'branch';
        }
        $("." + list + "_list").attr("disabled", true);
        changerecord();
    }
    function showRecordFunc() {
//        clearMsg();
        if (pmttype == 'REQUEST') {
            if (modeid == '1') {
                $("#REQUEST_2").hide();
                $("#REQUEST_1").show();
            } else {
                $("#REQUEST_1").hide();
                $("#REQUEST_2").show();
            }
        }
        if (viewmode == 'provider') {
            $(".providername" + pmttype).prop('checked', false);
            $(".btnclassprovider").text('Branches');
            var providerMapped = JSON.parse(providerMappedStr);
            $.each(providerMapped, function (mode, modeval) {
                if (mode == modeid) {
                    $.each(modeval, function (provider, providerval) {
                        var count = 0;
                        $.each(providerval, function (branch, val) {
                            count = count + 1;
                        });
                        if (count > 0) {
                            $("#viewbtn" + pmttype + "_" + provider).html('Branches(' + count + ')');
                            $("#p_" + pmttype + "_" + provider).prop('checked', true);
                        }
                    });
                }
            });
        } else {
            $(".branchname" + pmttype).prop('checked', false);
            $(".btnclassbranch").text('Providers');
            branchMapped = JSON.parse(branchMappedStr);
            $.each(branchMapped, function (mode, modeval) {
                if (mode == modeid) {
                    $.each(modeval, function (branch, branchval) {
                        var count = 0;
                        $.each(branchval, function (provider, val) {
                            count = count + 1;
                        });
                        if (count > 0) {
                            $("#viewbtnbranch" + pmttype + "_" + branch).text('Providers(' + count + ')');
                            $("#b_" + pmttype + "_" + branch).prop('checked', true);
                        }
                    });
                }
            });
        }
        chkUnchkSelectAllSigle();
    }
    function changerecord() {
        if (viewmode == 'provider') {
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
            var obj = JSON.parse(providerMappedStr);
            if (count > 0) {
                if (typeof obj[modeid] === 'undefined') {
                    obj[modeid] = [];
                    for (i = 1; i <= branchList_count; i++) {
                        if (typeof obj[modeid][i] === 'undefined') {
                            obj[modeid][i] = [];
                        }
                    }
                }
                obj[modeid][provider_id] = (JSON.parse(newarr));
                providerMappedStr = JSON.stringify(obj);
                $("#viewbtn" + pmttype + "_" + provider_id).html('Branches(' + count + ')');
                $("#p_" + pmttype + "_" + provider_id).prop('checked', true);
            } else {
                delete obj[modeid][provider_id];
                providerMappedStr = JSON.stringify(obj);
                $("#viewbtn" + pmttype + "_" + provider_id).text('Branches');
                $("#p_" + pmttype + "_" + provider_id).prop('checked', false);
            }
        } else {
            var providerArr = {};
            var count_p = 0;
            var cls = 'provider_list';
            $('.' + cls).each(function () {
                var checkBox = $(this).attr('id');
                var val1 = $("#" + checkBox).prop('checked');
                if (val1) {
                    providerArr[checkBox] = "Y";
                    count_p = count_p + 1;
                }
            });
            var newarr_p = JSON.stringify(providerArr);
            var obj_p = JSON.parse(branchMappedStr);
            if (count_p > 0) {
                if (typeof obj_p[modeid] === 'undefined') {
                    obj_p[modeid] = [];
                    $.each(providerListType[pmttype], function (key, val) {
                        var pro_allow1 = true;
                        if (pmttype == 'REQUEST') {
                            if (modeid == '1') {
                                if (val['provider_id'] == '2') {
                                    pro_allow1 = false;
                                }
                            }
                            else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                                if (val['provider_id'] == '1') {
                                    pro_allow1 = false;
                                }
                            }

                        }
                        if (pro_allow1) {
                            if (typeof obj_p[modeid][val['provider_id']] === 'undefined') {
                                obj_p[modeid][val['provider_id']] = [];
                            }
                        }
                    });
                }
                obj_p[modeid][branch_id] = (JSON.parse(newarr_p));
                branchMappedStr = JSON.stringify(obj_p);
                $("#viewbtnbranch" + pmttype + "_" + branch_id).text('Providers(' + count_p + ')');
                $("#b_" + pmttype + "_" + branch_id).prop('checked', true);
            } else {
                delete obj_p[modeid][branch_id];
                branchMappedStr = JSON.stringify(obj_p);
                $("#viewbtnbranch" + pmttype + "_" + branch_id).text('Providers');
                $("#b_" + pmttype + "_" + branch_id).prop('checked', false);
            }
        }
        $('#popup_view').modal('toggle');
        ArrayUpdate();
        chkUnchkSelectAllSigle();
    }


    function chkProviderFunc(pymttype, providerid, providername) {
        provider_id = providerid;
        changerecordSingle();
    }
    function chkBranchFunc(pymttype, branchid, providername) {
        branch_id = branchid;
        changerecordSingle();
    }
    function changerecordSingle() {
        if (viewmode == 'provider') {
            var chkboxStatus = $("#p_" + pmttype + "_" + provider_id).prop('checked');
            if (chkboxStatus) {
                var branchArr = {};
                var count = 0;
                for (checkBox = 1; checkBox < (+branchList_count + 1); checkBox++) {
                    branchArr[checkBox] = "Y";
                    count = count + 1;
                }
                var newarr = JSON.stringify(branchArr);
                var obj = JSON.parse(providerMappedStr);
                if (typeof obj[modeid] === 'undefined') {
                    obj[modeid] = [];
                    for (i = 1; i <= branchList_count; i++) {
                        if (typeof obj[modeid][i] === 'undefined') {
                            obj[modeid][i] = [];
                        }
                    }
                }

                obj[modeid][provider_id] = (JSON.parse(newarr));
                providerMappedStr = JSON.stringify(obj);
                $("#viewbtn" + pmttype + "_" + provider_id).html('Branches(' + count + ')');
                $("#p_" + pmttype + "_" + provider_id).prop('checked', true);
            } else {
                var obj = JSON.parse(providerMappedStr);
                delete obj[modeid][provider_id];
                providerMappedStr = JSON.stringify(obj);
                $("#viewbtn" + pmttype + "_" + provider_id).text('Branches');
                $("#p_" + pmttype + "_" + provider_id).prop('checked', false);
            }
        } else {
            var chkboxStatus = $("#b_" + pmttype + "_" + branch_id).prop('checked');
            if (chkboxStatus) {
                var providerArr = {};
                var count_p = 0;
                $.each(providerListType[pmttype], function (key, val) {

                    var pro_allow = true;
                    if (pmttype == 'REQUEST') {
                        if (modeid == '1') {
                            if (val['provider_id'] == '2') {
                                pro_allow = false;
                            }
                        }
                        else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                            if (val['provider_id'] == '1') {
                                pro_allow = false;
                            }
                        }

                    }
                    if (pro_allow) {
                        providerArr[val['provider_id']] = "Y";
                        count_p = count_p + 1;
                    }
                });
                var newarr_p = JSON.stringify(providerArr);
                var obj_p = JSON.parse(branchMappedStr);
                if (typeof obj_p[modeid] === 'undefined') {
                    obj_p[modeid] = [];
                    $.each(providerListType[pmttype], function (key, val) {
                        var pro_allow1 = true;
                        if (pmttype == 'REQUEST') {
                            if (modeid == '1') {
                                if (val['provider_id'] == '2') {
                                    pro_allow1 = false;
                                }
                            }
                            else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                                if (val['provider_id'] == '1') {
                                    pro_allow1 = false;
                                }
                            }

                        }
                        if (pro_allow1) {
                            if (typeof obj_p[modeid][val['provider_id']] === 'undefined') {
                                obj_p[modeid][val['provider_id']] = [];
                            }
                        }
                    });
                }
                obj_p[modeid][branch_id] = (JSON.parse(newarr_p));
                branchMappedStr = JSON.stringify(obj_p);
                $("#viewbtnbranch" + pmttype + "_" + branch_id).text('Providers(' + count_p + ')');
                $("#b_" + pmttype + "_" + branch_id).prop('checked', true);
            } else {
                var obj_p = JSON.parse(branchMappedStr);
                delete obj_p[modeid][branch_id];
                branchMappedStr = JSON.stringify(obj_p);
                $("#viewbtnbranch" + pmttype + "_" + branch_id).text('Providers');
                $("#b_" + pmttype + "_" + branch_id).prop('checked', false);
            }

        }
        ArrayUpdate();
        chkUnchkSelectAllSigle();
    }

    function checkAllRecord() {
        if (viewmode == 'provider') {
            var chkboxStatus = $("#checkAllprovider" + pmttype).prop('checked');
            var providerRecord = {};
            if (chkboxStatus) {
                $(".providername" + pmttype).each(function () {

                    var visible = true;
                    var checkBoxPro = $(this).attr('id');
                    if ($("#" + checkBoxPro).is(':visible') === false) {
                        visible = false;
                    }
                    if (visible == true) {
                        var rowIdPro = checkBoxPro.split("_");
                        var reqTypePro = rowIdPro[2];
                        providerRecord[reqTypePro] = {};
                        for (j = 1; j <= branchList_count; j++) {
                            providerRecord[reqTypePro][j] = "Y";
                        }
                    }
                });
                var newarr = JSON.stringify(providerRecord);
                var obj = JSON.parse(providerMappedStr);
                if (typeof obj[modeid] === 'undefined') {
                    obj[modeid] = [];
                }
                obj[modeid] = (JSON.parse(newarr));
                providerMappedStr = JSON.stringify(obj);
                $(".btnclassprovider").html('Branches(' + branchList_count + ')');
                $(".providername" + pmttype).prop('checked', true);
                $("#checkAllprovider" + pmttype).prop('checked', true);
            } else {
                var obj = JSON.parse(providerMappedStr);
                delete obj[modeid];
                providerMappedStr = JSON.stringify(obj);
                $(".btnclassprovider").text(' Branches');
                $(".providername" + pmttype).prop('checked', false);
                $("#checkAllprovider" + pmttype).prop('checked', false);
            }
        } else {
            var chkboxStatus = $("#checkAllbranch" + pmttype).prop('checked');
            var branchRecord = {};
            if (chkboxStatus) {
                for (i = 1; i <= branchList_count; i++) {
                    branchRecord[i] = {};
                    var procount = '';
                    $.each(providerListType[pmttype], function (key, val) {
                        var pro_allow1 = true;
                        if (pmttype == 'REQUEST') {
                            if (modeid == '1') {
                                if (val['provider_id'] == '2') {
                                    pro_allow1 = false;
                                }
                            }
                            else if (modeid == '2' || modeid == '3' || modeid == '4' || modeid == '9') {
                                if (val['provider_id'] == '1') {
                                    pro_allow1 = false;
                                }
                            }

                        }
                        if (pro_allow1) {
                            procount++;
                            var checkBoxbR = val['provider_id'];
                            branchRecord[i][checkBoxbR] = "Y";
                        }
                    });
                }
                var newarr_p = JSON.stringify(branchRecord);
                var obj_p = JSON.parse(branchMappedStr);
                if (typeof obj_p[modeid] === 'undefined') {
                    obj_p[modeid] = [];
                }
                obj_p[modeid] = (JSON.parse(newarr_p));
                branchMappedStr = JSON.stringify(obj_p);
                $(".btnclassbranch").text('Providers(' + procount + ')');
                $(".branchname" + pmttype).prop('checked', true);
                $("#checkAllbranch" + pmttype).prop('checked', true);
            } else {
                var obj_p = JSON.parse(branchMappedStr);
                delete obj_p[modeid];
                branchMappedStr = JSON.stringify(obj_p);
                $(".btnclassbranch").text(' Providers');
                $(".branchname" + pmttype).prop('checked', false);
                $("#checkAllbranch" + pmttype).prop('checked', false);
            }
        }
        ArrayUpdate();
    }
    function ArrayUpdate() {
        var str = '';
        if (viewmode == 'provider') {
            str = providerMappedStr;
        } else {
            str = branchMappedStr;
        }
        var dataString = "str=" + str + "&AuthVar=" + AuthVar;
        var url = baseurl + "/updateArrayData";
        $('#loaderDiv').show();
        AsyncAjaxRequest(url, dataString, ArrayUpdateCallBack);
    }
    function ArrayUpdateCallBack(status, data) {
        $('#loaderDiv').hide();
        if (status === 200) {
            var JSONObject = JSON.parse(JSON.parse(data).data);
            if (viewmode == 'provider') {
                branchMappedStr = JSON.stringify(JSONObject);
            } else {
                providerMappedStr = JSON.stringify(JSONObject);
            }
        } else {
            alert('Error In Saving Data. Please Refresh And Try Again.');
            return false;
        }
    }
    function chkUnchkSelectAllSigle() {
        var cnt = 0;
        $("." + viewmode + "name" + pmttype).each(function () {
            var checkBox = $(this).attr('id');
            var val1 = $("#" + checkBox).prop('checked');
            if (val1) {
                cnt += 1;
            }
        });
        if (cnt == curr_count) {
            $("#checkAll" + viewmode + pmttype).prop('checked', true);
        } else {
            $("#checkAll" + viewmode + pmttype).prop('checked', false);
        }
    }
    function backForm() {
        backFunc(pmttype);
        provider_str = '';
    }
    function reset() {
        branchMappedStr = '<?= json_encode($branchMapped) ?>';
        providerMappedStr = '<?= json_encode($providerMapped) ?>';
    }

    function chkinputBox() {
        bra_count = 0;
        $('.branch_list').each(function () {
            if (this.checked == true) {
                bra_count++;
            }
        });
        if (bra_count == branchList_count) {
            $("#chk_allprovider").prop('checked', true);
        } else {
            $("#chk_allprovider").prop('checked', false);
        }
    }
    function chkinputBoxProvider() {
        var pro_count = 0;
        $('.provider_list').each(function () {
            if (this.checked == true) {
                pro_count++;
            }
        });
        if (pro_count == provider_count) {
            $("#chk_allbranch").prop('checked', true);
        } else {
            $("#chk_allbranch").prop('checked', false);
        }
    }
</script>