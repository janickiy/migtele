<?php

/**
 * This is the model class for table "{{managers}}".
 *
 * The followings are the available columns in table '{{managers}}':
 * @property string $id
 * @property string $name
 * @property string $login
 * @property string $pass
 * @property string $type
 * @property string $ids_cattmr
 * @property string $ids_goods
 */
class Managers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{managers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, login, pass', 'length', 'max'=>50),
			array('type', 'length', 'max'=>1),
			array('ids_cattmr, ids_goods', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, login, pass, type, ids_cattmr, ids_goods', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'Name',
			'login' => 'Login',
			'pass' => 'Pass',
			'type' => 'Type',
			'ids_cattmr' => 'Ids Cattmr',
			'ids_goods' => 'Ids Goods',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('ids_cattmr',$this->ids_cattmr,true);
		$criteria->compare('ids_goods',$this->ids_goods,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Managers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
