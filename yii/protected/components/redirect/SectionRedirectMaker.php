<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 12:11
 */
class SectionRedirectMaker extends CatalogRedirectMaker
{
    /**
     * @var Catrazdel
     */
    protected $section;

    public function __construct($catalogId, $sectionId, $page)
    {
        $this->section = Catrazdel::model()->findByPk($sectionId);
        if($this->section === null){
            throw new InvalidArgumentException('Can not find section');
        }
        parent::__construct($catalogId, $page);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return ($this->isSetPage()) ? $this->catalog->getUrlWithSection($this->section) . $this->getPageSuffix() : $this->catalog->getUrlWithSection($this->section);
    }

}