<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BOperation
 *
 * @author ID59C
 */
class BOperation {

    //put your code here
    private $id = null;
    private $activeService = null;
    private $dbAdapter = null;
    /**
     * 
     */
    private $uiManager = null;
    private $app = null;
    private $operationName = null;
    private $functionName = null;
    private $config = null;
    private $description = null;

    public function __construct($operationId = NULL) {
        if ($operationId != NULL) {
            $this->id = $operationId;
            $this->load($operationId);
        }
    }

    public function setActiveService($service) {
        if ($service !== NULL)
            $this->activeService = $service;
    }
    
    public function getActiveService()
    {
        return $this->activeService;
    }

    public function load($operationId) {
        $db = $this->getDbAdapter();
        $result = $db->getOperationById($operationId);

        $this->app = BServiceApp::getInstanceById($result['AppId']);
        $this->operationName = $result['OperationName'];
        $this->functionName = $result['FunctionName'];
        $this->description = $result['Description'];
        $this->config = $result['OperationData'];
    }

    public function getId() {
        return $this->id;
    }

    /**
     *  @return BUIOperation
     */
    public function getUIManager($style = NULL) {
        if ($this->uiManager == NULL)
            $this->uiManager = BUIOperation();
        
        $this->uiManager->setActiveService($this->getActiveService());
        $this->uiManager->setActiveServiceOperation($this);
        $this->uiManager->setActiveServieApp($this->getApp());
        
        return $this->uiManager;
    }

    public function getDbAdapter() {
        if ($this->dbAdapter == NULL)
            return new BDbAdapter ();
        return $this->dbAdapter;
    }

    public function getApp() {
        return $this->app;
    }

    public function getConfig() {
        return $this->config;
    }

    public function getOperationName() {
        return $this->operationName;
    }

    public function getFunctionName() {
        return $this->functionName;
    }

    public function getDescription() {
        return $this->description;
    }

}

?>
