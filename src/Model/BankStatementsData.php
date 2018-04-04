<?php

App::uses('AppModel', 'Model');

/**
 * Description of BankMaster
 *
 * @author vinay
 */
class BankStatementsData
        extends AppModel {

    public $useTable = 'bank_statements';
    public $primaryKey = 'serno';

    public function updateStatementRequest($statementno) {
        $this->updateAll(
                array('flag_auth' => "'Y'", 'auth_date' => "'" . date('Y-m-d H:i:s') . "'"), array('serno' => $statementno)
        );
    }

}
