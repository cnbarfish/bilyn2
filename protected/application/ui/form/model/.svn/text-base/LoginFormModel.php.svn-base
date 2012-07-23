<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginFormModel extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;
   
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password', 'required'),
            //email format for email field
            array('email', 'email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me',
            'email' => 'Email',
            'password' => 'Password',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!Blyn::app()->getCurrentUser()->authenticate(null, $this->email, $this->password))
            $this->addError('password', 'Passowrd or user is not correct.');
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login($email = null,$password = null,$duration = null) {        
        $lemail = $email == null?$this->email:$email;
        $lpassword = $password == null?$this->password:$password;
        
        $duration = $this->rememberMe ? 3600 * 24 * 7 : 0; // 7 days
        return Blyn::app()->getCurrentUser()->login(null, $lemail, $lpassword, $duration);
    }

}
