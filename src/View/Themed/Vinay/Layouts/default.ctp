<?php

echo $this->Html->docType('html5');
echo $this->Html->tag('html', null, array("lang" => "en"));
echo $this->Html->tag('head');
echo $this->Html->charset();
echo $this->Html->tag('title', \Configure::read('title'));
echo $this->Html->meta('icon', \Configure::read('icon'));
echo $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'));
echo $this->Html->meta(array('content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no', 'name' => 'viewport'));
echo $this->fetch('meta');
$theme = \Configure::read('theme');
echo $this->Html->css(array('bootstrap.min', 'theme.min', (empty($theme) ? 'skin-red-velvet.min' : $theme), 'font-awesome.min', 'ionicons.min', 'jquery-ui', 'newtheme/components.min', 'newtheme/layout.min', 'newtheme/blue.min', 'newtheme/timeline', 'newtheme/custom-checkbox'));
echo $this->fetch('css');
echo $this->Html->script(array('jquery-3.1.0.min', 'jquery-migrate-3.0.0.min', 'bootstrap.min', 'security.min', 'jquery.slimscroll.min', 'fastclick.min', 'theme.min', 'jquery-ui.min', 'jsvalidation'));
echo $this->fetch('script');
echo $this->Html->useTag('tagend', 'head');
echo $this->Html->tag('body  class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md"');

/* <div id="mydiv" class="ng-scope">
  <div class="page-spinner-bar">
  <div class="bounce1"></div>
  <div class="bounce2"></div>
  <div class="bounce3"></div>
  </div>
  </div> */


//echo $this->Html->div('loaderDiv', $this->Html->div('cssload-whirlpool', '') . $this->Html->div('loaderDivMsg', 'Please Wait...', array('id' => 'loaderDivMsg')), array('id' => 'loaderDiv'));

echo '<div id="loaderDiv" class="loaderDiv">
  <div class="page-spinner-bar">
  <div class="bounce1"></div>
  <div class="bounce2"></div>
  <div class="bounce3"></div>
  </div>
  </div>';

//echo $this->Html->div('loaderDiv', $this->Html->div('page-spinner-bar') . $this->Html->div('bounce1') . $this->Html->div('bounce2') . $this->Html->div('bounce3'), array('id' => 'loaderDiv'));
echo $this->Html->div('page-header navbar navbar-fixed-top');
echo $this->Html->div('page-header-inner main-header no-print');
echo $this->Html->div('page-logo');
echo $this->Form->create('showdashboard', array("id" => "form-showdashboard", "url" => array('controller'=>'pwBoPayment','action'=>'home'), "autocomplete" => "off"));
echo $this->Form->hidden("AuthVar", array("value" => $response["AuthVar"]));
$this->Form->unlockField("AuthVar");
echo $this->Form->input("dashboard_flag", array("label"=>false, "type"=>"hidden", 'id'=>'dashboard_flag',"value"=>""));
$this->Form->unlockField("dashboard_flag");
echo $this->Form->end();
echo $this->Html->link($this->Html->image(\Configure::read('logo'), array("alt" => "Logo", "style" => "width:auto;height:30px;margin: 19px 0 0 0;", 'class' => 'logo-default')), '#', array('escape' => false,'id'=>'logo-js'));
echo $this->Html->div('sidebar-toggle', '<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>', array("data-toggle" => "offcanvas", "role" => "button", "style" => "float:right; margin-top: 5px; font-size: 18px;"));
echo $this->Html->useTag('tagend', 'div');
?>
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><?php
    echo $this->Html->image(\Configure::read('toggle_logo'), array("Menu" => "Logo", "style" => "width:auto;height:18px;margin: -14px -8 0 0;", 'class' => 'logo-default'))
    ?></a>
<?php
echo $this->Html->div('page-top');
echo $this->Html->div('top-menu');
echo $this->Html->div("navbar-custom-menu pull-right", $this->elementExists('profile') ? $this->element('profile') : $this->element('menu_profile'));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('clearfix');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('page-container');
echo $this->Html->div('page-sidebar-wrapper');
echo $this->Html->tag('div', $this->elementExists('menu') ? $this->element('menu') : $this->element('menu_list'), array("class" => "page-sidebar navbar-collapse collapse"));
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('page-content-wrapper');
echo $this->Html->div('page-content');
echo $this->Html->div('row');
echo $this->Html->div('col-md-12');
echo $this->Html->div('portlet light portlet-fit');
echo $this->fetch('content');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->useTag('tagend', 'div');
$script = 'document.getElementById("loaderDiv").style.display="none";';
if (\Configure::read('disableHistory')) {
    $script .= 'history.pushState(null, null, null);window.addEventListener(\'popstate\', function () {history.pushState(null, null, null);});';
}
if (\Configure::read('debug') < 2) {
    if (\Configure::read('disableCut')) {
        $script .= 'document.body.addEventListener("cut",function(e){e.preventDefault();});';
    }
    if (\Configure::read('disableCopy')) {
        $script .= 'document.body.addEventListener("copy",function(e){e.preventDefault();});';
    }
    if (\Configure::read('disablePaste')) {
        $script .= 'document.body.addEventListener("paste",function(e){e.preventDefault();});';
    }
    if (\Configure::read('disableRightClick')) {
        $script .= 'document.oncontextmenu=document.body.oncontextmenu=function(){return false;};';
    }
}
$script .= '$(document).ready(function () {
        $("#loaderDiv").hide();
        $("form").on("submit", function () {
            $("#loaderDiv").show();
        });
        $("#logo-js").click(function () {
            $("#form-showdashboard").submit();
        });
    });';
echo $this->Html->tag('script', $script);
echo $this->Html->useTag('tagend', 'body');
echo $this->Html->useTag('tagend', 'html');
?>
<style>
    @media(max-width:991px){.sidebar-toggle{
                                display: none;
                            }}
    @media(min-width:990px){ .sub-menu{
                                 display: none !important;
                             }}
    /*    .page-header.navbar .menu-toggler.responsive-toggler {
            background-color: transparent;
            background-image: none;
            padding: 15px 15px;
            font-family: fontAwesome;}*/
    .menu-toggler.responsive-toggler {
        display: none;
        float: right;
        margin: 24px 14px 0 6px;
        background-image: url(../img/sidebar-toggler-inverse.png);
    }
</style>
