<?php
/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 05.04.2017
 * Time: 14:24
 */

namespace admin\components\fileImport;


interface FileImportBehaviorInterface
{
    /**
     * @param string $file
     * @return array
     */
    public function getRows($file);
}