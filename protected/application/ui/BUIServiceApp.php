<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUISApp
 *
 * @author jianfeng
 */
class BUIServiceApp extends BUINode {
    //put your code here

    public function render($config = null) {
        $this->gotoScreen('ServiceApp', $config);
    }

    public function renderOperationContent($operation, $config = null) {
        
    }

    public function getOperationMenuItems($operation, $menuName) {
        
    }

    protected function registerMenus($style = NULL) {
        
    }

}

?>
