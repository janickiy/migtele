<?php
/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 05.04.2017
 * Time: 14:28
 */

namespace admin\components\fileImport;


class CsvImportBehavior implements FileImportBehaviorInterface
{
    public function getRows($file)
    {
        $handle = fopen($file, "r");
        $rows = array();

        while(($elements = fgetcsv($handle, 0, ";")) !== FALSE){
            $row = array();
            foreach($elements as $k => $element){
                $row[$k] = $element;
            }
            $rows[] = $row;
        }

        return $rows;
    }

}