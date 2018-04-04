<?php

$SuccessMessage = isset($response["successmsg"]) ? $response["successmsg"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
echo $this->Html->script('jquery.dataTables.min');
echo $this->Html->css('jquery.dataTables.min');
$reportData = isset($response['reportData']) ? $response['reportData'] : '';
$header = array("Branch", "Date", "Agent", "Mode", "Bank Name", "Branch Code", "Cheque No.", "Amount","Deposit Date");
$header_value = array("branch_id", "dateval", "countercode", "mode_id", "bankid", "deposit_branch_code", "chequeno", "amount","deposit_date");
?>
<div class="portlet light portlet-fit ">
    <div id='msgDiv' class=''>&nbsp;</div>
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-tachometer font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">Reports</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <!--<div class="col-md-12">
                <div class="col-sm-3 col-md-3" id="toolbar">
                    <select class="form-control">
                        <option value="">Export Basic</option>
                        <option value="all">Export All</option>
                        <option value="selected">Export Selected</option>
                    </select>
                </div>
            </div>-->
                        <!--<table cellspacing="5" cellpadding="5" border="0">
                            <tbody><tr>
                                    <td>Minimum age:</td>
                                    <td><input id="min" name="min" type="text"></td>
                                </tr>
                                <tr>
                                    <td>Maximum age:</td>
                                    <td><input id="max" name="max" type="text"></td>
                                </tr>
                            </tbody></table>-->
            <div class="form-group col-md-12">
                <table class="table-responsive" id="example">
                    <thead>
                        <tr>
                        <?php
                        foreach($header as $key){
                            echo "<th>".ucwords(str_replace("_", " ", $key))."</th>";
                        }
                        ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($reportData as $row) {
                            echo "<tr>";
                            foreach($header_value as $key){
                                echo "<td>".$row[$key]."</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .alert {line-height: 0px;margin-bottom: -10px; text-align: center;}
</style>
<script>
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    $(document).ready(function () {

        $("#example").dataTable();
        if (sucmsg != '') {
            SuccMsgFun('msgDiv', sucmsg);
        }
        if (msg != '') {
            $('#paymentmode').val('');
            $('#branch').val('');
            ErrorMsgFun('msgDiv', msg);
        }
    });
</script>