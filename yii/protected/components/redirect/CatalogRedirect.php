<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 11:53
 */
class CatalogRedirect implements GetRedirectUrlAble
{
    private $categoryId;
    private $vendorId;
    private $sectionId;
    private $page;

    /**
     * CatalogRedirect constructor.
     * @param $categoryId
     * @param $vendorId
     * @param $sectionId
     * @param $page
     */
    public function __construct($categoryId, $vendorId, $sectionId, $page)
    {
        $this->categoryId = $categoryId;

        if($this->categoryId === null){
            throw new InvalidArgumentException('categoryId can not be null');
        }

        $this->vendorId = $vendorId;
        $this->sectionId = $sectionId;
        $this->page = $page;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(){
        return $this->getRedirectObject()->getUrl();
    }

    /**
     * @return RedirectMaker
     */
    private function getRedirectObject(){
        if($this->isItCategory()){
            return new CatalogRedirectMaker($this->categoryId, $this->page);
        }
        if($this->isItCategoryWithVendor()){
            return new VendorRedirectMaker($this->categoryId, $this->vendorId, $this->page);
        }
        if($this->isItCategoryWithSection()){
            return new SectionRedirectMaker($this->categoryId, $this->sectionId, $this->page);
        }
        if($this->isItCategoryWithVendorAndSection()){
            return new VendorWithSectionRedirectMaker($this->categoryId, $this->vendorId, $this->sectionId, $this->page);
        }

        throw new InvalidArgumentException('Can not find redirect object');
    }

    /**
     * @return bool
     */
    private function isItCategory(){
        return $this->sectionId == null && $this->vendorId == null;
    }

    /**
     * @return bool
     */
    private function isItCategoryWithVendor(){
        return $this->sectionId == null && $this->vendorId != null;
    }

    /**
     * @return bool
     */
    private function isItCategoryWithSection(){
        return $this->sectionId != null && $this->vendorId == null;
    }

    /**
     * @return bool
     */
    private function isItCategoryWithVendorAndSection(){
        return $this->sectionId != null && $this->vendorId != null;
    }


}