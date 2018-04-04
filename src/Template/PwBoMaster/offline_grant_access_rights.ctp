<?php

$SuccessMessage = isset($response["SuccessMessage"]) ? $response["SuccessMessage"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
$bankoptions  =   isset($response['banklist']) ? $response['banklist'] : array();
$banksAccounts	=   isset($response['bankaccountlist']) ? $response['bankaccountlist'] : array();
$offlineAccounts =   isset($response['offlineAccounts']) ? $response['offlineAccounts'] : array();

echo $this->Html->script('jquery.tablednd.min');
echo $this->Html->css('modemap');
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-exclamation-triangle font-green-sharp"></i>';
echo $this->Html->tag('span', ' Offline Granting Access Rights', array('class' => 'caption-subject font-green-sharp bold uppercase', 'id' => 'mainheading'));
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('tools');
echo $this->Form->button('Submit', array('id' => 'updateaccessrights', 'type' => 'button', 'class' => 'btn green form-control'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');

echo $this->Html->div('portlet-body'); //1
echo $this->Html->div('row'); //1-row
echo $this->Html->div('col-sm-12');

echo $this->Form->create('form-offlinerights', array("id" => "form-offlinerights", "target" => "_self", "autocomplete" => "off", "type" => "file"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
echo $this->Form->unlockField('AuthVar');
echo $this->Form->hidden("offline_flag", array("id" => "offline_flag", 'value' => ''));
echo $this->Form->unlockField('offline_flag');
echo $this->Form->input('hiddencheckedrights', array("id" => "hiddencheckedrights", "type" => "hidden", 'value' => ''));
echo $this->Form->unlockField('hiddencheckedrights');
echo $this->Form->input('hiddenuncheckedrights', array("id" => "hiddenuncheckedrights", "type" => "hidden", 'value' => ''));
echo $this->Form->unlockField('hiddenuncheckedrights');
echo $this->Form->end();
//echo $this->Html->div(''); //row
echo $this->Html->div('', NULL, array('id' => 'orderDiv'));

echo $this->Html->div('', null, array('id' => 'rightcontentDiv11', 'class' => 'tab-content111'));
echo '<center><h4 class=headrightDiv >Offline Granting</h4></center>';
    echo $this->Html->div('', null, array('id' => 'grantingAccess', 'class' => "tab-pane active"));

        echo "<div class=table-responsive>";
        $table =  "<table id='tablereport' class='table table-bordered abc' >"
                . "<thead class='header'>"
                . "<tr style='width : 98.5%'>"
                . "<th>Bank Name</th>"
                . "<th>Account No.</th>"
                . "<th class='centertext'>Active</th>"
                . "<th class='centertext'>In-active</th>";

        $table .="</tr></thead><tbody>";
        echo $table;
        $sno = '1';
        foreach ($bankoptions as $key=>$bankName) {
            $rowspan = 0;
            if(isset($banksAccounts[$key]) && !empty($banksAccounts[$key])) {
                $rowspan = count($banksAccounts[$key]);
            }

            $rowspancond = $rowspan == 0 ? '' : array('rowspan'=>$rowspan);

            echo "<tr id =''>";
            echo $this->Html->tag('td', $bankName,$rowspancond);
            if(isset($banksAccounts[$key]) && !empty($banksAccounts[$key])) {
                $count= 1;
                foreach($banksAccounts[$key] as $keyac=>$keyval) {
                    echo $this->Html->tag('td', $keyval);
                    $active = false;
                    $inactive = false;
                    if($offlineAccounts[$key][$keyval]=='Y') {
                        $active="checked";
                        $checkedclass="checkclass-js";
                        $uncheckedclass="uncheckclass-js";
                    } else {
                        $inactive="checked";
                        $checkedclass="uncheckclass-js";
                        $uncheckedclass="checkclass-js";
                    }

                    echo $this->Html->tag('td', $this->form->radio('accessradio'.$key.$keyac,array($keyval=>''),array('legend' => false,"checked"=>$active,"class"=>'activechecked-js')),array('class'=>'centertext'));
                    echo $this->Html->tag('td', $this->form->radio('accessradio'.$key.$keyac,array($keyval=>''),array('legend' => false,"checked"=>$inactive,"class"=>'inactivechecked-js')),array('class'=>'centertext'));
                    if($count == $rowspan) {
                        echo "</tr>";
                    } else {
                    echo "</tr><tr>";
                    }
                    $count++;
                }
            } else {
                echo "<td></td>";
                echo $this->Html->tag('td', '');
                echo $this->Html->tag('td', '');
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</div>";
//        echo '<center>' . $this->Html->div('col-sm-1 col-md-3 form-group', '', array('style' => 'margin-top:10px;')) . $addnew . '' . $reorder . '</center>';
    $tab = false;
    echo $this->Html->useTag('tagend', 'div'); //tab pane end

echo $this->Html->useTag('tagend', 'div'); //rightcontentdiv
echo $this->Html->useTag('tagend', 'div'); //row

echo $this->Html->useTag('tagend', 'div');


echo $this->Html->div('', NULL, array('id' => 'editDiv')); //edit div
$mainTab = 1; //
?>

<?php

echo "<div class='box-body'>"; //box body

$first = 1;
echo $this->Html->div('', null, array('id' => 'contentDiv', 'class' => 'tab-content')); // 5

echo $this->Html->useTag('tagend', 'div');

echo "</div>"; // end box body
echo $this->Html->useTag('tagend', 'div');

echo "</div>";
echo $this->Html->useTag('tagend', 'div'); ///edit div end


echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');


?>
<style>
    .centertext{ text-align: center;}
    .alert {line-height: 0px;margin-bottom: -10px;text-align: center;}
    .tools{margin-right: 10px;display: none;}
    a {color: white;}
    .table th{background-color: #2b3b55; border-bottom: 1px solid;color:#fff;}
    @media(max-width:766px){.left{height: auto;}}

    .headDiv,.headrightDiv { line-height: 40px;/*background-color: rgb(0, 173, 239);*/;font-weight: bold;color:#2b3b55;}
    .headDiv{margin-bottom: 40px;}
    .myDragClass {background-color: #17c4bb;font-size: 16pt;}
    .nav-tabs-justified > li > a {border-radius:0px;}
    .new,.new1 {background: none; border: none;width: 68px;text-align: center;}
    .table-responsive { overflow-y: auto;overflow-x: auto;}
    .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {border: 1px solid #c4d5d5;}
    .table th {background-color: #C0C0D3;border: 1px solid #f4f4f4;color: #515151;border-left: 1px solid;border-right: 1px solid; }
    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
        background-color: aliceblue;
        height: 48px;
    }
    .topmargin{
        margin-top: 9px;
        margin-right: 16px;
    }


</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";

    $(document).ready(function () {

        $('#updateaccessrights').click(function () {
            getRights();
            $('#offline_flag').val('actionsubmit');
            $('#form-offlinerights').submit();

        });

        if (sucmsg != '') {
            SuccMsgFun('provider', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('provider', msg);
        }
    });
    function getRights() {

        $(".activechecked-js").each(function () {
            var name = $(this).attr('name');
            var rthis = $('input[name="' + name + '"]:checked');
            if (rthis) {
                var currclass = rthis.attr('class');
                if (currclass == 'activechecked-js') {
                    var currval = $('#hiddencheckedrights').val();
                    var newval = currval == '' ? rthis.val() : currval + ',' + rthis.val();
                    $('#hiddencheckedrights').val(newval);
                } else if (currclass == 'inactivechecked-js') {
                    var currval = $('#hiddenuncheckedrights').val();
                    var newval = currval == '' ? rthis.val() : currval + ',' + rthis.val();
                    $('#hiddenuncheckedrights').val(newval);
                }
            }
            //alert(radioValue);
        });

    }

</script>