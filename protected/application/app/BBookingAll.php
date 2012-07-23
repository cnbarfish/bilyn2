<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BBookingAll
 *
 * @author jianfeng
 */
class BBookingAll extends BServiceApp {

    //put your code here

    protected function setAuthManager() {
        
    }

    protected function setDbAdapter() {
        
    }

    protected function setUIManager() {
        
    }

    public function addRolesToService($service) {
        
    }

    public function checkAccess($operation, $role) {
        
    }

    public function getOperations($role) {
        
    }

    public function registerAppMeta() {

        $meta = array();

        $meta['appname'] = 'BookingAll';
        $meta['description'] = 'Description of BookingAll';

        $meta['visible'] = array('scope' => BService::NORMALSERVICETYPE,
            'scopeType' => BServiceApp::SERVICETYPESCOPETYPE, 'applyRule' => BServiceApp::INCLUDEAPPLYRULE);

        return $meta;
    }

    public function registerAppRoles() {
        
    }

    public function updateApp() {
        
    }

}

?>
