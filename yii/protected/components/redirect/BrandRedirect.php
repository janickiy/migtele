<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 17:01
 */
class BrandRedirect implements GetRedirectUrlAble
{
    private $vendor;
    private $page;

    /**
     * VendorRedirect constructor.
     * @param $vendorId
     * @param $page
     */
    public function __construct($vendorId, $page)
    {
        $vendor = Catmaker::model()->findByPk($vendorId);
        if ($vendor === null) {
            throw new InvalidArgumentException('Can not find vendor with ID ' . $vendorId);
        }
        $this->vendor = $vendor;
        $this->page = $page;
    }


    public function getRedirectUrl()
    {
        $redirectMaker = new BrandRedirectMaker($this->vendor, $this->page);
        return $redirectMaker->getUrl();
    }

}