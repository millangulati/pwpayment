<?php
//pr($response['menuinformation']);
//pr($response['currentmenuaccess']);
//pr($response['menuaccessloggedin']);
echo $this->Html->script('jquery-checktree');
$stateList = isset($response["stateList"]) ? $response["stateList"] : array();
$paymentModeList = isset($response["paymentMode"]) ? $response["paymentMode"] : array();
$baseurl = $this->Html->url(array('controller' => 'getJson'), true);
$SuccessMessage = isset($response["successmsg"]) ? $response["successmsg"] : "";
$errorMessage = isset($response["msg"]) ? $response["msg"] : "";
echo "<div id='msgDiv' class=''>&nbsp</div>";
echo $this->Html->div('portlet-title');
echo $this->Html->div('caption');
echo '<i class="fa fa-universal-access font-green-sharp"></i>';
echo $this->Html->tag('span', 'Menu Access Rights', array('id' => 'spanhead', 'class' => 'caption-subject font-green-sharp bold uppercase'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');  // title

echo $this->Html->div('portlet-body'); // portlet-body
//echo $this->Html->div("msgDiv style18", isset($msg) ? $msg : '&nbsp', array("id" => "msgDiv", "style" => "width:90%;text-align:center;color:red;margin-top: -11px;;font-size: 16px"));
//echo $this->Html->div('tab-content'); //tab-content
echo $this->Html->div('row'); //1-row
echo $this->Html->div("col-md-12 col-xs-12 col-sm-12", NULL, array("id" => "portlet_add"));
echo $this->Form->create('userRights', array("id" => "userRights", "target" => "_self", "autocomplete" => "off"));
echo $this->Form->input("AuthVar", array('id' => 'auth', "type" => "hidden", "class" => "nochange", "value" => $response["AuthVar"]));
echo $this->Html->div("row", NULL, array("id" => "searchAccessRight"));
echo $this->Html->div('col-sm-2 col-md-2', $this->Form->label('loginName', 'Login Name', array('style' => 'padding-left:0px;')));
echo $this->Form->input('selectLoginName', array("id" => "loginname", "label" => FALSE, 'div' => array('class' => 'col-md-3 col-sm-4 form-group'), 'value' => $response['loginname'], "class" => "form-control"));
echo $this->Html->div('col-sm-2 col-md-2');
echo $this->Form->button('Go', array('id' => 'btnsearchlogin', 'type' => 'button', 'class' => 'btn green form-control', 'onclick' => 'return validateLoginName();', 'style' => 'margin-bottom:20px;'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Form->end();
echo $this->Html->useTag('tagend', 'div'); //portlet_add

if (!empty($response['userInformation']) && is_array($response['userInformation'])) {
    echo $this->Html->div('col-md-12 col-xs-12 col-sm-12', NULL, array('id' => 'btnDiv')); //btndiv
    echo $this->Html->div('form-body');
    echo $this->Html->div('panel-group');
    echo $this->Html->div('panel panel-default');
    echo $this->Html->div('panel-heading cursor');
    echo $this->Html->tag('h4', 'User Details', array('class' => 'panel-title'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('panel-collapse in');
    echo $this->Html->div('panel-body');
    echo $this->Html->div('row');
    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('userCode', 'User Code:');
    echo $this->Html->tag('span', $response['userInformation']['Usercode'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('userName', 'User Name:');
    echo $this->Html->tag('span', $response['userInformation']['Username'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('phoneNumber', 'Phone Number:');
    echo $this->Html->tag('span', $response['userInformation']['Phone'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('col-md-4');
    echo $this->Html->div('form-group');
    echo $this->Form->label('email', 'Email id:');
    echo $this->Html->tag('span', $response['userInformation']['EmailId'], array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('col-md-8');
    echo $this->Html->div('form-group');
    echo $this->Form->label('states', 'States:', array('style' => 'float:left;'));
    echo $this->Html->tag('span', $this->Html->div('col-md-10 no-padding', $response['userInformation']['States'], array('style' => 'margin-top:4px;float:left;')), array('class' => 'strong'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');

    echo $this->Html->useTag('tagend', 'div');
    echo "<hr>";
    echo $this->Html->div('panel panel-default');
    echo $this->Html->div('panel-heading cursor');
    echo $this->Html->tag('h4', 'Access Rights', array('class' => 'panel-title'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('panel-collapse in');
    echo $this->Html->div('panel-body');
    echo $this->Form->create('menuAccessRights', array("id" => "menuAccessRights", "target" => "_self", "autocomplete" => "off"));
    echo $this->Form->input("AuthVar", array("type" => "hidden", "class" => "nochange", "value" => $response["AuthVar"]));
    echo $this->Form->unlockField('AuthVar');
    echo $this->Html->div('row');
    echo displayMenuData($response['menuinformation'], $this->Form, $response); // show all menu rights in ul-li
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->div('form-actions');
    echo $this->Form->input('hiddenusercode', array("id" => "hiddenusercode", "type" => "hidden", 'value' => $response['userInformation']['Usercode']));
    echo $this->Form->unlockField('hiddenusercode');
    echo $this->Form->input('hiddenloginname', array("id" => "hiddenloginname", "type" => "hidden", 'value' => $response['userInformation']['Loginname']));
    echo $this->Form->unlockField('hiddenloginname');
    echo $this->Form->input('hiddencheckedmenucodes', array("id" => "hiddencheckedmenucodes", "type" => "hidden", 'value' => ''));
    echo $this->Form->unlockField('hiddencheckedmenucodes');
    echo $this->Form->input('hiddenuncheckedmenucodes', array("id" => "hiddenuncheckedmenucodes", "type" => "hidden", 'value' => ''));
    echo $this->Form->unlockField('hiddenuncheckedmenucodes');
    echo $this->Form->button('Update Access Rights', array('id' => 'btnSaveMenuInformation', 'type' => 'button', 'class' => 'btn green', 'onclick' => 'return saveUpdatedMenu();'));
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Form->end();
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
    echo $this->Html->useTag('tagend', 'div');
}
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div'); // portlet body end

function displayMenuData($LayoutData, $form, $response) {

    $menu = isset($LayoutData["menu"]) ? $LayoutData["menu"] : array();
    $menuList = isset($LayoutData["menuData"]) ? $LayoutData["menuData"] : array();
    $auth_var = \class_exists('AuthComponent') ? AuthComponent::user('AuthToken') : '';
    $totalmenulenth = count($menu, COUNT_RECURSIVE);
    $checkmenulength = count($response['currentmenuaccess']);
    $allchecked = $totalmenulenth == $checkmenulength ? true : false;
    $displaydata = '<ul id="tree" class="checktree-root">'; //sidebar-menu
    $displaydata .= '<li><div class="checkbox checkbox-primary">';
    $displaydata .= $form->checkbox('menucodes', array('id' => 'menucodeall', 'value' => 'all', 'class' => 'all_chk', 'checked' => $allchecked));
    $displaydata .= '<label for="menucodeall">All</label></div>';
    $displaydata .= "<ul>";
    foreach ($menu as $key => $val) {
        if (is_array($val)) {
            $displaydata .= '<li><div class="checkbox checkbox-primary">';
            $displaydata .= $form->checkbox('menucodes', array('id' => 'menucode' . $key, 'value' => $key, 'class' => 'menurights-js', 'checked' => (in_array($key, $response['currentmenuaccess']) ? true : false), 'disabled' => (in_array($key, $response['menuaccessloggedin']) ? false : true)));
            $displaydata .= '<label for="menucode' . $key . '">' . $menuList[$key]['name'] . '</label></div>';
            $displaydata .= listMenuItems($val, $menuList, $form, $auth_var, $response);
            $displaydata .= "</li>";
        } else if (trim($val) != '') {
            $displaydata .= '<li><div class="checkbox checkbox-primary">';
            $displaydata .= $form->checkbox('menucodes', array('id' => 'menucode' . $key, 'value' => $key, 'class' => 'menurights-js', 'checked' => (in_array($key, $response['currentmenuaccess']) ? true : false), 'disabled' => (in_array($key, $response['menuaccessloggedin']) ? false : true)));
            $displaydata .= '<label for="menucode' . $key . '">' . $menuList[$key]['name'] . '</label></div></li>';
        }
    }
    $displaydata .= "</ul></li></ul>";
    return $displaydata;
}

function listMenuItems($val, $menuList, $form, $auth_var, $response) {
    if (is_array($val)) {
        $displaydata = '<ul>';
        foreach ($val AS $k => $v) {
            if (is_array($v)) {
                $displaydata .= '<li><div class="checkbox checkbox-primary">';
                $displaydata .= $form->checkbox('menucodes', array('id' => 'menucode' . $k, 'value' => $k, 'class' => 'menurights-js', 'checked' => (in_array($k, $response['currentmenuaccess']) ? true : false), 'disabled' => (in_array($k, $response['menuaccessloggedin']) ? false : true)));
                $displaydata .= '<label for="menucode' . $k . '">' . $menuList[$k]['name'] . '</label></div>';
                $displaydata .= listMenuItems($v, $menuList, $form, $auth_var);
                $displaydata .= "</li>";
            } else {
                //$b_url = $menuList[$k]['isnew'] ? "https://backoffice.payworld.co.in/beta/" : "https://backoffice.payworld.co.in/";
                $displaydata .= '<li><div class="checkbox checkbox-primary">';
                $displaydata .= $form->checkbox('menucodes', array('id' => 'menucode' . $k, 'value' => $k, 'class' => 'menurights-js', 'checked' => (in_array($k, $response['currentmenuaccess']) ? true : false), 'disabled' => (in_array($k, $response['menuaccessloggedin']) ? false : true)));
                $displaydata .= '<label for="menucode' . $k . '">' . $menuList[$k]['name'] . '</label></div></li>';
            }
        }
        $displaydata .= "</ul>";
        return $displaydata;
    }
}
?>
<style>
    .strong {font-weight: bold;}
    /*.alert {line-height: 0px;margin-bottom: -10px; text-align: center;}*/
    .accordion .panel .panel-title .accordion-toggle {
        cursor: inherit !important;
    }
    .portlet-title > .nav-tabs { background: none;margin: 0;float: right;display: inline-block;border: 0;}
    .portlet-title > .nav-tabs > li {background: none;margin: 0; border: 0;}
    .portlet-title > .nav-tabs > li > a {background: none;border: 0;padding: 2px 10px 13px;color: #444;}
    .portlet-title > .nav-tabs > li.active,
    .portlet-title > .nav-tabs > li.active:hover { border-bottom: 4px solid #f3565d;position: relative; }
    .portlet-title > .nav-tabs > li:hover {border-bottom: 4px solid #f29b9f;}

    .portlet-title > .nav-tabs > li.active > a,
    .portlet-title > .nav-tabs > li:hover > a {color: #333; background: #fff;border: 0;}
    .table > thead > tr > th {border-bottom: 2px solid #f4f4f4;border-top: 2px solid #f4f4f4; }
    .alert {line-height: 3px;margin-bottom: -15px;}

</style>
<script>
    $('#tree').checktree();
    var baseurl = "<?= $baseurl ?>";
    var AuthVar = "<?= $response["AuthVar"] ?>";
    var sucmsg = "<?= $SuccessMessage ?>";
    var msg = "<?= $errorMessage ?>";
    $('#document').ready(function () {
        $("#loginname").click(function () {
            clearMsg();
        });

        if (sucmsg != '') {
            SuccMsgFun('msgDiv', sucmsg);
        }
        if (msg != '') {
            ErrorMsgFun('msgDiv', msg);
        }

    });
    function validateLoginName() {
        if ($("#loginname").val() == '') {
            return ErrorMsgFun('loginname', "Please enter login name.");
        } else {
            $('#userRights').submit();
        }

    }

    function saveUpdatedMenu() {
        getRights();
        $('#menuAccessRights').submit();
    }

    function getRights() {
        $(".menurights-js").each(function () {

            if ($(this).prop("checked") == true && !$(this).is(":disabled")) {
                var currval = $('#hiddencheckedmenucodes').val();
                var newval = currval == '' ? $(this).val() : currval + ',' + $(this).val();
                $('#hiddencheckedmenucodes').val(newval);

            } else if ($(this).prop("checked") == false && !$(this).is(":disabled")) {
                var currval = $('#hiddenuncheckedmenucodes').val();
                var newval = currval == '' ? $(this).val() : currval + ',' + $(this).val();
                $('#hiddenuncheckedmenucodes').val(newval);
            }

        });
    }
</script>
