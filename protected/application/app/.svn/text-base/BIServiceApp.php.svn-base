<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jianfeng
 */
interface BIServiceApp {

    //put your code here
    public function checkAccess($operation, $role);

    public function getOperations($role);

    public function doOperation($operation, $config);

    /**
     * this function is called when register application to system 
     */
    public function register();

    public function unRegister();

    public function updateApp();

    /**
     * this function is called when add application to service 
     */
    public function addToService($service);

    public function removeFromService($service);
}

?>
