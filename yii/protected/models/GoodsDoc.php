<?php

/**
 * This is the model class for table "{{goods_doc}}".
 *
 * The followings are the available columns in table '{{goods_doc}}':
 * @property string $id
 * @property string $id_goods
 * @property string $id_parent
 * @property string $name
 * @property string $file
 * @property string $ico
 * @property string $sort
 */
class GoodsDoc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods_doc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_goods, id_parent, name, file', 'required'),
			array('id_goods, id_parent, sort', 'length', 'max'=>10),
			array('name, file', 'length', 'max'=>250),
			array('ico', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_goods, id_parent, name, file, ico, sort', 'safe', 'on'=>'search'),
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
			'id_goods' => 'Id Goods',
			'id_parent' => 'Id Parent',
			'name' => 'Name',
			'file' => 'File',
			'ico' => 'Ico',
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
		$criteria->compare('id_goods',$this->id_goods,true);
		$criteria->compare('id_parent',$this->id_parent,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('ico',$this->ico,true);
		$criteria->compare('sort',$this->sort,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoodsDoc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
