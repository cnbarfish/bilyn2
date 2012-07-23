<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array(
    'title' => 'Login In',
    'elements' => array(
        'email' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',     
             'maxlength' => 32,
        ),
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
        'signup' => array(
            'type' => 'submit',
            'label' => 'SignUP',
        ),
    ),
);
?>
