<?
/***  ������ ������  ***

	require('inc/excel_export.php');
	$xls = new PhpToExcell();
	$xls->ExBOF();
	$xls->Rus();
	
	$xls->WriteLabel($y,$x,0,0,0,$value); // $x - �������, $y - ������, $value - ��������
	// ����� WriteLabel ����� ���� ������� ��� ������ ������ ����� ������
	
	$xls->ExEOF();
	
	$xls->SendFileToHTTP('��� �����'); // �������� ���� ������������ �� �������
	// ���
	$xls->SaveToFileXls('���� � �����'); // ��������� � ����
	
/***  ������� �������  ***

  header("Content-type: application/x-msexcel"); 
  header("Content-Disposition: attachment; filename=file.xls");

// � ������������� ������� ������� :)

*************************/

/****************************************************************
* Script         : PHP ������ ������������ ������� � Excell ����
* Author         : LiO <lio@lio.kz>
* Version        : 0.1
* Copyright      : GNU LGPL
* URL            : http://lio.kz
* Last modified  : 08.07.2004
* Description    : ������ ������������ xls �����. ���� ����� ����
* �������� ��������� �� ���� ��� ���������� ������ (��������,
* �������� �� e-mail � �.�.). ��� �� ����� ����� "��������" ���������
* ������ ������ ������������ ������ Excell 5, � ������������� -
* �� ����� 255 ��������, � 65535 �����.
*
* �������������� ����������� �� ������ ��������
*  1. ������������ ��������� ����� (����������)
*  2. ��������� ������ ����� ����� � ������������
*  3. ������������� ������ ������� � �������
******************************************************************/


 class  PhpToExcell {
    var  $data   = "";          // ������ ���������

    // ������������ ��������� ��������
    function  ExBOF()
     {
       // begin of the excel file header
       $this->data = pack("c*", 0x09, 0x00, 0x04, 0x00, 0x02, 0x00, 0x10, 0x0);
     }
     
    // ������������ ��������� ��������
    function  ExEOF()
     {
     $this->data .= pack("cc", 0x0A, 0x00);
     }
     
    // ��������� � ������ attr1..3
    function RowAttr($attr1,$attr2,$attr3)
    {
     return chr($attr1).chr($attr2).chr($attr3);
    }

    // ������������� ������� ���� � ��������� xls
    function Rus()
    {
     $this->data .= (chr(0x42).chr(0x00).chr(0x02).chr(0x00).chr(0x01).chr(0x80));
    }

    // ������ ������
    // Col,Row - ������� � ������
    // attr1 - ������� ������ ������ � ������ �� ������
    // attr2 - ������ ������
    // attr3 - ���������� ������
    // ��� ������������ ��������� ����������� �������������� �������
    function WriteLabel($Col,$Row,$attr1=0,$attr2=0,$attr3=0,$value) // { ������ String }
    {
     $i=strlen($value);
     $this->data .= pack("v*",0x04,8+$i,$Col,$Row);
     $this->data .= $this->RowAttr($attr1,$attr2,$attr3);
     $this->data .= pack("c",$i);
     $this->data .= $value;
    }

    // ��������� ������ �������  Width*1/256
    //                           3000 - 100% }
    function ColWidth($ColFirst,$ColLast,$Width)
    {
      $this->data .= (CHR(0x24).CHR(00).Chr(04).CHR(00).chr($ColFirst).chr($ColLast).pack('s',$Width));
    }

    // ��������� ����� ������� � ����� ���
    // ReferenceMode=1 ����� ������ = R1C1
    // ReferenceMode=0 ����� ������ ����������� A1...
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

    // ������ ������ �����
    function WriteInteger($Col,$Row,$attr1,$attr2,$attr3,$value=0)
    {
     $this->data.=pack("v*",0x02,0x09,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
     $this->data.=pack("v",$value);
    }

    // ������ �������� �����
    function WriteNumber($Col,$Row,$attr1,$attr2,$attr3,$value=0.00)
    {
     $this->data.=pack("v*",0x03,0x0F,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
     $this->data.=pack("d",$value);

    }
    // ������ ������ ������
    function WriteBlank($Col,$Row,$attr1,$attr2,$attr3)
    {
     $this->data.=pack("v*",0x01,0x07,$Col,$Row);
     $this->data.=$this->RowAttr($attr1,$attr2,$attr3);
    }

    // ��������� ������. Height*1/20
    //      ��� 10 ������� Height = 200   }
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

    // ��������� �������� �1 ($Attr1)
    // $CellHidden - ������ �������
    // $CellLocked - ���������� ������
    function Attr1($CellHidden=0,$CellLocked=0)
    {
     $r=0x0;
     if ($CellHidden==1)$r=$r|128;
     if ($CellLocked==1)$r=$r|64;
     return $r;
    }
    
    // ��������� �������� �2 ($Attr2)
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
    
    // ��������� �������� �3 ($Attr3)
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
    
    // ���������� ������ � xls ����
    function SaveToFileXls($FName='file.xls')
    {
     $fp = fopen( $FName, "wb" );
     fwrite( $fp,$this->data);
     fclose( $fp );
    }
    
    // �������� ��������� � web
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
