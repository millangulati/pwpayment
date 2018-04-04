<?php
echo $this->Html->tag('h1', isset($response['code']) ? $response['code'] : "500", array('style' => 'color:red;text-align:center'));
echo $this->Html->tag('h5', isset($response['message']) ? $response['message'] : $message, array('style' => 'text-align:center'));
if (Configure::read('debug') > 0):
	echo $this->Html->para('error', sprintf(__d('cake', '%s : An Internal Error Has Occurred.'), $this->Html->tag('strong', 'Error', array('style' => 'color:red;'))), array('style' => 'text-align:center'));
	echo $this->element('exception_stack_trace');
endif;
