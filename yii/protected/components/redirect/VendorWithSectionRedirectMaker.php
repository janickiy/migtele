<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 12:11
 */
class VendorWithSectionRedirectMaker extends CatalogRedirectMaker
{
    /**
     * @var Catmaker
     */
    protected $vendor;

    /**
     * @var Catrazdel
     */
    protected $section;

    public function __construct($catalogId, $vendorId, $sectionId, $page)
    {
        $this->vendor = Catmaker::model()->findByPk($vendorId);
        if($this->vendor === null){
            throw new InvalidArgumentException('Can not find vendor');
        }

        $this->section = Catrazdel::model()->findByPk($sectionId);
        if($this->section === null){
            throw new InvalidArgumentException('Can not find section with id '. $sectionId);
        }

        parent::__construct($catalogId, $page);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return ($this->isSetPage()) ? $this->catalog->getUrlWithVendorAndSection($this->vendor, $this->section) . $this->getPageSuffix() : $this->catalog->getUrlWithVendorAndSection($this->vendor, $this->section);
    }

}