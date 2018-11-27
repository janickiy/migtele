<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 18.01.2017
 * Time: 16:09
 */
class ClickCounter
{
    /**
     * @var ClickCounterAble
     */
    protected $model;
    /**
     * @var string
     */
    protected $host;
    /**
     * @var string
     */
    protected $referrer;

    public static function init(ClickCounterAble $model, $httpHost, $httpReferrer = null){
        $model = new self($model, $httpHost, $httpReferrer);
//        var_dump($model->doNeedIncrementCounter());
        if($model->doNeedIncrementCounter())
            $model->increment();
    }

    protected function __construct(ClickCounterAble $model, $httpHost, $httpReferrer = null)
    {
        $this->model = $model;
        $this->host = $httpHost;
        $this->referrer = $httpReferrer;
    }

    /**
     * @return bool
     */
    protected function doNeedIncrementCounter(){
//        return true;
        return $this->isSetReferrer() && !$this->doReferrerContainsHost();
    }

    /**
     * @return bool
     */
    protected function isSetReferrer(){
        return !empty($this->referrer);
    }

    /**
     * @return bool
     */
    protected function doReferrerContainsHost(){
        return (strpos($this->referrer, $this->host) !== FALSE);
    }
    /**
     * increment click count Model
     */
    protected function increment(){
        $count = $this->model->getClickCount();
        $count++;
        $this->model->setClickCount($count);
        $this->model->save(false);
        
    }
}