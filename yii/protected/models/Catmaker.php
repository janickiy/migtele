<?php

/**
 * This is the model class for table "{{catmaker}}".
 *
 * The followings are the available columns in table '{{catmaker}}':
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $sort
 * @property integer $hide
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $clickCount
 * @property integer $hide_in_YML
 * @property string $slug
 */
class Catmaker extends CActiveRecord implements ClickCounterAble
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{catmaker}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, text, hide, title, keywords, description', 'required'),
            array('hide', 'numerical', 'integerOnly' => true),
            array('name, title, keywords', 'length', 'max' => 250),
            array('sort', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, text, sort, hide, title, keywords, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'sort' => 'Sort',
            'hide' => 'Hide',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('sort', $this->sort, true);
        $criteria->compare('hide', $this->hide);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Catmaker the static model class
     */
    public static function model($className = __CLASS__)
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

    public function getUrl()
    {
        return 'brands/' . $this->slug . '/';
    }
}
