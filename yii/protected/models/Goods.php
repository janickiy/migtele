<?php

/**
 * This is the model class for table "{{goods}}".
 *
 * The followings are the available columns in table '{{goods}}':
 * @property string $id
 * @property string $id_cattmr
 * @property string $id_catsr
 * @property string $kod
 * @property string $kod2
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
 * @property integer $valid
 * @property integer $importNew
 * @property integer $clickCount
 *
 * @property Catmaker $vendor
 */
class Goods extends CActiveRecord implements ClickCounterAble
{
	const AVIABILITY_FALSE = 0;
	const AVIABILITY_TRUE = 1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods}}';
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
			array('new, yml, none, hide, nalich, valid', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('id_cattmr, sort, sort_tr', 'length', 'max'=>10),
			array('id_catsr', 'length', 'max'=>11),
			array('kod, kod2, name, link, tr, ids_goods', 'length', 'max'=>250),
			array('valuta', 'length', 'max'=>3),
			array('sp', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cattmr, id_catsr, kod, kod2, name, link, text1, text2, text3, text4, text5, teh, feature1, feature2, price, valuta, new, yml, sp, none, soft, hide, sort, tr, sort_tr, nalich, ids_goods, valid', 'safe', 'on'=>'search'),
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
			'kod2' => 'Kod2',
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
			'valid' => 'Valid',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods the static model class
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

    /**
     * @return Catmaker
     */
	public function getVendor(){
        $command = Yii::app()->db->createCommand();
        /**@var $command CDbCommand*/
	    $vendorId = $command->select('id_catmaker')->from('{{cattmr}}')->where('id = :id', array(':id' => $this->id_cattmr))->queryScalar();

	    return Catmaker::model()->findByPk($vendorId);
    }

    /**
     * @return string
     */
    public function getUrl(){
	    return 'tovar/'.$this->link.'.htm';
    }


}
