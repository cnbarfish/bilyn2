<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



return array(
    
    'title' => 'Create an account',
    'elements' => array(
        'email' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),   
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),      
        'password2' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),          
    ),
    'buttons' => array(      
        'signup' => array(
            'type' => 'submit',
            'label' => 'Signup now!',
        ),       
        'cancel' => array(
            'type' => 'submit',
            'label' => 'Cancel',
        ),
    ),
);
?>
