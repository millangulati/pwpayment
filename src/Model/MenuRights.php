<?php

App::uses('AppModel', 'Model');

class MenuRights
        extends AppModel {

    public $useTable = 'menu_rights';
    public $primaryKey = 'serno';

    function updateNewMenuAccessRights($newmenurights, $usercode, $newremovedmenurights, $menuaccessloggedin) {
        // below functionality is for checked checkboxes and set status to 'Y'
        if ($newmenurights != '') {
            $eachmenucode = explode(",", $newmenurights);
            for ($i = 0; $i < count($eachmenucode); $i++) {
                // ignore the disabled menu code id's
                if (in_array($eachmenucode[$i], $menuaccessloggedin)) {
                    // check menu information exists or not
                    $checkmenucode = $this->field('serno', array('menucode' => $eachmenucode[$i], 'usercode' => $usercode));
                    if ($checkmenucode) {
                        // update the existing information
                        $this->updateAll(
                                array('status' => "'Y'"), array('serno' => $checkmenucode)
                        );
                    } else {
                        // insert new menu access right with status 'Y'
                        $this->saveAll(array(
                            'usercode' => $usercode,
                            'menucode' => $eachmenucode[$i],
                            'status' => 'Y'
                        ));
                    }
                }
            }
        }

        // below functionality is for unchecked checkboxes and set status to 'N'
        /*
         * Below code will execute when any particular access right is revoked from entered user
         */
        if ($newremovedmenurights != '') {
            $eachmenucode_unchecked = explode(",", $newremovedmenurights);
            for ($i = 0; $i < count($eachmenucode_unchecked); $i++) {
                // ignore the disabled menu code id's
                if (in_array($eachmenucode_unchecked[$i], $menuaccessloggedin)) {
                    $checkmenucode = $this->field('serno', array('menucode' => $eachmenucode_unchecked[$i], 'usercode' => $usercode));
                    if ($checkmenucode) {
                        $this->updateAll(
                                array('status' => "'N'"), array('serno' => $checkmenucode)
                        );
                    }
                }
            }
        }
    }

}
