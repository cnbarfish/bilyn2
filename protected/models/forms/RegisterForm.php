<?php

/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel {

    public $email;
    public $password;
    public $password2;
    public $name;
    public $birthday = 'birthday here:';
    public $region;
    public $profile;
   

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password,name,birthday', 'required'),
            //email format for email field
            array('email', 'email'),
            // rememberMe needs to be a boolean
            array('password', 'compare',
                'compareAttribute' => 'password2', 'operator' => '='),
            array('region,profile', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => 'Login Name',
            'email' => 'Email',
            'password' => 'Password',
            'password2' => 'Retype Password',
            'region' => 'Region',
            'birthday' => 'Birthday',
            'profile' => 'Profile',
        );
    }

    /**
     * Register the user using the given email and password in the model.
     * @return boolean whether register is successful
     */
    public function register() {
        Blyn::app()->getCurrentUser()->register($this->name, $this->email, $this->password, $this->birthday, $this->profile);
    }

}
