<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 27.02.2017
 * Time: 11:58
 */
class Display
{
    protected $viewPrefix = 'views/';

    public static function staticRender($view, array $params = array()){
        $display = new self;
        $display->render($view, $params);
    }

    public function render($view, array $params = array()){
        global $prx;
        $view = $this->viewPrefix.$view.'.php';
        $this->guardViewExists($view);
        foreach($params as $param =>$value){
            $$param = $value;
        }
        include ($view);
    }

    protected function guardViewExists($view){
//        var_dump($view);exit();
        $view = dirname(__FILE__).'/'.$view;
//        var_dump($view);exit();
        if(!file_exists($view) || is_dir($view)){
            throw new Exception("View do not exist");
        }
    }
}