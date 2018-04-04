<?php

echo $this->Html->div("pull-right "/* hidden-xs */, "<strong>Ankan Verma</strong> (Copyright &copy; 2017-18)");
echo $this->Html->tag('a', $this->Html->tag('i', '', array('class' => 'fa fa-facebook')), array('class' => 'btn btn-xs btn-social-icon btn-facebook', 'target' => '_blank', 'href' => 'https://www.facebook.com'));
echo $this->Html->tag('a', $this->Html->tag('i', '', array('class' => 'fa fa-youtube-square')), array('class' => 'btn btn-xs btn-social-icon btn-google', 'target' => '_blank', 'href' => 'https://www.youtube.com'));
