<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 18.01.2017
 * Time: 16:10
 */
interface ClickCounterAble
{
    /**
     * @return int
     */
    public function getClickCount();

    /**
     * @param bool $validate
     * @return bool
     */
    public function save($validate = true);

    /**
     * @param $count int - setter clickCount property
     */
    public function setClickCount($count);
}