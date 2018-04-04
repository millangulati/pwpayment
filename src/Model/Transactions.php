<?php

App::uses('AppModel', 'Model');

class Transactions
        extends AppModel {

    public $useTable = 'transactions';
    public $primaryKey = 'transaction_no';

}
