<?php

/**
 * This is the model class for table "{{goods_20090514}}".
 *
 * The followings are the available columns in table '{{goods_20090514}}':
 * @property string $id
 * @property string $id_cattmr
 * @property string $kod
 * @property string $name
 * @property string $link
 * @property string $text1
 * @property string $text2
 * @property string $feature1
 * @property string $feature2
 * @property double $price
 * @property string $valuta
 * @property integer $yml
 * @property string $soft
 * @property integer $hide
 * @property string $hide_marks
 * @property string $sort
 * @property string $sort_t
 */
class Goods20090514 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods_20090514}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod, link, text1, text2, feature1, feature2, price, yml, soft, hide, hide_marks', 'required'),
			array('yml, hide', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id_cattmr, sort, sort_t', 'length', 'max'=>10),
			array('kod, name, link', 'length', 'max'=>250),
			array('valuta', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattmr, kod, name, link, text1, text2, feature1, feature2, price, valuta, yml, soft, hide, hide_marks, sort, sort_t', 'safe', 'on'=>'search'),
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
			'id_cattmr' => 'Id Cattmr',
			'kod' => 'Kod',
			'name' => 'Name',
			'link' => 'Link',
			'text1' => 'Text1',
			'text2' => 'Text2',
			'feature1' => 'Feature1',
			'feature2' => 'Feature2',
			'price' => 'Price',
			'valuta' => 'Valuta',
			'yml' => 'Yml',
			'soft' => 'Soft',
			'hide' => 'Hide',
			'hide_marks' => 'Hide Marks',
			'sort' => 'Sort',
			'sort_t' => 'Sort T',
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
		$criteria->compare('id_cattmr',$this->id_cattmr,true);
		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('text1',$this->text1,true);
		$criteria->compare('text2',$this->text2,true);
		$criteria->compare('feature1',$this->feature1,true);
		$criteria->compare('feature2',$this->feature2,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('valuta',$this->valuta,true);
		$criteria->compare('yml',$this->yml);
		$criteria->compare('soft',$this->soft,true);
		$criteria->compare('hide',$this->hide);
		$criteria->compare('hide_marks',$this->hide_marks,true);
		$criteria->compare('sort',$this->sort,true);
		$criteria->compare('sort_t',$this->sort_t,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods20090514 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
