<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BApplication
 *
 * @author jianfeng
 */
class BUser {

    const WORKTEAMADMINROLE = "workteam_admin";
    const WORKTEAMMEMBERROLE = "workteam_member";
    const SERVEDTEAMADMINROLE = "servedteam_admin";
    const SERVEDEAMMEMBERROLE = "servedteam_member";

    private $personalService = null;
    private $services = array();
    private $_identity = null;
    private $_userId = null;

    public function __construct($userId = null) {
        $this->load($userId);
    }

    protected function load($userId) {
        if ($userId != null)
            $this->_userId = $userId;
    }

    /**
     *
     * @param type $serviceId
     * @param type $config
     * @return BService 
     */
    public function getPersonalService() {
        if ($this->personalService == null)
            $this->personalService = new BService(null, BService::PERSONALSERVICETYPE, array('UserId' => $this->getId()));
        return $this->personalService;
    }

    public function getCurrentUserServices($roleType) {
        $db = Blyn::app()->getAppDb();

        if ($this->services == null) {
            return $db->getUserServices($this->getId(), $roleType);
        }
        return false;
    }

    public function getId() {

        $user = $this->getWebUser();

        if ($user != null) {
            $id = $user->getId();

            if ($id != null)
                return $id;
        }

        return $this->_userId;
    }

    /**
     *
     * @return CWebUser
     */
    protected function getWebUser() {
        return Yii::app()->user;
    }

    public function login($loginId, $email, $password, $duration) {

        if ($this->_identity === null) {
            $this->_identity = new BUserIdentity($loginId, $email, $password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === BUserIdentity::ERROR_NONE) {
            $this->getWebUser()->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

    public function register($loginId, $email, $password, $birthday, $profile) {
        $appDb = new BAppDb();

        $userId = $appDb->createUser($loginId, $email, $password, $birthday, $profile);
        $this->load($userId);

        //add personalService
        if ($userId != FALSE) {

            if ($email === "bAdmin@bilyn.com") {
                $bApp = new BilynAdminApp(null,FALSE);
                $bApp->registerSystemApps();

                $bAdminService = BService::createService(array("User" => $this, "ServiceName" => "BilynAdmin",
                            'ServiceType' => BService::NORMALSERVICETYPE));

                $bAdminService->getServiceEngine()->doOperation(BServiceEngine::ADDSERVICEAPPOPERATION, array('Service' => $bAdminService, 'App' => new BilynAdminApp()));
            }

            $pService = BService::createService(array("User" => $this, "ServiceName" => $userId . "_personalService",
                        'ServiceType' => BService::PERSONALSERVICETYPE));

            //add default app into personalService          
            $pMessageApp = new BPersonalMessageApp();
            $pService->getServiceEngine()->doOperation(BServiceEngine::ADDSERVICEAPPOPERATION, array('Service' => $pService, 'App' => $pMessageApp));

            /*
              $pEventApp = new BPersonalEventApp();
              $pService->getServiceEngine()->doOperation(BServiceEngine::ADDSERVICEAPPOPERATION, array('Service' => $pService, 'App' => $pEventApp));

              $pInfoApp = new BPersonalInfoApp();
              $pService->getServiceEngine()->doOperation(BServiceEngine::ADDSERVICEAPPOPERATION, array('Service' => $pService, 'App' => $pInfoApp));

              $pCircleApp = new BPersonalCircleApp();
              $pService->getServiceEngine()->doOperation(BServiceEngine::ADDSERVICEAPPOPERATION, array('Service' => $pService, 'App' => $pCircleApp));
             */
            return TRUE;
            //      $this->login($loginId, $email, $password, $duration);
        }
        return FALSE;
    }

    public function authenticate($loginId, $email, $password) {
        if ($this->_identity == null)
            $this->_identity = new BUserIdentity($loginId, $email, $password);
        return $this->_identity->authenticate();
    }

}

?>
