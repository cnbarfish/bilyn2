<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreServiceApp
 *
 * @author jianfeng
 */
class BilynAdminApp extends BServiceApp {

    public function addRolesToService($service) {
        
    }

    public function checkAccess($operation, $role) {
        
    }

    public function getOperations($role) {
        
    }

    public function registerAppMeta() {
        $meta['appname'] = 'Bilyn Admin';
        $meta['description'] = 'Description of BilynadminApp';
        
        /*
        $meta['visible'] = array('scope' => Blyn::app()->getAppDb()->getServiceIdByName("BilynAdmin"),
            'scopeType' => BServiceApp::SERVICESCOPETYPE, 'applyRule' => BServiceApp::INCLUDEAPPLYRULE);
        */
        return $meta;
    }

    public function registerAppRoles() {
        
    }

    protected function registerApp($appClass) {
        
        $currentClass = get_class();
        
        if($appClass == $currentClass)
            $rApp = $this;
        else
            $rApp = new $appClass(null,false);

        $meta = $rApp->registerAppMeta();

        $db = $this->getDbAdapter();

        $meta['appclass'] = $appClass;

        $appId = $db->registerServiceApp($meta);

        $app = BServiceApp::getInstanceById($appId);

        $app->register();
    }

    public function registerSystemApps() {

        $id = $this->getDbAdapter()->getServiceAppId('BServiceEngine');

        if ($id == null || $id == FALSE || $id <= 0) {
            $this->registerApp('BServiceEngine');
            $this->registerApp('BilynAdminApp');
            $this->registerApp('BPersonalMessageApp');
        }
    }

}

?>
