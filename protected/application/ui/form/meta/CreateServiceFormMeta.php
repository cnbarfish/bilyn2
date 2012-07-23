<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



return array(
    'title' => 'Input Metadata For New Service ',
    'elements' => array(
        /*
        'bilyn_screen_name' => array(
            'name' =>'bilyn_screen_name',
            'type' => 'hidden',        
            'visible' => true,
            'value' => $this->getname(),
            ),
        'bilyn_screenflow_index' => array(
            'name' =>'bilyn_screen_name',
            'type' => 'hidden',           
            'visible' => true,
            'value' => $this->getScreenFlowIndex(),
        ),*/
        'serviceName' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'serviceCategory' => array(
            'type' => 'dropdownlist',
            'items' => $this->getServiceCategoryData(),
            'prompt' => 'Select service category'
        ),
    ),
    'buttons' => array(
        'next' => array(
            'type' => 'submit',
            'label' => 'Next',
        ),
        'reset' => array(
            'type' => 'reset',
            'label' => 'Reset',
        ),
        'cancel' => array(
            'type' => 'reset',
            'label' => 'Cancel',
        ),
    ),
);
?>
