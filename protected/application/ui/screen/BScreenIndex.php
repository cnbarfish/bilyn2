<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BScreenIndex
 *
 * @author jianfeng
 */
class BScreenIndex extends BUIScreen{
    //put your code here
    public function render($config = null, $style = NULL) {       
        
//        $view = $this->getView('index');
        $this->renderView('index');
        
    }
   
}

?>
