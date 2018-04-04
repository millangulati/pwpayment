<?php
$base = $this->Html->url(array('controller' => 'img'));
//$branchList = isset($response["branchList"]) ? $response["branchList"] : array();
echo $this->Html->script('jquery.tablednd.min');
$ctypeList = array('6' => 'Credit Cards', '7' => 'Debit Cards');
$cardList = isset($response["cardList"]) ? $response["cardList"] : array();
echo $this->Html->css('modemap');
//pr($cardList['6']);
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-credit-card font-green-sharp"></i>';
echo $this->Html->tag('span', 'Payment Cards', array('class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
//echo $this->Html->div('col-sm-2 form-group', '');
echo $this->Html->div('col-sm-12');

//echo $this->Html->tag('H3', 'Payment Cards');
echo $this->Html->para(isset($response["color"]) ? $response["color"] : "text-red", isset($response["msg"]) ? $response["msg"] : "&nbsp;", array('id' => 'msgDiv', "style" => "text-align:center"));

echo $this->Form->create('Bo', array("id" => "paymentmode", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));

echo $this->Html->div("row"); //row
echo $this->Html->div('col-sm-12 col-md-12'); //22
echo $this->Html->div("nav-tabs-custom"); // nav-tabs-custom
$mainTab = true;
$paneTab = true;
echo '<ul class="nav nav-tabs">';
foreach ($ctypeList as $type => $mode) {
    echo '<li class=' . ($mainTab ? "active" : "") . '><a data-toggle="tab" href="#' . $type . '" id=' . $type . ' onclick = "return selectType(\'' . $type . '\');" >' . $mode . '</a></li>';
    $mainTab = false;
}
echo '</ul>';

echo $this->Html->useTag('tagend', 'div'); //nav-tabs-custom end
echo $this->Html->useTag('tagend', 'div'); //22 end
echo $this->Html->useTag('tagend', 'div'); // row end
echo "<div class=table-responsive>";
echo $this->Html->div('', null, array('id' => 'CardlistDiv'));

echo $this->Html->useTag('tagend', 'div'); //CardlistDiv close
echo "</div>";

echo $this->Html->div('', NULL, array('id' => 'editbtnDiv'));
echo $this->Html->div('row');
echo $this->Html->div('col-sm-3 col-md-4', '');
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->button('Edit', array('id' => 'editBtn', 'type' => 'button', 'class' => 'btn btn-danger form-control', 'onclick' => 'return editFunc();')));
echo $this->Html->div('col-sm-3 col-md-2 form-group', $this->Form->button('Reorder', array('id' => 'reorderBtn', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return reorderFunc();')));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Form->end();
//echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
$status = array('Y' => 'Active', 'N' => 'Inactive');
?>
<style>
    /*.nav-tabs-custom > .nav-tabs {background-color: #2b3b55; border-bottom: 0px;}*/
    .nav-tabs-custom > .nav-tabs {
        background-color: #2AB4C0;
    }
    .nav-tabs-custom > .nav-tabs > li > a:hover{
        background-color: #17c4bb;
    }
    .nav-tabs-custom > .nav-tabs > li > a:hover {color: black;}
    .table th{background-color: #2AB4C0; border-bottom: 1px solid;color:#fff;}
    .myDragClass {background-color: #17c4bb;font-size: 16pt;}
    .new,.new1 {background: none; border: none;width: 68px;text-align: center;}
    /*#tablereport th, #tablereport td{border: 1px solid #2b3b55;padding: 5px;text-align: left;}*/
    /*    .nav-tabs-custom > .nav-tabs > li {
            border-top-color: none !important;
            border-top: 0px !important;
            margin-bottom: 0px !important;
        }
        .nav-tabs-custom > .nav-tabs > li > a {
            color: #fff !important;
        }
        .nav-tabs > li {
            margin-bottom: 0px !important;
        }
        .nav-tabs-custom > .nav-tabs > li.active > a {
            border-right-color: #17c4bb !important;
            border-left-color: #17c4bb !important;
        }
        .nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a {
            background-color: #17c4bb !important;
        }*/


</style>
<script>
    var baseurl = "<?= $base ?>";
//    mode = $('.active').prop('id');
    mode = 6;
    var cardList = '<?= json_encode($cardList) ?>';
    $('#document').ready(function () {
        $("#headneworder,.new").hide();
        selectType(mode);
        $("#statushead,.changeDiv").hide();
        $("#editBtn").click(function () {
            if ($("#editBtn").text() == 'Edit') {
                $("#oldstatushead,.oldstatusDiv").hide();
                $("#editBtn").text('Back');
                $("#reorderBtn").text('Update');
                $("#statushead,.changeDiv").show();
                sno = 1;
                var statusval = {'Y': 'Active', 'N': 'Inactive'};
                var JSONObject = JSON.parse(cardList);
                $.each(JSONObject, function (modetype) {
                    if (modetype == mode) {
                        $.each(JSONObject[modetype], function (row, value) {
                            $("#MySelect" + sno).val(statusval[value['status']]);
                            sno = sno + 1;
                        });
                    }
                });
            } else if ($("#editBtn").text() == 'Back') {

                dragDropFunc(false);
                $('#CardlistDiv').css('cursor', 'default');
                $("#editBtn").text('Edit');
                $("#reorderBtn").text('Reorder');
                $("#statushead,.changeDiv").hide();

                $("#oldstatushead,.oldstatusDiv").show();
                $("#headneworder,#neworderrow").hide();
                $("#msgDiv").html('&nbsp');

            }
        });
        $("#reorderBtn").click(function () {
            if ($("#reorderBtn").text() == 'Reorder') {
                $("#editBtn").text('Back');
                $("#reorderBtn").text('Update Order');
                dragDropFunc(true);
                $("#headneworder,#neworderrow").show();
                $("#msgDiv").html("Drag and Drop  Rows To Reorder Them.");
            }
        });
    });
//        var iCnt = 1;
//        $("#tablereport tr").each(function () {alert('xgsdfgdfgddf');
//            var id = "tr" + parseInt(iCnt);
//            $(this).attr("id", id);
//            iCnt++;
//        });
//    $('#CardlistDiv').on('click', 'tr:gt(0)', function () {
//        if ($("#editBtn").text() == 'Back' && $("#reorderBtn").text() == 'Update') {
//            var dataarr = $(this).prop('id').split("~!~");
//            alert(dataarr);
//        }
//    });
    function selectType(id) {

        mode = id;
        var statusval = {'Y': 'Active', 'N': 'Inactive'};
        $("#CardlistDiv,#tablereport").html('');
        $("#CardlistDiv,#tablereport").empty();
        var JSONObject = JSON.parse(cardList);
        var divdata = "<table id='tablereport' class='table table - striped ' ><thead class='header'><tr style = 'width : unset'><th style = 'width : 5%;'> S.No</th><th style = 'width : 5%;'> Logo</th><th>Card Type</th><th> Order </th><th id=oldstatushead>Status</th><th id=statushead>Change Status</th><th id='headneworder' style = 'width : 8%;'>New Order</th></tr></thead><tbody>";
        var sno = 1;
        $.each(JSONObject, function (modetype) {
            if (modetype == mode) {
                $.each(JSONObject[modetype], function (row, value) {
                    var neworder = "<input class=new value='" + sno + "' readonly=true>";
                    var serno = "<input class=new1 value='" + sno + "' readonly=true>";
                    var img = "<img  src='" + baseurl + '/' + value['logo'] + "' height=30 width=30>";
                    var selField = "<select id = 'MySelect" + sno + "' class='form-control abc'><option value=''>Select Status</option><option value='Active'>Active</option><option value='Inactive'>Inactive</option></select>";
                    var rowid = modetype + "~!~" + value['serno'] + "~!~" + value['card_type'] + "~!~" + value['logo'] + "~!~" + value['uiorder'] + "~!~" + value['status'];
                    divdata += "<tr class='tabcol' id='" + rowid + "'><td>" + serno + "</td><td>" + img + "</td><td>" + value['card_type'] + "</td><td>" + value['uiorder'] + "</td><td class='oldstatusDiv'>" + statusval[value['status']] + "</td><td class='changeDiv' id='selectBox" + sno + "'>" + selField + "</td><td id='neworderrow'>" + neworder + "</td></tr>";
                    sno = sno + 1;
                });
            }
        });
        $("#CardlistDiv").append(divdata + "<tbody/></table>");
        $("#editBtn").text('Edit');
        $("#reorderBtn").text('Reorder');
        $("#statushead,.changeDiv").hide();
        $("#oldstatushead,.oldstatusDiv").show();
        $("#headneworder,#neworderrow").hide();
        $("#msgDiv").html("&nbsp");
    }

    function editFunc() {
        // do something
    }
    function reorderFunc() {
        // do something
    }
    function dragDropFunc(check) {
        if (check == true) {
            $("#tablereport").tableDnD({
                onDragClass: "myDragClass",
                onDrop: function (table, row) {
                    $("#msgDiv").html("&nbsp");
                    var i = 1;
                    var j = 1;
                    $('#tablereport tr input.new').each(function () {
                        $(this).val(i++);
                    });
                    $('#tablereport tr input.new1').each(function () {
                        $(this).val(j++);
                    });
                }
            });
        } else {
            $("#tablereport").tableDnD({
                onDragClass: ""
            });
            $('#tablereport tr').css('cursor', 'default');
        }
    }
</script>