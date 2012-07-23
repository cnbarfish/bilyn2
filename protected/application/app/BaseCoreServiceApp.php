<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BServiceAppForService
 *
 * @author jianfeng
 */
class BaseCoreServiceApp extends BServiceApp {
   
    private $authItems = null;

    protected function createAuthItemsFromTemplate($templateFile) {
        $rudeAuthItems = require(Yii::getPathOfAlias($templateFile) . '.php');
        $this->authItems = $rudeAuthItems["CoreServiceApp"];
    }

    protected function setAppAuthItems($authManager) {
        if ($this->authItems == null)
            $this->createAuthItemsFromTemplate("application.application.meta.AuthItemTemplate");

        $authManager->setAuthItems($this->authItems);
    }

    public function checkAccess($operation, $role) {
        
    }

    public function doOperation($operation, $config) {
        
    }

    public function getId() {
        
    }

    public function getOperations($role) {
        
    }

    protected function addAuthItemToService($authItemType, $authItem) {
        
    }

    protected function registerAuthItems() {
        
    }
    
    
}

?>
