<?php

/**
 * This is the model class for table "{{cattmr}}".
 *
 * The followings are the available columns in table '{{cattmr}}':
 * @property string $id
 * @property integer $id_cattype
 * @property integer $id_catmaker
 * @property integer $id_catrazdel
 * @property string $text
 * @property string $text1
 * @property string $text2
 * @property string $text_hide
 * @property string $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $hg
 * @property integer $sr
 * @property integer $clickCount
 *
 * @property Cattype $category
 * @property Catmaker $vendor
 * @property Catrazdel $section
 */
class Cattmr extends CActiveRecord implements ClickCounterAble
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cattmr}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cattype, id_catmaker, id_catrazdel, text, text_hide, title, keywords, description', 'required'),
			array('id_cattype, id_catmaker, id_catrazdel, hg, sr', 'numerical', 'integerOnly'=>true),
			array('sort', 'length', 'max'=>10),
			array('title, keywords', 'length', 'max'=>250),
			array('text1, text2', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattype, id_catmaker, id_catrazdel, text, text1, text2, text_hide, sort, title, keywords, description, hg, sr', 'safe', 'on'=>'search'),
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
		    'category' => array(self::BELONGS_TO, 'Cattype', 'id_cattype'),
		    'vendor' => array(self::BELONGS_TO, 'Catmaker', 'id_catmaker'),
		    'section' => array(self::BELONGS_TO, 'Catrazdel', 'id_catrazdel'),
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
			'id_catmaker' => 'Id Catmaker',
			'id_catrazdel' => 'Id Catrazdel',
			'text' => 'Text',
			'text1' => 'Text1',
			'text2' => 'Text2',
			'text_hide' => 'Text Hide',
			'sort' => 'Sort',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'hg' => 'скрывать товары',
			'sr' => 'разбивать по сериям',
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
		$criteria->compare('id_catmaker',$this->id_catmaker);
		$criteria->compare('id_catrazdel',$this->id_catrazdel);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('text1',$this->text1,true);
		$criteria->compare('text2',$this->text2,true);
		$criteria->compare('text_hide',$this->text_hide,true);
		$criteria->compare('sort',$this->sort,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('hg',$this->hg);
		$criteria->compare('sr',$this->sr);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cattmr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return int
	 */
	public function getClickCount()
	{
		return $this->clickCount;
	}

	/**
	 * @param $count int - setter clickCount property
	 */
	public function setClickCount($count)
	{
		$this->clickCount = $count;
	}


}
