<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 18.01.2017
 * Time: 16:39
 * Mock for imitate ClickCounterAble model
 */
class ClickerCounterAbleMockModel implements ClickCounterAble
{
    /**
     * @return int
     */
    public function getClickCount()
    {
        return 0;
    }

    /**
     * @param bool $validate
     * @return bool
     */
    public function save($validate = true)
    {
        return true;
    }

    /**
     * @param $count int - setter clickCount property
     */
    public function setClickCount($count)
    {

    }

}