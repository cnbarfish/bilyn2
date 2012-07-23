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
class BServiceEngine extends BServiceApp {
    //operations

    const LOADSERVICEOPERATION = "loadService";
    const ADDSERVICEAPPOPERATION = "addServiceApp";
    const GETSERVICEAPPSOPERATION = "getServiceApps";

    private $operationList = array();
     

    public function checkAccess($operation, $role) {
        
    }

    public function getOperations($role) {

        $authManager = $this->getAuthManager();

        return $authManager->getOperations($role);
    }

    public function registerAppRoles() {

        $operations = $this->operationList;
        $operations['AddServiceApp'] = "addServiceApp";
        $operations['UpdateServiceApp'] = "updateApp";

        $authTemplate1 = new BAuthTemplate1();

        $workTeamAdmin = $authTemplate1->workTeamAdmin;
        $workTeamAdmin['operations'] = $this->operationList;

        $authManager = $this->getAuthManager();

        $authManager->createRecursiveRole($workTeamAdmin);
        $authManager->createRecursiveRole($authTemplate1->workTeamMember);
        $authManager->createRecursiveRole($authTemplate1->servedTeamAdmin);
        $authManager->createRecursiveRole($authTemplate1->servedTeamMember);
        $authManager->createRecursiveRole($authTemplate1->appSuper);
        $authManager->createRecursiveRole($authTemplate1->appAdmin);
        $authManager->createRecursiveRole($authTemplate1->appMember);
    }

    public function updateApp() {
        
    }

    protected function init() {
        parent::init();
        $this->setDbAdapter(new BServiceEngineDb($this));
    }

    public function getServiceAppByOperation($operation) {
        $db = new BServiceEngineDb();

        $appClass = $db->getServiceAppClassByOperationId($operation);

        $app = new $appClass;

        return $app;
    }

    public function addRolesToService($service) {
        
    }

    public function registerAppMeta() {
        $meta = array();

        $meta['appname'] = 'ServiceEngine';
        $meta['description'] = 'Service Engine Description';
        $meta['showable'] = FALSE;

        return $meta;
    }

    protected function loadService($config) {
        
    }

    /**
     *
     * @param type $BService
     * @param type $BServiceApp 
     */
    protected function addServiceApp($config) {
        $service = $config['Service'];
        $app = $config['App'];

        $db = $this->getDbAdapter();
        $dbresult = $db->addServiceApp($service->getId(), $app->getId());

        $app->addToService($service);
    }

    protected function getServiceApps($config) {

        $service = $config['Service'];

        $db = $this->getDbAdapter();

        $apps = $db->getServiceApps($service->getId());

        return $apps;
    }

    protected function getUserServiceApps($config) {
        $userApps = array();
        $user = $config['User'];
        $service = $config['Service'];

        $apps = $this->getServiceApps(array('Service' => $service));

        foreach ($apps as $app) {
            $roles = $app->getAuthManager()->getUserRoles($user, $service);

            if ($roles != null && !empty($roles)) {
                array_push($userApps, $app);
            }
        }

        return $userApps;
    }

    public function getServiceType($serviceId) {
        $db = $this->getDbAdapter();

        $type = $db->getServiceType($serviceId);

        return $type;
    }

    public function getContentView($style) {
        
    }

}

?>
