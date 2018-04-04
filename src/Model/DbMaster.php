<?php

class DbMaster extends AppModel {

//    public $useDbConfig = "payworld";
    public $useTable = 'db_master';
//    public $table = 'DbMaster';
    var $primaryKey = 'serno';
    public $validate = array(
        'state' => array(
            'required' => array(
                'rule' => array('blank', 'alphaNumeric'),
                'message' => 'Invalid State'
            )
        ),
        'brand' => array(
            'required' => array(
                'rule' => array('blank', 'alphaNumeric'),
                'message' => 'Invalid Brand'
            )
        )
    );

}

?>
