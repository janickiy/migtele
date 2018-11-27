<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 16:37
 */
class OtraslRedirect implements GetRedirectUrlAble
{
    /**
     * @var Otr
     */
    private $industry;

    /**
     * OtraslRedirect constructor.
     * @param $industryId
     */
    public function __construct($industryId)
    {
        $industry = Otr::model()->findByPk($industryId);
        if($industry === null){
            throw new InvalidArgumentException('Can not find industry with id '.$industryId);
        }

        $this->industry = $industry;
    }


    public function getRedirectUrl(){
        return $this->industry->getUrl();
    }
}