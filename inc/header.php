<?
	function get_header(){
		global $prx;
		//echo $prx;exit();
		ob_start();
		///////////////
		
		///////////////
		//print_r($_GET);		
		//Определяем данные для header,keywords и title
		//Если открыта категория
		if(isset($_GET['id_cattype'])){
			//Кусок кода ниже я скопировал из show_catalog.php
			$id_cattype = (int)@$_GET['id_cattype'];
			if(!getField("SELECT status FROM {$prx}cattype WHERE id={$id_cattype}")) { header("Location: /"); exit; }
			$id_catmaker = (int)@$_GET['id_catmaker'];
			$id_catrazdel = (int)@$_GET['id_catrazdel'];
			$id_catsr = (int)@$_GET['id_catsr'];
			// если были применены параметры
			if($_POST['ch'])
				$_SESSION['mas_ch'] = $_POST['ch'];
			else{
//				session_unregister('mas_ch');
				unset($_SESSION['mas_ch']);
			}

			// информация о каталоге
			$cattype = getRow("SELECT * FROM {$prx}cattype WHERE id='{$id_cattype}'");
			$otr = getRow("SELECT * FROM {$prx}otr WHERE id='{$cattype['id_otr']}'");
			$type_name = $cattype["name"] ? $cattype["name"]." - " : "";
			$catmaker = getRow("SELECT * FROM {$prx}catmaker WHERE id='{$id_catmaker}'");
			$catrazdel = getRow("SELECT * FROM {$prx}catrazdel WHERE id='{$id_catrazdel}'");
			$cattr = getRow("SELECT * FROM {$prx}cattr WHERE id_catrazdel='{$id_catrazdel}' AND id_cattype='{$id_cattype}'");
			$cattmr = getRow("SELECT * FROM {$prx}cattmr WHERE id_catrazdel='{$id_catrazdel}' AND id_catmaker='{$id_catmaker}' AND id_cattype='{$id_cattype}'");
			$catsr = getRow("SELECT * FROM {$prx}catsr WHERE id='{$id_catsr}' and id_cattmr='{$cattmr['id']}'");
			if($catmaker && $catrazdel && $catsr) {
				$row = $catsr; 				
			}
			elseif($cattmr) {
				$row = $cattmr; 				
			}
			elseif($cattr) { 
				$row = $cattr; 				
			}
			elseif($catmaker && $catrazdel) {
				$row = $catmaker; 				
			}
			elseif($catmaker) { 
				$row = $catmaker; 				
			}
			elseif($catrazdel) { 
				$row = $catrazdel; 				
			}
			elseif($cattype) {
				$row = $cattype; 				
			}			
			$data['title'] = $row['title'];
			$data['keywords'] = $row['name'];
			$data['description'] = $row['description'];
		//Отрасль
		}elseif(isset($_GET['show_otr'])){
			$id = (int) $_GET['id'];
			$row = getRow("SELECT * FROM {$prx}otr WHERE id='{$id}'");
			$data['title'] = $row['title'];
			$data['keywords'] = $row['name'];
			$data['description'] = $row['description'];
		//Если открыта категория
		}elseif(isset($_GET['id'])){
			$id = (int) $_GET['id'];
			$row = getRow("SELECT * FROM {$prx}catmaker WHERE id='{$id}' AND hide=0");
			$data['title'] = $row['title'];
			$data['keywords'] = $row['name'];
			$data['description'] = $row['description'];
		//Если открыт товар
		}elseif(strpos($_SERVER['REQUEST_URI'],'/tovar/')!==FALSE){
			$link = mysql_real_escape_string(trim($_GET['link']));
			$sql = "
				SELECT * FROM {$prx}goods WHERE link='{$link}';
			";
			$tempData = getRow($sql);
			$data['title'] = $tempData['name'].' | Купить по низкой цене с доставкой по РФ';
			$data['keywords'] = $tempData['name'];
			// $data['description'] = strip_tags($tempData['text1']);
		//Все остальное
		}else{			
			$link = ($_GET['link'])?mysql_real_escape_string(trim($_GET['link'])):'/';
			$sql = "
				SELECT * FROM {$prx}pages WHERE `link` = '{$link}'
			";
			$data = getRow($sql);			
		}		
		$keywords = ($data['keywords'])?$data['keywords']:set("keywords");
		$description = ($data['description'])?$data['description']:set("description");
		$title = ($data['title'])?$data['title']:set("title");		
		?>
		
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="Document-state" content="Dynamic">
	<title><?=$title?></title>
	<META NAME="keywords" CONTENT="<?=$keywords?>">
	<META NAME="description" CONTENT="<?=$description?>">
    <meta name="google-site-verification" content="1hDAItJKgR2ReLbyOaYUYiuqKEP-vmi1KSn-aDQMSKQ" />
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="/inc/style.css">
	<script language="JavaScript" src="/inc/jquery-1.5.2.js"></script>
	<script language="JavaScript" src="/inc/utils.js"></script>
	<script language="JavaScript" src="/inc/special.js"></script>

	<link type="text/css" rel="stylesheet" href="/inc/advanced/floatbox/floatbox.css">
	<script type="text/javascript" src="/inc/advanced/floatbox/floatbox.js"></script>

    <!-- всплывающие окна --->
     <script type="text/javascript" src="/inc/advanced/jB/jquery.jB.js"></script>
     <script type="text/javascript" src="/inc/advanced/jPop/jquery.jPop.js"></script>
     <link rel="stylesheet" href="/inc/advanced/jPop/jPop.css" type="text/css" />
	
    <!--[if lte IE 9]>
    <style type="text/css">
    div#fix1 {
      /* IE5.5+/Win - this is more specific than the IE 5.0 version */
      right: expression( ( 0 - ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
      top: expression( ( document.body.clientHeight/2 - 100 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
    }
    </style>
    <![endif]-->  
	<?
	return ob_get_clean();
}