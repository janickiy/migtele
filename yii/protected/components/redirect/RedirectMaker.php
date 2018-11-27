<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.06.2017
 * Time: 12:04
 */
abstract class RedirectMaker
{
    protected $page;

    /**
     * @return bool
     */
    public function isSetPage(){
        return $this->page !== null;
    }

    /**
     * @return string
     */
    protected function getPageSuffix(){
        return 'page' . $this->page . '.htm';
    }

    /**
     * @return string
     */
    abstract public function getUrl();
}