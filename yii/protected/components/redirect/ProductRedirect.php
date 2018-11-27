<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 18:06
 */
class ProductRedirect implements GetRedirectUrlAble
{
    /**
     * @var Goods
     */
    protected $product;

    public function __construct($link)
    {
        $product = Goods::model()->findByAttributes(array('link' => $link));
        if($product === null){
            throw new InvalidArgumentException('Can not find product with link ' . $link);
        }
        $this->product = $product;
    }

    public function getRedirectUrl()
    {
        return $this->product->getUrl();
    }

}