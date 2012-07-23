<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BPersonalCircleApp
 *
 * @author jianfeng
 */
class BPersonalCircleApp extends BServiceApp {

    public function addRolesToService($service) {
        
    }

    public function checkAccess($operation, $role) {
        
    }

    public function getOperations($role) {
        
    }    

    public function registerAppMeta() {
        
        $meta = array();
        
        $meta['appname'] = 'My Circles';
        $meta['description']= 'Description of BPersonalCircleApp';
        
        return $meta;        
    }

    public function registerAppRoles() {
        
    }

    public function updateApp() {
        
    }

    

}

?>
