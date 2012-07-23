<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BForm
 *
 * @author jianfeng
 */
class BForm extends CForm {

    public function __construct($screenParent, $config, $model = null, $parent = null) {
        parent::__construct($config, $model, $parent);
        $this->parentScreen = $screenParent;
    }

    protected $parentScreen = null;

    public function renderBegin() {
        $output = parent::renderBegin();

        if ($output != "") {
            if ($this->parentScreen != null) {
                $screen = $this->parentScreen;
                $output = $output . "<div style=\"visibility:hidden\">" . CHtml::hiddenField('bilyn_screen_name', $screen->getName()) . "</div>\n";
                $output = $output . "<div style=\"visibility:hidden\">" . CHtml::hiddenField('bilyn_screenflow_index', $screen->getScreenFlowIndex()) . "</div>\n";
            }
        }

        return $output;
    }

    public function setParentScreen($screen) {
        $this->parentScreen = $screen;
    }

}

?>
