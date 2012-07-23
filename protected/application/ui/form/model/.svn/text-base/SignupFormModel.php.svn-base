<?php

/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SignupFormModel extends CFormModel {
    
    public $birthday = null;
    public $profile = null;
    public $name = null;

    public $email;
    public $password;
    public $password2;  
   

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password, password2', 'required'),
            array('name, birthday, profile', 'safe'),
            //email format for email field
            array('email', 'email'),
            // rememberMe needs to be a boolean
            array('password', 'compare',
                'compareAttribute' => 'password2', 'operator' => '='),  
            array('email','unique','className'=>'BMUser')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(           
            'email' => 'Email',
            'password' => 'Password',
            'password2' => 'Retype Password'           
        );
    }

    /**
     * Register the user using the given email and password in the model.
     * @return boolean whether register is successful
     */
    public function signup() {
        if(!isset($this->name) || $this->name == NULL)
            $this->name = $this->email;
        
        if($this->birthday === NULL)
            $this->birthday = '01012099';
        
        return Blyn::app()->getCurrentUser()->register($this->name, $this->email, $this->password, $this->birthday, $this->profile);
    }

}
