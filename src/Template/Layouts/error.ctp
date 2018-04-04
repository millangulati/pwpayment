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
echo $this->Html->css('cake.generic');
echo $this->fetch('css');
echo $this->fetch('script');
echo $this->Html->useTag('tagend', 'head');
echo $this->Html->tag('body');
echo $this->Html->div('', null, array('id' => 'container'));
echo $this->Html->div('', $this->Html->link(\Configure::read('title'), array('controller' => \Configure::read('masterController'), 'action' => 'index')), array('id' => 'header'));
echo $this->Html->div('', null, array('id' => 'content'));
echo $this->Session->flash();
echo $this->fetch('content');
echo $this->Html->useTag('tagend', 'div');
echo $this->Html->div('', __d('cake_dev', 'CakePHP %s', Configure::version()), array('id' => 'footer'));
echo $this->Html->useTag('tagend', 'div');
$script = '';
if (\Configure::read('disableHistory')) {
	$script .= 'history.pushState(null, null, null);window.addEventListener(\'popstate\', function () {history.pushState(null, null, null);});';
}
if (\Configure::read('debug') < 2) {
	echo $this->element('sql_dump');
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
echo $this->Html->tag('script', $script);
echo $this->Html->useTag('tagend', 'body');
echo $this->Html->useTag('tagend', 'html');
