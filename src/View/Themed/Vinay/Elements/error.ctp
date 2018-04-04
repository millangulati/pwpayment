<?php

$authVar = class_exists('AuthComponent') ? AuthComponent::user('AuthToken') : '';
$act = empty($authVar) ? 'login' : 'home';
echo $this->Form->create('errorfrm', array('id'=>'errorfrm', 'method' => 'post', 'target' => '_self', 'url' => array('controller' => \Configure::read('masterController'), 'action' => $act)));
echo $this->Form->hidden('AuthVar', array('value' => $authVar));
echo $this->Form->end();

echo $this->Html->div('content');
echo $this->Html->tag('section', $this->Html->tag('h3', "You will be Redirect to " . ucfirst($act) . " after <span id='counter'>11</span> sec", array('class' => 'text-red text-center')));
echo $this->Html->tag('section', $this->fetch('content'));
echo $this->Html->useTag('tagend', 'content');
?>
<script>
$(function(){setTimeout(function(){$('#errorfrm').submit();},10000);});
	$('#counter').each(function () {
		$(this).prop('Counter', 0).animate({
			Counter: $(this).text()
		}, {
			duration: 12000,
			easing: 'swing',
			step: function (now) {
				$(this).text(11 - Math.ceil(now));
			}
		});
	});
</script>


