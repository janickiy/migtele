<?php

/**
 * This is the model class for table "{{price}}".
 *
 * The followings are the available columns in table '{{price}}':
 * @property string $id
 * @property string $id_catmaker
 * @property string $kod
 * @property string $text
 * @property double $price
 * @property string $valuta
 * @property integer $razd
 * @property string $sort
 */
class Price extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{price}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_catmaker, kod, text, price, razd', 'required'),
			array('razd', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id_catmaker, sort', 'length', 'max'=>10),
			array('kod', 'length', 'max'=>250),
			array('valuta', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_catmaker, kod, text, price, valuta, razd, sort', 'safe', 'on'=>'search'),
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
			'id_catmaker' => 'Id Catmaker',
			'kod' => 'Kod',
			'text' => 'Text',
			'price' => 'Price',
			'valuta' => 'Valuta',
			'razd' => 'Razd',
			'sort' => 'Sort',
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
		$criteria->compare('id_catmaker',$this->id_catmaker,true);
		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('valuta',$this->valuta,true);
		$criteria->compare('razd',$this->razd);
		$criteria->compare('sort',$this->sort,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Price the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
