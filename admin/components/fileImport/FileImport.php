<?php
/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 05.04.2017
 * Time: 14:22
 */

namespace admin\components\fileImport;


class FileImport
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var FileImportBehaviorInterface
     */
    protected $importBehavior;

    /**
     * FileImport constructor.
     * @param string $file
     * @param FileImportBehaviorInterface $importBehavior
     */
    public function __construct($file, FileImportBehaviorInterface $importBehavior)
    {
        $this->guardFileExists($file);
        
        $this->file = $file;
        $this->importBehavior = $importBehavior;
    }

    /**
     * @return array
     */
    public function getRows(){
        return $this->importBehavior->getRows($this->file);
    }

    protected function guardFileExists($file){
        if(!file_exists($file)){
            throw new \Exception('File not found');
        }
    }


}