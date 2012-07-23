<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUIOperation
 *
 * @author ID59C
 */
class BUIOperation extends BUINode {

    private $activeOperation = null;

    public function __construct($operation = NULL) {

        if ($operation !== NULL)
            $this->activeOperation = $operation;
    }

    public function setActiveOperation($operation) {
        $this->activeOperation = $operation;
    }

    public function render($config = null) {
        $opp = $this->activeOperation;

        if ($opp != NULL) {
            $app = $opp->getApp();
            $app->getUIManager()->renderOperationContent($opp, $config);
        }

        return FALSE;
    }

    protected function registerMenus($style = NULL) {
        
    }

}

?>
