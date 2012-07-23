<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BUIService
 *
 * @author jianfeng
 */
class BUIService extends BUINode {

    public function render($config = null) {
        //parent::render($config, $style);
        //$this->renderMenu('leftMenu', $style);
        return $this->gotoScreen('Service', $this, $config);
    }

    public function renderCreateService($config = null) {
        //$screenName = isset($_POST['bilyn_screen_name'])?$_POST['bilyn_screen_name']:'CreateServiceMeta';
        //return $this->gotoScreen($screenName,$this,$config,$style);
        return $this->gotoScreenFlow('CreateService', $this, $config);
    }

    public function renderJoinService($config = null) {
        return $this->gotoScreen('JoinService', $this, $config);
    }

}

?>
