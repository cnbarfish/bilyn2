<?php

/**
 * This is the model class for table "bln_service_application_authitem_user".
 *
 * The followings are the available columns in table 'bln_service_application_authitem_user':
 * @property integer $_id
 * @property integer $service_id
 * @property integer $authitem_id
 * @property integer $user_id
 */
class BMServiceApplicationAuthItemUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BMServiceApplicationAuthItemUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bln_service_application_authitem_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, authitem_id, user_id', 'required'),
			array('service_id, authitem_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id, service_id, authitem_id, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'service_id' => 'Service',
			'authitem_id' => 'Authitem',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('_id',$this->_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('authitem_id',$this->authitem_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}