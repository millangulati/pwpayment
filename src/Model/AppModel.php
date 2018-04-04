<?php

App::uses('Model', 'Model');
App::uses('DateMethod', 'Lib');
App::uses('PwSpecialFun', 'Lib');

/**
 * Application model for Cake.
 *
 * @author vinay
 */
class AppModel extends Model {

    public function getData($conditions = array(), $fields = array("*"), $order = "", $group = "", $limit = 0) {
        $this->recursive = -1;
        $query = array("fields" => $fields);
        if (\is_array($conditions) && !empty($conditions)) {
            $query["conditions"] = $conditions;
        }
        if (!empty($order)) {
            $query["order"] = $order;
        }
        if (!empty($group)) {
            $query["group"] = $group;
        }
        if ($limit != 0) {
            $query["limit"] = $limit;
        }
        return $this->find("all", $query);
    }

}
