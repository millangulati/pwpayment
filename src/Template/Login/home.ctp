<?php

echo $this->Html->script('highcharts');
$total_agent_count_mode_type = isset($response["total_agent_count_mode_type"]) ? $response["total_agent_count_mode_type"] : "";
$total_retailer_count_mode_type = isset($response["total_retailer_count_mode_type"]) ? $response["total_retailer_count_mode_type"] : "";

$agent_request_mode_graph = isset($response["agent_request_mode_graph"]) ? $response["agent_request_mode_graph"] : "";
$retailer_request_mode_graph = isset($response["retailer_request_mode_graph"]) ? $response["retailer_request_mode_graph"] : "";

$agent_olp_mode_graph = isset($response["agent_olp_mode_graph"]) ? $response["agent_olp_mode_graph"] : "";
$retailer_olp_mode_graph = isset($response["retailer_olp_mode_graph"]) ? $response["retailer_olp_mode_graph"] : "";


$agent_ecollect_mode_graph = isset($response["agent_ecollect_mode_graph"]) ? $response["agent_ecollect_mode_graph"] : "";
$retailer_ecollect_mode_graph = isset($response["retailer_ecollect_mode_graph"]) ? $response["retailer_ecollect_mode_graph"] : "";
$request_status = array('<b>Total</b>'=>'Total','Grant'=>'GRANTED','Authenticate'=>'AUTHENTICATED','Revoke'=>'REVOKED','Pending'=>'PENDING');

