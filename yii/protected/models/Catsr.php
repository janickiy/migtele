<?php

/**
 * This is the model class for table "{{catsr}}".
 *
 * The followings are the available columns in table '{{catsr}}':
 * @property string $id
 * @property integer $id_cattmr
 * @property string $name
 * @property string $text
 * @property integer $hide
 * @property string $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Catsr extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catsr}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cattmr', 'required'),
			array('id_cattmr, hide', 'numerical', 'integerOnly'=>true),
			array('name, title, keywords', 'length', 'max'=>255),
			array('sort', 'length', 'max'=>11),
			array('text, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattmr, name, text, hide, sort, title, keywords, description', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'text' => 'Text',
			'hide' => 'Hide',
			'sort' => 'Sort',
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
		$criteria->compare('id_cattmr',$this->id_cattmr);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('hide',$this->hide);
		$criteria->compare('sort',$this->sort,true);
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
	 * @return Catsr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
