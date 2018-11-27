<?php

/**
 * This is the model class for table "{{cattype}}".
 *
 * The followings are the available columns in table '{{cattype}}':
 * @property string $id
 * @property string $id_otr
 * @property string $name
 * @property string $text
 * @property string $sort
 * @property string $feature
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $status
 * @property integer $clickCount
 * @property string $slug
 */
class Cattype extends CActiveRecord implements ClickCounterAble
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cattype}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_otr, name, text, feature, title, keywords, description', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('id_otr', 'length', 'max' => 11),
            array('name, title, keywords', 'length', 'max' => 250),
            array('sort', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_otr, name, text, sort, feature, title, keywords, description, status', 'safe', 'on' => 'search'),
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
            'id_otr' => 'Id Otr',
            'name' => 'Name',
            'text' => 'Text',
            'sort' => 'Sort',
            'feature' => 'Feature',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'status' => 'Status',
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
        $criteria->compare('id_otr', $this->id_otr, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('sort', $this->sort, true);
        $criteria->compare('feature', $this->feature, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cattype the static model class
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
        return $this->slug . '/';
    }

    public function getUrlWithVendor(Catmaker $vendor)
    {
        return $this->getUrl() . $vendor->slug . '/';
    }

    public function getUrlWithSection(Catrazdel $section){
        return $this->getUrl() . $section->slug . '/';
    }

    public function getUrlWithVendorAndSection(Catmaker $vendor, Catrazdel $section, Catrazdel $sub_section = null){

        $sub_section_slug = $sub_section ? $sub_section->slug.'/' : '';

        return $this->getUrlWithVendor($vendor) . $section->slug . '/'.$sub_section_slug;
    }


}
