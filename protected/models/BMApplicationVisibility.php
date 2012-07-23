<?php

/**
 * This is the model class for table "bln_service_application_visibility".
 *
 * The followings are the available columns in table 'bln_service_application_visibility':
 * @property integer $_id
 * @property integer $app_id
 * @property integer $service_scope_type
 * @property integer $service_scope_id
 * @property string $apply_rule
 */
class BMApplicationVisibility extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BMApplicationVisibility the static model class
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
		return 'bln_service_application_visibility';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_id, service_scope_type, service_scope_id', 'required'),
			array('app_id, service_scope_type, service_scope_id', 'numerical', 'integerOnly'=>true),
			array('apply_rule', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id, app_id, service_scope_type, service_scope_id, apply_rule', 'safe', 'on'=>'search'),
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
			'service_scope_type' => 'Service Scope Type',
			'service_scope_id' => 'Service Scope',
			'apply_rule' => 'Apply Rule',
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
		$criteria->compare('service_scope_type',$this->service_scope_type);
		$criteria->compare('service_scope_id',$this->service_scope_id);
		$criteria->compare('apply_rule',$this->apply_rule,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}