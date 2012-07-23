<?php

/**
 * BCUserIdentity class file
 *
 * @author jianfeng <jianfeng@gmail.com> * 
 * @copyright Copyright &copy; 2008-2012 Bilyn Software LLC
 * @license http://www.bilyn.com/license/
 */

/**
 * BUserIdentity is a base class for representing identities that are authenticated based on a username and a password.
 *
 * Derived classes should implement {@link authenticate} with the actual
 * authentication scheme (e.g. checking username and password against a DB table).
 *
 * By default, CUserIdentity assumes the {@link username} is a unique identifier
 * and thus use it as the {@link id ID} of the identity.
 *
 * @author jianfeng <cnjianfeng@gmail.com>
 * @version $Id: CUserIdentity.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.web.auth
 * @since 1.0
 */
class BUserIdentity extends CUserIdentity {

    /**
     * @var string email
     */
    public $email;
    private $_id;

    const ERROR_EMAIL_INVALID = 3;

    /**
     * Constructor.
     * @param string $username username
     * @param string $email email
     * @param string $password password
     */
    public function __construct($username, $email, $password) {
        parent::__construct($username, $password);
        $this->email = $email;
    }

    /**
     * Authenticates a user based on {@link username}，{@link username} and {@link password}.
     * Authenticate either username or email, if both provided, prefer to email
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $username = strtolower($this->username);
        $email = strtolower($this->email);
        $user = BMUser::model()->find('LOWER(username)=?', array($username));
        //if not set username, use email to validate
        $user = $user === null ? BMUser::model()->find('LOWER(email)=?', array($email)) : $user;
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->_id;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * Returns the unique identifier for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Returns the display name for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName() {
        return(isset($this->username) ? $this->username : $this->email);
    }

}
