<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 12:01
 */
class CatalogRedirectMaker extends RedirectMaker
{
    /**
     * @var Cattype
     */
    protected $catalog;
    protected $page;

    /**
     * CatalogRedirectMaker constructor.
     * @param $catalogId
     * @param $page
     */
    public function __construct($catalogId, $page)
    {
        $this->catalog = Cattype::model()->findByPk($catalogId);
        if($this->catalog === null){
            throw new InvalidArgumentException('Can not find catalog');
        }
        $this->page = $page;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return ($this->isSetPage()) ? $this->catalog->getUrl() . $this->getPageSuffix() : $this->catalog->getUrl();
    }


}