<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BService
 *
 * @author jianfeng
 */
class BService {
    /*
     * workTeam,servedTeam and friendTeam are instance of BServiceTeam
     */

    const NEWSERVICE = -5001;
    const JOINWORKINGSERVICE = -5002;
    const JOINSERVEDSERVICE = -5003;
    const PERSONALSERVICETYPE = "personal_service_type";
    const NORMALSERVICETYPE = "normal_service_type";
    const UNKNOWNCATEGORY = "unknown";
    
    const WORKTEAMTYPE = 11;
    const SERVEDTEAMTYPE = 21;

    private $engine = null;
    private $serviceId = null;
    private $name = null;
    private $ui = null;  

    public function __construct($serviceId = null, $serviceType = null, $config = null) {
        $this->engine = new BServiceEngine();

        if ($serviceType == null) {
            if ($serviceId != null) {
                $this->serviceId = $serviceId;
                $this->load($serviceId);
            }
        } else if ($serviceType == BService::PERSONALSERVICETYPE) {
            $this->loadPersonalService($config);
        }

        //$this->serviceApps = $this->loadServiceApps($config);
    }

    public function doOperation($operationId, $config) {
        $operation = new BOperation($operationId);
        $app = $operation->getApp();
        $app->doOperation($operation->getFunctionName(), $config);
    }

    protected function load($serviceId) {
        $config['ServiceId'] = $serviceId;

        $mService = BMService::model()->findByPk($serviceId);

        $this->name = $mService->servicename;      
        $this->serviceId = $serviceId;
    }

    protected function loadPersonalService($config) {
        $userId = Blyn::app()->getCurrentUser()->getId();

        if ($userId == null)
            $userId = $config['UserId'];

        $db = Blyn::app()->getAppDb();

        $pService = $db->getPersonalService($userId);

        $this->load($pService->getId());
    }

    public function getId() {
        return $this->serviceId;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getVisible()
    {
        $visible = true;
        
        $visible = $this->getServiceEngine()->getDbAdapter()->getServiceVisible($this->getId());
        
        return $visible;
    }

    public static function createService($config) {

        $db = Blyn::app()->getAppDb();

        $sName = $config['ServiceName'];
        $sType = isset($config['ServiceType']) ? $config['ServiceType'] : self::NORMALSERVICETYPE;       
        $sCategoryId = isset($config['ServiceCategoryId']) ? $config['ServiceCategoryId'] : self::UNKNOWNCATEGORY;

        if (isset($config['User']))
        $user = $config['User'];
        else {
            $user = Blyn::app()->getCurrentUser();            
        }

        $serviceId = $db->createService($sName, $sType, $sCategoryId);
        $newService = new BService($serviceId);

        //add service engine to service        
        $engine = new BServiceEngine();

        $engine->addToService($newService);

        //add user to service
        $authManager = $engine->getAuthManager();
        $appAdmin = $authManager->getRole(BAuthTemplate1::APPADMIN);
        $authManager->assignUserToRole($newService, $user, $appAdmin);

        return $newService;
    }

    /**
     *
     * @return BServiceEngine 
     */
    public function getServiceEngine() {
        if ($this->engine == null)
            $this->engine = new BServiceEngine();

        return $this->engine;
    }

    public function getServiceType() {
        $engine = $this->getServiceEngine();
        return $engine->getServiceType($this->getId());
    }   
    
    public function getServiceCategory()
    {
        return null;
    }

    /**
     *
     * @param type $style
     * @return \BUIService 
     */
    public function getUIManager($style = null) {
        if ($this->ui == null)
            $this->ui = new BUIService();
        
        $this->ui->setActiveService($this);
        
        return $this->ui;        
    }
    
    public function getVisibleApps()
    {
        $apps = array();
        
        $db = Blyn::app()->getAppDb();
        
        $typeApps = $db->getVisiableServiceAppsByServiceType($this->getServiceType());
        
        if($typeApps != null)
        {
            array_push($apps, $typeApps);
        }
        
        $sApps = $db->getVisibleServiceAppsByService($this->getId());
        
        if($sApps != null)
        {
            array_push($apps, $sApps);
        }
        
        $cateApps = $db->getVisibleServiceAppsByCategory($this->getServiceCategory());
        
        if($cateApps != null)
        {
            array_push($apps, $cateApps);
        }        
        
        return $apps;
    }
    
    public function setVisible($visible)
    {
        return $this->getServiceEngine()->getDbAdapter()->setServiceVisible($this->getId(),$visible);
    }
    
}

?>
