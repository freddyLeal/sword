<?php

/**
 * This is the model class for table "system_variable".
 *
 * The followings are the available columns in table 'system_variable':
 * @property string $sv_id
 * @property string $sv_name
 * @property string $sv_value_numeric
 * @property string $sv_value_text
 * @property string $sv_last_modification_date
 * @property string $sv_last_mod_user_id
 *
 * The followings are the available model relations:
 * @property User $svLastModUser
 */
class SystemVariable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'system_variable';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sv_name, sv_last_modification_date, sv_last_mod_user_id', 'required'),
			array('sv_name, sv_value_text', 'length', 'max'=>50),
			array('sv_value_numeric', 'length', 'max'=>19),
			array('sv_last_mod_user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sv_id, sv_name, sv_value_numeric, sv_value_text, sv_last_modification_date, sv_last_mod_user_id', 'safe', 'on'=>'search'),
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
			'svLastModUser' => array(self::BELONGS_TO, 'User', 'sv_last_mod_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sv_id' => 'Sv',
			'sv_name' => 'Sv Name',
			'sv_value_numeric' => 'Sv Value Numeric',
			'sv_value_text' => 'Sv Value Text',
			'sv_last_modification_date' => 'Sv Last Modification Date',
			'sv_last_mod_user_id' => 'Sv Last Mod User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sv_id',$this->sv_id,true);
		$criteria->compare('sv_name',$this->sv_name,true);
		$criteria->compare('sv_value_numeric',$this->sv_value_numeric,true);
		$criteria->compare('sv_value_text',$this->sv_value_text,true);
		$criteria->compare('sv_last_modification_date',$this->sv_last_modification_date,true);
		$criteria->compare('sv_last_mod_user_id',$this->sv_last_mod_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemVariable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
