<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 17:05
 */
class BrandRedirectMaker extends RedirectMaker
{
    /**
     * @var Catmaker
     */
    protected $brand;
    protected $page;

    /**
     * BrandRedirectMaker constructor.
     * @param $brand
     * @param $page
     */
    public function __construct(Catmaker $brand, $page)
    {
        $this->brand = $brand;
        $this->page = $page;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return ($this->isSetPage()) ? $this->brand->getUrl() . $this->getPageSuffix() : $this->brand->getUrl();
    }

}