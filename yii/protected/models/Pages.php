<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property string $id
 * @property string $id_parent
 * @property string $name
 * @property string $link
 * @property string $text
 * @property integer $top
 * @property integer $mid
 * @property integer $bot
 * @property integer $sort
 * @property integer $readonly
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Pages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, top, mid, bot, title, keywords, description', 'required'),
			array('top, mid, bot, sort, readonly', 'numerical', 'integerOnly'=>true),
			array('id_parent', 'length', 'max'=>10),
			array('name, link, title, keywords', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_parent, name, link, text, top, mid, bot, sort, readonly, title, keywords, description', 'safe', 'on'=>'search'),
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
			'id_parent' => 'Id Parent',
			'name' => 'Name',
			'link' => 'Link',
			'text' => 'Text',
			'top' => 'Top',
			'mid' => 'Mid',
			'bot' => 'Bot',
			'sort' => 'Sort',
			'readonly' => 'Readonly',
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
		$criteria->compare('id_parent',$this->id_parent,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('top',$this->top);
		$criteria->compare('mid',$this->mid);
		$criteria->compare('bot',$this->bot);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('readonly',$this->readonly);
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
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
