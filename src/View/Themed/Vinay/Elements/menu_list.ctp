<?php
$LayoutData = \class_exists('AuthComponent') ? AuthComponent::user('layoutData') : Array();
$menu = isset($LayoutData["menu"]) ? $LayoutData["menu"] : array();
$menuList = isset($LayoutData["menuData"]) ? $LayoutData["menuData"] : array();
$auth_var = \class_exists('AuthComponent') ? AuthComponent::user('AuthToken') : '';
echo '<ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu  page-sidebar-menu-closed">'; //sidebar-menu
foreach ($menu as $key => $val) {

    if (is_array($val)) {
        echo '<li class="treeview"><a href="#" class = "aasd" id="' . $key . '"><i class="' . $menuList[$key]['class'] . '"></i> <span class="title">' . $menuList[$key]['name'] . '</span></a>';
        listItems($val, $menuList, $this->Form, $auth_var, $key);
        echo "</li>";
    } else if (trim($val) != '') {
        //$b_url = $menuList[$key]['isnew'] ? "https://backoffice.payworld.co.in/beta/" : "https://backoffice.payworld.co.in/";
        $tmp = explode("/", $val);
        $contr = $tmp[0];
        $tmp = isset($tmp[1]) ? explode('?', $tmp[1]) : array('index');
        $act = $tmp[0];
        $activeClass = (!empty($this->params['action']) && ($this->params['action'] == $act) ) ? 'active' : 'inactive';
        $hfields = explode('&', "AuthVar=" . $auth_var . (isset($tmp[1]) ? ("&" . $tmp[1]) : ""));
        echo '<li class="nav-item ' . $activeClass . '">';
        echo $this->Form->create($act, array('method' => 'post', 'target' => '_self', 'url' => array("controller" => $contr, "action" => $act), 'name' => "menu_frm_" . $key, 'id' => "menu_frm_" . $key));
        //echo $this->Form->create($act, array('method' => 'post', 'target' => '_self', 'url' => $b_url . $contr . '/' . $act, 'name' => "menu_frm_" . $key, 'id' => "menu_frm_" . $key));
        foreach ($hfields as $kv) {
            list($n, $d) = explode('=', $kv);
            echo $this->Form->hidden($n, array('value' => $d));
        }
        echo $this->Form->end();
        echo '<a href="#" class="nav-link nav-toggle" onclick="$(\'#loaderDiv\').show();document.' . "menu_frm_" . $key . '.submit();"><i class="' . $menuList[$key]['class'] . '"></i> <span class="title">' . $menuList[$key]['name'] . '</span></a></li>';
    }
}
echo "</ul>";

function listItems($val, $menuList, $form, $auth_var, $key) {
    if (is_array($val)) {
        echo '<ul class="sub-menu ' . $key . '" >';
        foreach ($val AS $k => $v) {
            if (is_array($v)) {
                echo '<li class="nav-item "><a class="abc" href="#" onclick="return false;"><i class="' . $menuList[$k]['class'] . '"></i>' . $menuList[$k]['name'] . '<i class="fa fa-angle-left pull-right"></i></a>';
                listItems($v, $menuList, $form, $auth_var, $key);
                echo "</li>";
            } else {
                //$b_url = $menuList[$k]['isnew'] ? "https://backoffice.payworld.co.in/beta/" : "https://backoffice.payworld.co.in/";
                $tmp = explode("/", $v);
                $contr = $tmp[0];
                $tmp = isset($tmp[1]) ? explode('?', $tmp[1]) : array('index');
                $act = $tmp[0];
                $hfields = explode('&', "AuthVar=" . $auth_var . (isset($tmp[1]) ? ("&" . $tmp[1]) : ""));
                echo '<li>';
                echo $form->create($act, array('method' => 'post', 'target' => '_self', 'url' => array("controller" => $contr, "action" => $act), 'name' => "menu_frm_" . $k, 'id' => "menu_frm_" . $k));
                //echo $form->create($act, array('method' => 'post', 'target' => '_self', 'url' => $b_url . $contr . '/' . $act, 'name' => "menu_frm_" . $k, 'id' => "menu_frm_" . $k));
                foreach ($hfields as $kv) {
                    list($n, $d) = explode('=', $kv);
                    echo $form->hidden($n, array('value' => $d));
                }
                echo $form->end();
                echo '<a class="nav-link" href="#" onclick="$(\'#loaderDiv\').show();document.' . "menu_frm_" . $k . '.submit();"><i class="' . $menuList[$k]['class'] . '"></i> <span class="title">' . $menuList[$k]['name'] . '</span></a></li>';
            }
        }
        echo "</ul>";
    }
}
?>
<style>
    /*    @media(min-width:992px){ .sub-menu{
                                     display: none;
                                 }}*/
</style>
<script>
    $(".sub-menu").hide();
    $('li.treeview a').click(function () {
        var id = $(this).attr('id');
        var chk = $(".sub-menu." + id).is(':visible');
        $(".sub-menu").hide();
        $(".sub-menu." + id).show();
        if (chk == true) {
            $(".sub-menu").hide();
        }
    });
</script>