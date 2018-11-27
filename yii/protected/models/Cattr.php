<?php

/**
 * This is the model class for table "{{cattr}}".
 *
 * The followings are the available columns in table '{{cattr}}':
 * @property string $id
 * @property integer $id_cattype
 * @property integer $id_catrazdel
 * @property string $text
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Cattr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cattr}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cattype, id_catrazdel, text, title, keywords, description', 'required'),
			array('id_cattype, id_catrazdel', 'numerical', 'integerOnly'=>true),
			array('title, keywords', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattype, id_catrazdel, text, title, keywords, description', 'safe', 'on'=>'search'),
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
			'id_cattype' => 'Id Cattype',
			'id_catrazdel' => 'Id Catrazdel',
			'text' => 'Text',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
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
		$criteria->compare('id_cattype',$this->id_cattype);
		$criteria->compare('id_catrazdel',$this->id_catrazdel);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cattr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
