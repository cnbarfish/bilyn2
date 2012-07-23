<?php

/**
 * This is the model class for table "bln_user".
 *
 * The followings are the available columns in table 'bln_user':
 * @property integer $_id
 * @property string $username
 * @property string $password
 * @property string $birthday
 * @property string $salt
 * @property string $email
 * @property string $profile
 */
class BMUser extends CActiveRecord {

    private $circleUserTable = 'bln_circle_user';
    private $serviceTeamTable = 'bln_serviceteam';

    /**
     * Returns the static model of the specified AR class.
     * @return BMUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bln_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, birthday, salt, email', 'required'),
            array('username, password, birthday, salt, email', 'length', 'max' => 128),
            array('profile', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('_id, username,birthday, email, profile', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'personalServices' => array(self::HAS_MANY, 'BService',
                'bln_service_user(user_id,service_id)')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            '_id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'birthday' => 'Birthday',
            'salt' => 'Salt',
            'email' => 'Email',
            'profile' => 'Profile',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('_id', $this->_id);
        $criteria->compare('username', $this->username, true);
        //		$criteria->compare('password',$this->password,true);
        $criteria->compare('birthday', $this->birthday, true);
        //		$criteria->compare('salt',$this->salt,true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('profile', $this->profile, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    public function register($username, $email, $password, $birthday, $profile) {
        if ($this->isNewRecord) {
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($password, $this->salt);
            $this->email = $email;
            $this->profile = $profile;
            $this->birthday = $birthday;
            //		$this->region = $region;
            $this->username = $username;

            if ($this->save())
                return $this->_id;
        }
        return false;
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    protected function generateSalt() {
        return uniqid('', true);
    }

    public function findUserCirclesById($userId) {
        $rows = $this->db->createCommand()
                ->select()
                ->from($this->circleUserTable)
                ->where('_id=:userid', array(':userid' => $userId))
                ->queryAll();
        $circles = array();
        foreach ($rows as $row) {
            $circle = BCircle::model()->findByPk($row['circle_id']);
            $circles[$circle->_id] = $circle;
            array_merge($circles, $circle->RecursivedParentCircles);
        }
        return circles;
    }

    public function findUserServiceTeamsById($userId) {
        $serviceTeams = array();
        $circles = $this->getUserCircles($userId);
        foreach ($circles as $circle) {
            $rows = $this->db->createCommand()
                    ->select()
                    ->from($this->serviceTeamTable)
                    ->where('circleid=:circleid', array(':circleid' => $circle->_id))
                    ->queryAll();
            foreach ($rows as $row) {
                $serviceTeams[$row['_id']] = BServiceTeam::model()->findByPk($row['_id']);
                //  $services[$row['serviceid']]=new Service($row['serviceid']);
            }
        }

        if (!empty($serviceTeams)) {
            foreach ($serviceTeams as $serviceTeam) {
                if ($serviceTeam->ServiceTeamType == $ServiceTeam->WorkingTeam) {
                    $userWorkingTeams[$serviceTeam->Id] = $serviceTeam;
                }
                if ($serviceTeam->ServiceTeamType == $ServiceTeam->ServedTeam) {
                    $userServedTeams[$serviceTeam->Id] = $serviceTeam;
                }
                if ($serviceTeam->ServiceTeamType == $ServiceTeam->FriendTeam) {
                    $userFriendTeams[$serviceTeam->Id] = $serviceTeam;
                }
            }
        }
        // return $serviceTeams;
    }

    public function findMyServiceTeamRoles($serviceTeamId) {
        
    }

    public function findMyServiceTeamOperations($serviceTeamId) {
        
    }

    public function findMyServiceTeamTransactions($serviceTeamId) {
        
    }

    public function getMyWorkingTeamRoles() {
        
    }

    public function getMyServedTeamRoles() {
        
    }

    public function getMyWorkingTeamOperations() {
        
    }

    public function getMyServedTeamOperations() {
        
    }

    public function getCircles() {
        return $this->findUserCirclesById($this->_id);
    }

    public function getServiceTeams() {
        return $this->findUserServiceTeamsById($this->_id);
    }

    public function getWorkingTeams() {
        if (empty($userWorkingTeams))
            $this->findUserServiceTeamsById($this->_id);
        return $userWorkingTeams;
    }

    public function getServedTeams() {
        if (empty($userServedTeams))
            $this->findUserServiceTeamsById($this->_id);
        return $userServedTeams;
    }

    public function getFriendTeams() {
        if (empty($userFriendTeams))
            $this->findUserServiceTeamsById($this->_id);
        return $userFriendTeams;
    }

}