<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BApp
 * This class define relationship between authItem and operations
 *
 * @author jianfeng
 */
abstract class BServiceApp implements BIServiceApp {
    /*
     * operation can be function inside this class
     * or function from other classes
     * this is collection of operations used in this app
     */

    const VISIABLETOSERVICE = "visiable";
    const INVISIABLETOSERVICE = 'invisiable';
    const SERVICETYPESCOPETYPE = "servicetype_scope";
    const SERVICESCOPETYPE = "service_scope";
    const SERVICECATEGORYSCOPETYPE = "servicecategory_scope";
    const INCLUDEAPPLYRULE = 'include';
    const EXCLUDEAPPLYRULE = 'exclude';
    const REGISTERAPPFLAG = 'register_app';

    //   const BServiceAppForService = 'application.application.BserviceAppForService';   

    private $authManager = null;
    protected $dbAdapter = null;
    protected $uiManager = null;
    protected $appname = null;
    protected $id = null;
    protected $description = null;
    protected $showAble = null;
    protected $activeService = null;

    /**
     *
     * @return BAuthManager 
     */
    public function __construct($activeService= null,$isRegistered = TRUE) {

        if ($isRegistered) {
            if ($this->id == null) {
                $this->init();
                $id = $this->getDbAdapter()->getServiceAppId(get_class($this));
                $this->load($id);
            }
        }
    }

    protected function init() {
        
    }

    public function getAuthManager() {
        if ($this->authManager == null) {
            $this->authManager = new BAuthManager($this);
        }
        return $this->authManager;
    }

    /**
     *
     * @return BUINode
     */
    public function getUIManager($style = NULL) {
        if ($this->uiManager == null) {
            $this->uiManager = new BUIServiceApp();
        }

        $this->uiManager->setActiveService($this->getActiveService());
        $this->uiManager->setActiveServiceApp($this);
        
        return $this->uiManager;
    }

    /**
     *
     * @return BDbAdapter 
     */
    public function getDbAdapter() {
        if ($this->dbAdapter == null) {
            $this->dbAdapter = new BDbAdapter($this);
        }
        return $this->dbAdapter;
    }

    protected function setUIManager($uiManager) {
        $this->uiManager = $uiManager;
    }

    protected function setDbAdapter($dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    protected function setAuthManager($authManager) {
        $this->authManager = $authManager;
    }

    public function doOperation($functionName, $config) {
        return $this->$functionName($config);
    }

    public static function getInstanceById($appId, $activeService = null) {
        if ($appId != null) {

            $db = new BDbAdapter();

            $appClass = $db->getServiceAppClass($appId);

            $app = new $appClass;

            $app->load($appId, $activeService);

            return $app;
        }
        return false;
    }

    public function load($appId, $activeService = null) {
        if ($appId != null) {
            $mApp = BMApplication::model()->findByPk($appId);

            $this->appname = $mApp->appname;
            $this->description = $mApp->description;
            $this->showAble = $mApp->showable;
            $this->id = $appId;

            if ($activeService !== NULL)
                $this->activeService = $activeService;
        }
    }

    public function setActiveService($service) {
        $this->activeService = $service;
    }

    public function getActiveService() {
        return $this->activeService;
    }

    public function addToService($service = null) {

        $lService = $this->activeService;

        if ($service != null)
            $lService = $service;

        $db = $this->getDbAdapter();
        $db->addServiceApp($lService->getId(), $this->getId());
        $this->addRolesToService($lService);
    }

    public function updateApp() {
        ;
    }

    public function removeFromService($service) {
        
    }

    public function register() {

        $this->registerAppRoles();
    }

    public function unRegister() {
        
    }

    public abstract function registerAppRoles();

    public abstract function registerAppMeta();

    public abstract function addRolesToService($service);

    public function getId() {
        if ($this->id == null) {
            $db = $this->getDbAdapter();
            $this->id = $db->getServiceAppId(get_class($this));

            if ($this->id == null) {
                $this->register();
            }
        }
        return $this->id;
    }

    public function getName() {
        return $this->appname;
    }

    public function isShowAble() {

        return $this->showAble;
    }

    public function isVisible($service = null, $serviceType = null, $serviceCategory = null) {

        $serviceTypeId = null;
        $serviceId = null;
        $serviceCategoryId = null;

        if ($service != null) {
            $serviceId = $service->getId();
            $serviceCategoryId = $service->getServiceCategoryId();
            $serviceTypeId = $service->getServiceEngine()->getServiceTypeId();
        }

        if ($serviceType != null)
            $serviceTypeId = $this->getDbAdapter()->getServiceTypeId($serviceType);

        if ($serviceCategory != null)
            $serviceCategoryId = $this->getDbAdapter()->getServiceCategoryId($serviceCategory);

        return $this->getDbAdapter()->isVisible($serviceId, $serviceTypeId, $serviceCategoryId);
    }

    protected function isRegistered() {
        $id = $this->getDbAdapter()->getServiceAppId(get_class($this));

        if ($id == null)
            return false;

        return true;
    }

    protected function isNeedUpdateApp() {
        return false;
    }

}

?>
