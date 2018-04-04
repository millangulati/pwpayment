<?php

echo $this->Html->docType('html5');
echo $this->Html->tag('html', null, array("lang" => "en"));
echo $this->Html->tag('head');
echo $this->Html->charset();
echo $this->Html->tag('title', \Configure::read('title'));
echo $this->Html->meta('icon', \Configure::read('icon'));
echo $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'));
echo $this->Html->meta(array('content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no', 'name' => 'viewport'));
$theme = \Configure::read('theme');
echo $this->Html->css(array('bootstrap.min', 'theme.min', (empty($theme) ? 'skin-red-velvet.min' : $theme), 'font-awesome.min', 'ionicons.min'));
echo $this->Html->script(array('jquery-3.1.0.min', 'jquery-migrate-3.0.0.min', 'bootstrap.min', 'security.min'));
echo $this->Html->useTag('tagend', 'head');
echo $this->Html->tag('body', null, array('class' => 'hold-transition'));
echo $this->Html->div('loaderDiv', $this->Html->div('cssload-whirlpool', '') . $this->Html->div('loaderDivMsg', 'Please Wait...', array('id' => 'loaderDivMsg')), array('id' => 'loaderDiv'));
echo $this->element('error');//Error Element
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
$script .= '$(document).ready(function(){ $("#loaderDiv").hide(); $("form").on("submit",function(){ $("#loaderDiv").show();});});';
echo $this->Html->tag('script', $script);
echo $this->Html->useTag('tagend', 'body');
echo $this->Html->useTag('tagend', 'html');
