<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 27.02.2017
 * Time: 12:36
 */
class GoodSaver
{
    public static function save($data, $files, array $params = array(), $massSave = false){

        var_dump($data);
        global $prx;
//        var_dump($files); exit();
        foreach($params as $key=>$value){
            $$key = $value;
        }
        foreach($data as $key=>$val){
            $$key = clean($val);

            if(in_array($key, ['id_catsr', 'yml', 'hide', 'nalich', 'valid', 'importNew', 'sale'])){
                $$key = $$key ? $$key : 0;
            }
        }

//        var_dump($id_cattmr);
        if(!$id_cattmr && !$massSave){
            errorAlert("Укажите расположение");
        }

        $link = makeUrl($name);

        if(!$name){
            if(!$massSave){
                errorAlert("Введите название");
            }else{
                return false;
            }
        }

//        var_dump($id);exit();
        if(getField("SELECT count(*) AS c FROM {$prx}goods WHERE id<>'{$id}' AND link='{$link}'")){
            if(!$massSave){
                errorAlert("Товар с такой ссылкой уже существует");
            }else{
                return false;
            }
        }


        $price = str_replace(",",".",$price);


        $nalich = isset($nalich) ? $nalich : 0;
        $hide = isset($hide) ? $hide : 0;
        $importNew = isset($importNew) ? $importNew : 0;
        $price = is_numeric($price) ? $price : 0;


        $id_cattmr = (integer)$id_cattmr;

        $set = "id_cattmr='{$id_cattmr}', id_catsr='{$id_catsr}', nalich='{$nalich}', sale='{$sale}', name='{$name}', link='{$link}', kod='{$kod}', kod2='{$kod2}', text1='{$text1}', text2='{$text2}', 
						price='{$price}', valuta='{$valuta}', yml='{$yml}', hide='{$hide}',  soft='{$soft}', warranty_text='{$warranty_text}', delivery_text='{$delivery_text}'";
        $set .= ", importNew = '{$importNew}'";

        if(!$id){
            $set .= ", price_markup = ".rand(5, 15);
        }

        $set .= $id ? ", updated_at = NOW()" : ", created_at = NOW()";

        if($id = update('goods', $set, $id))
        {

            saveInterestedProducts($id, 'product');

            // обновляем "дополнительные" таблицы
            foreach(array("img") as $t)
                sql("UPDATE {$prx}goods_{$t} SET id_goods='{$id}' WHERE id_goods='0'");

//            updateOnlinePrice();

            // загружаем картинки
//            if(sizeof((array)$_FILES['gimg']['name']))
            if($files)
            {
//                foreach($_FILES['gimg']['name'] as $num=>$null)
                foreach((array) $files as $num => $file)
                {
//                    if(!$_FILES['gimg']['name'][$num]) continue;
                    if(!$file) continue;

                    // сохраняем в базе
                    if($id_img = update('goods_img',"id_goods='{$id}', text=' '"))
                    {
                        $path = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img}.jpg";
//                        @move_uploaded_file($_FILES['gimg']['tmp_name'][$num],$path);
                        @move_uploaded_file($file, $path);
                        @chmod($path,0644);
                    }
                }
            }

            // удаляем картинки
            foreach($data['imdel'] as $id_img)
            {
                update('goods_img','',$id_img);
                @unlink("../uploads/goods_img/{$id}.jpg");
            }

            /**
             * Ip manager log
             */

            ipManagerLog($id, $log_start);

        }
        else
            errorAlert('Ошибка при сохранении данных!');
    }
}