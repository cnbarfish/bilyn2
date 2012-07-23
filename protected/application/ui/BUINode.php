<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUINode
 *
 * @author jianfeng
 */
abstract class BUINode extends BUIBase {

    //put your code here
    protected $service = null;
    protected $sApp = null;
    protected $operation = null;
    protected $style = null;
    protected $menuManager = null;
    protected $bootStrapMenu = null;
    protected $menu = null;

    public function __construct($service = null, $sApp = null, $operation = null) {
        if ($service != null)
            $this->service = $service;
        if ($sApp != null)
            $this->sApp = $sApp;
        if ($operation != null)
            $this->operation = $operation;       
    }

    /**
     *
     * @return BService 
     */
    public function getActiveService() {
        return $this->service;
    }

    /**
     *
     * @return BServiceApp 
     */
    public function getActiveServiceApp() {
        return $this->sApp;
    }

    /**
     *
     * @return BOperation 
     */
    public function getActiveOperation() {
        return $this->operation;
    }

    public function setActiveService($service) {
        $this->service = $service;
    }

    public function setActiveServiceApp($app) {
        $this->sApp = $app;
    }

    public function setActiveOperation($opp) {
        $this->operation = $opp;
    }

    protected function registerMenus($style = NULL) {
        ;
    }

    public abstract function render($config = null);
}

?>