echo $this->Form->create('showreports', array("id" => "form-showreports", "url" => array('controller'=>'pwBoReports','action'=>'reports'), "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->input("showreports_flag", array("label"=>false, "type"=>"hidden", 'id'=>'showreports_flag',"value"=>""));
$this->Form->unlockField("showreports_flag");
echo $this->Form->input("filter_data", array("label"=>false, "type"=>"hidden", 'id'=>'filter_data',"value"=>""));
$this->Form->unlockField("filter_data");
echo $this->Form->end();
?>

<div class="portlet light portlet-fit ">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-tachometer font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">Dashboard</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12 margin-bottom-25">
                <div class="portlet-title margin-bottom-25">
                    <div class="caption">
                        <i class="fa fa-user font-green-sharp"></i>
                        <span class="caption-subject bold uppercase font-green-haze">Agent</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat green" data-attr="agent,request">
                            <div class="visual">
                                <i class="fa fa-files-o"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">Request</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_agent_count_mode_type['REQUEST'][$value]['count']) ? $total_agent_count_mode_type['REQUEST'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat blue" data-attr="agent,payment">
                            <div class="visual">
                                <i class="fa fa-credit-card"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">OLP</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_agent_count_mode_type['PAYMENT'][$value]['count']) ? $total_agent_count_mode_type['PAYMENT'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat lightblue" data-attr="agent,collect">
                            <div class="visual">
                                <i class="fa fa-caret-square-o-right"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">E-Collect</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_agent_count_mode_type['COLLECT'][$value]['count']) ? $total_agent_count_mode_type['COLLECT'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12 margin-bottom-25">
                <ul class="nav nav-tabs">
                    <li class="ta active">
                        <a aria-expanded="true" href="#tab_request" data-toggle="tab">Request</a>
                    </li>
                    <li class="ta">
                        <a aria-expanded="false" href="#tab_payment" data-toggle="tab">OLP</a>
                    </li>
                    <li class="ta">
                        <a aria-expanded="false" href="#tab_ecollect" data-toggle="tab">E-Collect</a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body-js portlet-body">
                <div class='tab-content'>
                    <div id='tab_request' class='tab-pane active'>
                        <div class="col-md-12 margin-bottom-25">
                            <div class="col-md-6 margin-bottom-25">
                                <div id="agentrequestcontainer" class='graph_dashboard'></div>
                            </div>
                            <div class="col-md-6 margin-bottom-25">
                                <div id="retailerrequestcontainer" class='graph_dashboard'></div>
                            </div>
                        </div>
                    </div>
                    <div id='tab_payment' class='tab-pane'>
                        <div class="col-md-12 margin-bottom-25">
                            <div class="col-md-6 margin-bottom-25">
                                <div id="agentolpcontainer" class='graph_dashboard'></div>
                            </div>
                            <div class="col-md-6 margin-bottom-25">
                                <div id="retailerolpcontainer" class='graph_dashboard'></div>
                            </div>
                        </div>
                    </div>
                    <div id='tab_ecollect' class='tab-pane'>
                        <div class="col-md-12 margin-bottom-25">
                            <div class="col-md-6 margin-bottom-25">
                                <div id="agentecollectcontainer" class='graph_dashboard'></div>
                            </div>
                            <div class="col-md-6 margin-bottom-25">
                                <div id="retailerecollectcontainer" class='graph_dashboard'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-25">
                <div class="portlet-title margin-bottom-25">
                    <div class="caption">
                        <i class="fa fa-user font-green-sharp"></i>
                        <span class="caption-subject bold uppercase font-green-haze">Retailer</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat green" data-attr="retailer,request">
                            <div class="visual">
                                <i class="fa fa-files-o"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">Request</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_retailer_count_mode_type['REQUEST'][$value]['count']) ? $total_retailer_count_mode_type['REQUEST'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat blue" data-attr="retailer,payment">
                            <div class="visual">
                                <i class="fa fa-credit-card"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">OLP</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_retailer_count_mode_type['PAYMENT'][$value]['count']) ? $total_retailer_count_mode_type['PAYMENT'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 margin-bottom-25">
                        <div class="dashboard-stat lightblue" data-attr="retailer,collect">
                            <div class="visual">
                                <i class="fa fa-caret-square-o-right"></i>
                            </div>
                            <div class="details">
                                <div class="number ng-binding">E-Collect</div>
                                <?php
                                    foreach($request_status as $key=>$value) {
                                        $finalcount = isset($total_retailer_count_mode_type['COLLECT'][$value]['count']) ? $total_retailer_count_mode_type['COLLECT'][$value]['count'] : '0';
                                ?>
                                <div class="desc"><?php echo $key." - ".$finalcount; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--                        <div class="col-md-6">
                                        <div class="portlet-title margin-bottom-25">
                                            <div class="caption">
                                                <i class="fa fa-navicon font-green-sharp"></i>
                                                <span class="caption-subject bold uppercase font-green-haze"> Week wise Revenue</span>
                                            </div>
                                        </div>
                                        <div class="portlet light ">
                                            <div class="portlet-body">
                                                <div id="chart_4" class="chart"> </div>
                                            </div>
                                        </div>
                                    </div>-->
        </div>
    </div>
</div>

<!--<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart font-green-haze"></i>
            <span class="caption-subject bold uppercase font-green-haze"> Service</span>
        </div>
    </div>
    <div class="portlet-body">
        <div id="chartdiv" class="chart" style="height: 500px; overflow: hidden; text-align: left;"><div style="position: relative;" class="amcharts-main-div"><div style="overflow: hidden; position: relative; text-align: left; width: 1076px; height: 500px; padding: 0px; cursor: default;" class="amcharts-chart-div"><svg version="1.1" style="position: absolute; width: 1076px; height: 500px; top: 0.150024px; left: 0px;"><desc>JavaScript chart by amCharts 3.17.1</desc><g><path cs="100,100" d="M0.5,0.5 L1075.5,0.5 L1075.5,499.5 L0.5,499.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0"></path><path cs="100,100" d="M0.5,0.5 L905.5,0.5 L905.5,469.5 L0.5,469.5 L0.5,0.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(100,20)"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g><g><text y="6" fill="#000000" font-family="Verdana" font-size="11px" opacity="1" font-weight="bold" text-anchor="middle" transform="translate(10,256) rotate(270)" style="pointer-events: none;"><tspan y="6" x="0">Service wise retailers count</tspan></text></g></g><g></g><g></g><g></g></svg><a href="http://www.amcharts.com/javascript-charts/" title="JavaScript charts" style="position: absolute; text-decoration: none; color: rgb(0, 0, 0); font-family: Verdana; font-size: 11px; opacity: 0.7; display: block; left: 105px; top: 25px;">JS chart by amCharts</a></div></div></div>
    </div>
</div>-->
<!--<div class="row">
    <div class="col-md-6">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Daily Revenue</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_5" class="chart" style="overflow: hidden; text-align: left;"><div style="position: relative;" class="amcharts-main-div"><div style="overflow: hidden; position: relative; text-align: left; width: 504px; height: 300px; padding: 0px; cursor: default;" class="amcharts-chart-div"><svg version="1.1" style="position: absolute; width: 504px; height: 300px; top: 0.150024px; left: 0px;"><desc>JavaScript chart by amCharts 3.17.1</desc><g><path cs="100,100" d="M0.5,0.5 L503.5,0.5 L503.5,299.5 L0.5,299.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0"></path><path cs="100,100" d="M0.5,0.5 L448.5,0.5 L448.5,249.5 L0.5,249.5 L0.5,0.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(35,20)"></path><path cs="100,100" d="M0.5,0.5 L35.5,-19.5 L483.5,-19.5 L448.5,0.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,289)"></path><path cs="100,100" d="M0.5,0.5 L0.5,249.5 L35.5,229.5 L35.5,-19.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,40)"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g><g></g></g><g></g><g></g><g></g></svg><a href="http://www.amcharts.com/javascript-charts/" title="JavaScript charts" style="position: absolute; text-decoration: none; color: rgb(136, 136, 136); font-family: Open Sans; font-size: 11px; opacity: 0.7; display: block; left: 5px; top: 45px;">JS chart by amCharts</a></div></div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Monthly Revenue</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_3" class="chart" style="overflow: hidden; text-align: left;"><div style="position: relative;" class="amcharts-main-div"><div style="overflow: hidden; position: relative; text-align: left; width: 217px; height: 300px; padding: 0px;" class="amcharts-chart-div"><svg version="1.1" style="position: absolute; width: 217px; height: 300px; top: 0.150024px; left: 0px;"><desc>JavaScript chart by amCharts 3.17.1</desc><g><path cs="100,100" d="M0.5,0.5 L216.5,0.5 L216.5,299.5 L0.5,299.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0"></path><path cs="100,100" d="M0.5,0.5 L161.5,0.5 L161.5,249.5 L0.5,249.5 L0.5,0.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(35,20)"></path><path cs="100,100" d="M0.5,0.5 L35.5,-19.5 L196.5,-19.5 L161.5,0.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,289)"></path><path cs="100,100" d="M0.5,0.5 L0.5,249.5 L35.5,229.5 L35.5,-19.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,40)"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g><g></g></g><g></g><g></g><g></g></svg><a href="http://www.amcharts.com/javascript-charts/" title="JavaScript charts" style="position: absolute; text-decoration: none; color: rgb(136, 136, 136); font-family: Open Sans; font-size: 11px; opacity: 0.7; display: block; left: 5px; top: 45px;">JS chart by amCharts</a></div></div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-haze"></i>
                    <span class="caption-subject bold uppercase font-green-haze"> Yearly Revenue</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_2" class="chart" style="overflow: hidden; text-align: left;"><div style="position: relative;" class="amcharts-main-div"><div style="overflow: hidden; position: relative; text-align: left; width: 217px; height: 300px; padding: 0px;" class="amcharts-chart-div"><svg version="1.1" style="position: absolute; width: 217px; height: 300px; top: 0.150024px; left: 0px;"><desc>JavaScript chart by amCharts 3.17.1</desc><g><path cs="100,100" d="M0.5,0.5 L216.5,0.5 L216.5,299.5 L0.5,299.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0"></path><path cs="100,100" d="M0.5,0.5 L161.5,0.5 L161.5,249.5 L0.5,249.5 L0.5,0.5 Z" fill="#FFFFFF" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(35,20)"></path><path cs="100,100" d="M0.5,0.5 L35.5,-19.5 L196.5,-19.5 L161.5,0.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,289)"></path><path cs="100,100" d="M0.5,0.5 L0.5,249.5 L35.5,229.5 L35.5,-19.5 L0.5,0.5 Z" fill="#d9d9d9" stroke="#000000" fill-opacity="0" stroke-width="1" stroke-opacity="0" transform="translate(0,40)"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g><g></g></g><g></g><g></g><g></g></svg><a href="http://www.amcharts.com/javascript-charts/" title="JavaScript charts" style="position: absolute; text-decoration: none; color: rgb(136, 136, 136); font-family: Open Sans; font-size: 11px; opacity: 0.7; display: block; left: 5px; top: 45px;">JS chart by amCharts</a></div></div></div>
            </div>
        </div>
    </div>
</div>-->
<style>
    .graph_dashboard {
        min-width: 509px;
        height: 400px;
        margin: 0 auto;
    }
    .dashboard-stat {
        cursor: pointer;
    }
    .dashboard-stat .details {
        position: inherit;
        padding-bottom: 10px;
    }
    .dashboard-stat .details .number{
        padding-top: 13px;
        margin-bottom: 10px;
    }
    .dashboard-stat.lightblue {
        background-color: #5dc0e1;
    }
    .dashboard-stat.lightblue .visual > i {
        color: #FFF;
        opacity: .1;
        filter: alpha(opacity=10);
    }
    .dashboard-stat.lightblue .details .number {
        color: #FFF;
    }
    .dashboard-stat.lightblue .details .desc {
        color: #FFF;
        opacity: 1;
        filter: alpha(opacity=100);
    }
    /*.nav-tabs { background: none;margin: 0;float: left;display: inline-block;border: 0;}
    .nav-tabs > li {background: none;margin: 0; border: 0;}
    .nav-tabs > li > a {background: none;border: 0;padding: 2px 10px 13px;color: #444;}
    .nav-tabs > li.active,
    .nav-tabs > li.active:hover { border-bottom: 4px solid #f3565d;position: relative; }
    .nav-tabs > li:hover {border-bottom: 4px solid #f29b9f;}
    .nav-tabs > li.active > a,
    .nav-tabs > li:hover > a {color: #333; background: #fff;border: 0;}
    */
</style>
<script>
    $(document).ready(function () {
        $('.dashboard-stat').click(function () {

            var data_attr = $(this).attr('data-attr');
            $('#showreports_flag').val('show_reports');
            $('#filter_data').val(data_attr);
            $('#form-showreports').submit();

        });

    });
</script>
<script>

    var AgentRequestGraph = '<?= $agent_request_mode_graph ?>';
    var AgentRequestGraphStr = JSON.parse(AgentRequestGraph);
    var RetailerRequestGraph = '<?= $retailer_request_mode_graph ?>';
    var RetailerRequestGraphStr = JSON.parse(RetailerRequestGraph);
    var AgentOlpGraph = '<?= $agent_olp_mode_graph ?>';
    var AgentOlpGraphStr = JSON.parse(AgentOlpGraph);
    var RetailerOlpGraph = '<?= $retailer_olp_mode_graph ?>';
    var RetailerOlpGraphStr = JSON.parse(RetailerOlpGraph);
    var AgentEcollectGraph = '<?= $agent_ecollect_mode_graph ?>';
    var AgentEcollectGraphStr = JSON.parse(AgentEcollectGraph);
    var RetailerEcollectGraph = '<?= $retailer_ecollect_mode_graph ?>';
    var RetailerEcollectGraphStr = JSON.parse(RetailerEcollectGraph);
    var dirlldown = [];
    var cData = [];
    var cDataRetailer = [];
    var cDataolp = [];
    var cDataolpRetailer = [];
    var cDataecollect = [];
    var cDataecollectRetailer = [];
    var totalamt = 0;

    $.each(AgentRequestGraphStr, function (i, row) {
        cData.push({
            name: row["name"],
            y: row["amt"]
        });
    });
    $.each(RetailerRequestGraphStr, function (i, row) {
        cDataRetailer.push({
            name: row["name"],
            y: row["amt"]
        });
    });
    $.each(AgentOlpGraphStr, function (i, row) {
        cDataolp.push({
            name: row["name"],
            y: row["amt"]
        });
    });
    $.each(RetailerOlpGraphStr, function (i, row) {
        cDataolpRetailer.push({
            name: row["name"],
            y: row["amt"]
        });
    });
    $.each(AgentEcollectGraphStr, function (i, row) {
        cDataecollect.push({
            name: row["name"],
            y: row["amt"]
        });
    });
    $.each(RetailerEcollectGraphStr, function (i, row) {
        cDataecollectRetailer.push({
            name: row["name"],
            y: row["amt"]
        });
    });

    Highcharts.chart('agentrequestcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Agent - Request Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cData
            }]

    });

    Highcharts.chart('retailerrequestcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Retailer - Request Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cDataRetailer
            }]

    });

    Highcharts.chart('agentolpcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Agent - OLP Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cDataolp
            }]

    });

    Highcharts.chart('retailerolpcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Retailer - OLP Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cDataolpRetailer
            }]

    });

    Highcharts.chart('agentecollectcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Agent - OLP Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cDataecollect
            }]

    });

    Highcharts.chart('retailerecollectcontainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Retailer - OLP Payment Mode'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Amount'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [{
                name: 'Modes',
                colorByPoint: true,
                data: cDataecollectRetailer
            }]

    });

</script>