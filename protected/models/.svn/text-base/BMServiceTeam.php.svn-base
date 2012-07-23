<?php

/**
 * This is the model class for table "bln_serviceteam".
 *
 * The followings are the available columns in table 'bln_serviceteam':
 * @property integer $_id
 * @property string $teamname
 * @property integer $servicecircle_id
 * @property integer $teamtype_id
 * @property string $profile
 */
class BMServiceTeam extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BMServiceTeam the static model class
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
		return 'bln_serviceteam';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teamname, servicecircle_id, teamtype_id', 'required'),
			array('servicecircle_id, teamtype_id', 'numerical', 'integerOnly'=>true),
			array('teamname', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id, teamname, servicecircle_id, teamtype_id', 'safe', 'on'=>'search'),
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
			'teamname' => 'Teamname',
			'servicecircle_id' => 'Servicecircle',
			'teamtype_id' => 'Teamtype',
			'profile' => 'Profile',
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
		$criteria->compare('teamname',$this->teamname,true);
		$criteria->compare('servicecircle_id',$this->servicecircle_id);
		$criteria->compare('teamtype_id',$this->teamtype_id);
		$criteria->compare('profile',$this->profile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
