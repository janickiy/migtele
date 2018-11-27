<?
/***  ПРИМЕР ЮЗАНИЯ  ***

	require('inc/excel_export.php');
	$xls = new PhpToExcell();
	$xls->ExBOF();
	$xls->Rus();
	
	$xls->WriteLabel($y,$x,0,0,0,$value); // $x - столбец, $y - строка, $value - значение
	// кроме WriteLabel также есть функции для записи других типов данных
	
	$xls->ExEOF();
	
	$xls->SendFileToHTTP('имя файла'); // передать файл пользователю на закачку
	// или
	$xls->SaveToFileXls('путь к файлу'); // сохранить в файл
	
/***  ПРОСТОЙ ВАРИАНТ  ***

  header("Content-type: application/x-msexcel"); 
  header("Content-Disposition: attachment; filename=file.xls");

// и нахотеимелить обычную теблицу :)

*************************/

/****************************************************************
* Script         : PHP скрипт формирования отчетов в Excell файл
* Author         : LiO <lio@lio.kz>
* Version        : 0.1
* Copyright      : GNU LGPL
* URL            : http://lio.kz
* Last modified  : 08.07.2004
* Description    : Объект формирования xls файла. Файл может быть
* сохранен физически на диск для дальнейшей работы (передача,
* отправка на e-mail и т.д.). Так же можно сразу "показать" структуру
* Данный скрипт поддерживает формат Excell 5, с ограничениями -
* не более 255 столбцов, и 65535 строк.
*
* Отлечистельные особенности от других скриптов
*  1. Формирования атрибутов ячеек (обрамление)
*  2. Отдельная запись целых чисел и вещественных
*  3. Корректировка стилей шрифтов и размера
******************************************************************/


 class  PhpToExcell {
    var  $data   = "";          // данные структуры

    // формирования заголовка открытия
    function  ExBOF()
     {
       // begin of the excel file header
       $this->data = pack("c*", 0x09, 0x00, 0x04, 0x00, 0x02, 0x00, 0x10, 0x0);
     }
     
    // формирования заголовка закрытия
    function  ExEOF()
     {
     $this->data .= pack("cc", 0x0A, 0x00);
     }
     
    // Переводит в строку attr1..3
    function RowAttr($attr1,$attr2,$attr3)
    {
     return chr($attr1).chr($attr2).chr($attr3);
    }

    // устанавливает русский язык в структура xls
    function Rus()
    {
     $this->data .= (chr(0x42).chr(0x00).chr(0x02).chr(0x00).chr(0x01).chr(0x80));
    }

    // запись строки
    // Col,Row - колонка и строка
    // attr1 - атрибут показа ячейки и защита от записи
    // attr2 - размер шрифта
    // attr3 - обрамление ячейки
    // для формирования атрибутов используйте соотвествующие функции
    function WriteLabel($Col,$Row,$attr1=0,$attr2=0,$attr3=0,$value) // { Запись String }
    {
     $i=strlen($value);
     $this->data .= pack("v*",0x04,8+$i,$Col,$Row);
     $this->data .= $this->RowAttr($attr1,$attr2,$attr3);
     $this->data .= pack("c",$i);
     $this->data .= $value;
    }

    // установка ширины колонки  Width*1/256
    //                           3000 - 100% }
    function ColWidth($ColFirst,$ColLast,$Width)
    {
      $this->data .= (CHR(0x24).CHR(00).Chr(04).CHR(00).chr($ColFirst).chr($ColLast).pack('s',$Width));
    }

    // Управляет видом колонок и строк при
    // ReferenceMode=1 Стиль ссылок = R1C1
    // ReferenceMode=0 Стиль ссылок стандартный A1...
    function RefMode($ReferenceMode=1)
    {
     if ($ReferenceMode==1)
     {
      $this->data .= (CHR(0x0f).chr(0x00).chr(2).chr(0x00).chr(0x00).chr(0x00));
     } else
      {
       $this->data .= (CHR(0x0f).chr(0x00).chr(2).chr(0x00).chr(0x00).chr(0x01));
      }
    }

    // запись целого числа
    function WriteInteger($Col,$Row,$attr1,$attr2,$attr3,$value=0)
    {
     $this->data.=pack("v*",0x02,0x09,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
     $this->data.=pack("v",$value);
    }

    // запись дробного числа
    function WriteNumber($Col,$Row,$attr1,$attr2,$attr3,$value=0.00)
    {
     $this->data.=pack("v*",0x03,0x0F,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
     $this->data.=pack("d",$value);

    }
    // запись пустой ячейки
    function WriteBlank($Col,$Row,$attr1,$attr2,$attr3)
    {
     $this->data.=pack("v*",0x01,0x07,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
    }

    // Установка шрифта. Height*1/20
    //      Для 10 пунктов Height = 200   }
    function Font($Height,$Bold=0,$Italic=0,$Underline=0,$StrikeOut=0,$FontName)
    {
     $i=strlen($FontName);
     $this->data.=CHR(0x31).chr(0x00).Chr($i+5).chr(0x00);
     $this->data.=pack("v",$Height);
     $k=0;
     if ($Bold==1) $k=$k|1;
     if ($Italic==1) $k=$k|2;
     if ($Underline==1) $k=$k|4;
     if ($StrikeOut==1) $k=$k|8;
     $this->data.=pack("v",$k);
     $this->data.=chr($i);
     $this->data.=$FontName;
    }

    // Формируем аттрибут №1 ($Attr1)
    // $CellHidden - скрыть формулы
    // $CellLocked - защищенная ячейка
    function Attr1($CellHidden=0,$CellLocked=0)
    {
     $r=0x0;
     if ($CellHidden==1)$r=$r|128;
     if ($CellLocked==1)$r=$r|64;
     return $r;
    }
    
    // Формируем аттрибут №2 ($Attr2)
    // $FontNumber 0..3
    function Attr2($FontNumber=0)
    {
     $r=0;
     switch ($FontNumber)
     {
      case 1:
            $r=64;
            break;
      case 2:
            $r=128;
            break;
      case 3:
            $r=129;
            break;
      }
      return $r;
    }
    
    // Формируем аттрибут №3 ($Attr3)
    // Alignment  0 - General
    //            1 - left
    //            2 - center
    //            3 - Right
    //            4 - Fill
    function Attr3($Shaded=0,$BottomBorder=0,$TopBorder=0,$RightBorder=0,$LeftBorder=0,$Alignment=0)
    {
     $r=0;
     if ($Shaded==1) $r=$r|128;
     if ($BottomBorder==1) $r=$r|64;
     if ($TopBorder==1) $r=$r|32;
     if ($RightBorder==1) $r=$r|16;
     if ($LeftBorder==1) $r= $r|8;
     if ($Alignment<8) $r=$r|$Alignment;
     return $r;
    }
    
    // сохранение данных в xls файл
    function SaveToFileXls($FName='file.xls')
    {
     $fp = fopen( $FName, "wb" );
     fwrite( $fp,$this->data);
     fclose( $fp );
    }
    
    // показать структуру в web
    function SendFileToHTTP($FName='file.xls')
    {
     header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
     header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
     header ( "Cache-Control: no-cache, must-revalidate" );
     header ( "Pragma: no-cache" );
     header ( "Content-type: application/x-msexcel" );
     header ( "Content-Disposition: attachment; filename=".$FName );
     print $this->data;
    }
  }

?>
