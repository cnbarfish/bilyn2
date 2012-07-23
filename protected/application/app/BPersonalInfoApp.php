<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BPersonalInfo
 *
 * @author jianfeng
 */
class BPersonalInfoApp extends BServiceApp {

    public function addRolesToService($service) {
        
    }

    public function checkAccess($operation, $role) {
        
    }

    public function getOperations($role) {
        
    }    

    public function registerAppMeta() {
        $meta['appname'] = 'My Info';
        $meta['description'] = 'Description of BPersonalInfoApp';
        return $meta;
    }

    public function registerAppRoles() {
        
    }

    public function updateApp() {
        
    }

   

}

?>
