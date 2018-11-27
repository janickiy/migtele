<?php

/**
 * This is the model class for table "{{goods_copy}}".
 *
 * The followings are the available columns in table '{{goods_copy}}':
 * @property string $id
 * @property string $id_cattmr
 * @property string $id_catsr
 * @property string $kod
 * @property string $name
 * @property string $link
 * @property string $text1
 * @property string $text2
 * @property string $text3
 * @property string $text4
 * @property string $text5
 * @property string $teh
 * @property string $feature1
 * @property string $feature2
 * @property double $price
 * @property string $valuta
 * @property integer $new
 * @property integer $yml
 * @property string $sp
 * @property integer $none
 * @property string $soft
 * @property integer $hide
 * @property string $sort
 * @property string $tr
 * @property string $sort_tr
 * @property integer $nalich
 * @property string $ids_goods
 */
class GoodsCopy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods_copy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod, link, text1, text2, text3, text4, text5, teh, feature1, feature2, price, soft, hide, tr, nalich', 'required'),
			array('new, yml, none, hide, nalich', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id_cattmr, sort, sort_tr', 'length', 'max'=>10),
			array('id_catsr', 'length', 'max'=>11),
			array('kod, name, link, tr, ids_goods', 'length', 'max'=>250),
			array('valuta', 'length', 'max'=>3),
			array('sp', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattmr, id_catsr, kod, name, link, text1, text2, text3, text4, text5, teh, feature1, feature2, price, valuta, new, yml, sp, none, soft, hide, sort, tr, sort_tr, nalich, ids_goods', 'safe', 'on'=>'search'),
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
			'id_catsr' => 'Id Catsr',
			'kod' => 'Kod',
			'name' => 'Name',
			'link' => 'Link',
			'text1' => 'краткое описание товара',
			'text2' => 'основное описание товара',
			'text3' => 'текст в правой колонке',
			'text4' => 'описание при выводе похожих и сопутствующих товаров',
			'text5' => 'текст в самом низу страницы товара',
			'teh' => 'Teh',
			'feature1' => 'Feature1',
			'feature2' => 'Feature2',
			'price' => 'Price',
			'valuta' => 'Valuta',
			'new' => 'новинка',
			'yml' => 'Yml',
			'sp' => 'срок поставки',
			'none' => 'снято с производства',
			'soft' => 'Soft',
			'hide' => 'Hide',
			'sort' => 'Sort',
			'tr' => 'Tr',
			'sort_tr' => 'Sort Tr',
			'nalich' => 'Nalich',
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
		$criteria->compare('id_cattmr',$this->id_cattmr,true);
		$criteria->compare('id_catsr',$this->id_catsr,true);
		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('text1',$this->text1,true);
		$criteria->compare('text2',$this->text2,true);
		$criteria->compare('text3',$this->text3,true);
		$criteria->compare('text4',$this->text4,true);
		$criteria->compare('text5',$this->text5,true);
		$criteria->compare('teh',$this->teh,true);
		$criteria->compare('feature1',$this->feature1,true);
		$criteria->compare('feature2',$this->feature2,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('valuta',$this->valuta,true);
		$criteria->compare('new',$this->new);
		$criteria->compare('yml',$this->yml);
		$criteria->compare('sp',$this->sp,true);
		$criteria->compare('none',$this->none);
		$criteria->compare('soft',$this->soft,true);
		$criteria->compare('hide',$this->hide);
		$criteria->compare('sort',$this->sort,true);
		$criteria->compare('tr',$this->tr,true);
		$criteria->compare('sort_tr',$this->sort_tr,true);
		$criteria->compare('nalich',$this->nalich);
		$criteria->compare('ids_goods',$this->ids_goods,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GoodsCopy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
