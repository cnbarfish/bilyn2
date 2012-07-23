<?php

/**
 * This is the model class for table "bln_application_authitem".
 *
 * The followings are the available columns in table 'bln_application_authitem':
 * @property integer $_id
 * @property integer $app_id
 * @property string $authname
 * @property integer $authtype
 * @property string $description
 * @property string $bizrule
 * @property string $authdata
 */
class BMApplicationAuthItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BMApplicationAuthItem the static model class
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
		return 'bln_application_authitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_id, authname, authtype', 'required'),
			array('app_id, authtype', 'numerical', 'integerOnly'=>true),
			array('authname', 'length', 'max'=>128),
			array('description, bizrule, authdata', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id, app_id, authname, authtype, description, bizrule, authdata', 'safe', 'on'=>'search'),
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
			'app_id' => 'App',
			'authname' => 'Authname',
			'authtype' => 'Authtype',
			'description' => 'Description',
			'bizrule' => 'Bizrule',
			'authdata' => 'Authdata',
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
		$criteria->compare('app_id',$this->app_id);
		$criteria->compare('authname',$this->authname,true);
		$criteria->compare('authtype',$this->authtype);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('authdata',$this->authdata,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}