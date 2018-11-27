<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 12:11
 */
class VendorRedirectMaker extends CatalogRedirectMaker
{
    /**
     * @var Catmaker
     */
    protected $vendor;

    public function __construct($catalogId, $vendorId, $page)
    {
        $this->vendor = Catmaker::model()->findByPk($vendorId);
        if($this->vendor === null){
            throw new InvalidArgumentException('Can not find vendor');
        }
        parent::__construct($catalogId, $page);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return ($this->isSetPage()) ? $this->catalog->getUrlWithVendor($this->vendor) . $this->getPageSuffix() : $this->catalog->getUrlWithVendor($this->vendor);
    }

}