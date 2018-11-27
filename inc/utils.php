<?
// ������� ���� � ������ ���� ������
function formatDateTime($datetime="00.00.0000 00:00:00") // ����� ���������� ������ ����
{
	$datetime = explode(" ",$datetime); 
	$date = explode(".",$datetime[0]); 
	$time = explode(":",$datetime[1]); 
	$res = @mktime((int)$time[0],(int)$time[1],(int)$time[2],$date[1],$date[0],$date[2]);
	if(!$res)
		return "";
		
	$datetime = @$datetime[1] 
		? @date("Y-m-d H:i:s", $res)
		: @date("Y-m-d", $res);
	
	return $datetime;
}

// ���������� ������ � ���������� � �������
function clean($str, $strong=false) 
{
	$str = trim($str);
	$str = stripslashes($str);
	if($strong)
	{
		$str = ereg_replace(" +", " ", $str); // ������� ������������� �������		
		$str = htmlspecialchars($str); //��������������� ���� html
		$str = strtr($str, array("'"=>"&#0039;", "'"=>"&#0039;"));
	}
	else
		$str = addslashes($str);
	return $str;
}

//������� ������ ��� ���� ���������� � �������� � JAVASCRIPT
function cleanJS($str) 
{
	$str = preg_replace('#[\n\r]+#', '\\n', $str); // ������� �������� �����
	$str = str_replace("'","\"",$str); // ������� '
	$str = str_replace("script>","scr'+'ipt>",$str); // ����� ����� ���� �������� ������
   return $str;
}

// ������������ ��������� 
function lnkPages($sql, $p=1, $k=40, $get="?p=%s") // (������, ������� ��������, ���-�� ����� �� ��������, ������ �� ������ ��������)
{
	ob_start();
	$res = sql($sql);
	if(mysql_num_rows($res))
	{
		$n = ceil(mysql_num_rows($res)/$k); // ���������� �������
		$en = ($p+4<9 ? 9 : $p+4); // ��������� ����� �������� (��� �����)
		$en = ($en>$n ? $n : $en); 
		$st = ($en-8>0 ? $en-8 : 1); // ������ ����� �������� (��� �����)	?>
		
		<div id="lnkPages">
			<a href="<?=(($p-1<=0) ? "#" : sprintf($get,$p-1))?>">&laquo;</a>&nbsp;&nbsp;
		<?	if($st > 1) { // ������ ������ �� ������ �������� (���� ����) ?>
				<a href="<?=sprintf($get,1)?>">1</a>&nbsp;<?=($st>2 ? "&nbsp;...&nbsp;" : "")?>
		<?	}	
			for($i=$st; $i<=$en; $i++) { // ������ ������ �� �������� �� ����� ?>
				<a href="<?=sprintf($get,$i)?>" <?=($p==$i ? "class='active'" : "")?>><?=$i?></a>&nbsp;
		<?	} 
			if($en < $n) { // ������ ������ �� ��������� �������� (���� ����) ?>
				<?=($en<$n-1 ? "...&nbsp;" : "")?>&nbsp;<a href="<?=sprintf($get,$n)?>"><?=$n?></a>&nbsp;
		<?	}	?>	
			&nbsp;<a href="<?=(($p+1>$n) ? "#" : sprintf($get,$p+1))?>">&raquo;</a>
		</div>
<?	}
	return ob_get_clean();
}

// ���������� �� ����� �������� ���� ������
function getPage($sql, $id, $k=40) // ������, id-������, ���-�� ������� �� ��������
{	
	$res = sql($sql);
	$n=1; 
	while($row = mysql_fetch_array($res)) 
		if($id==$row[0]) 
			break; 
		else 
			$n++;
	return ceil($n/$k);
}

// ���������� �������� ���������� �� ������� settings
function set($name)
{
	global $prx;
	$sql = "SELECT value FROM {$prx}settings WHERE id='{$name}'";
	$res = sql($sql);

	if(!mysql_num_rows($res) && @$_SESSION['priv'])
		echo(nl2br($sql));

	$value = mysql_result($res,0,0);
	return $value;
}	

// �������� ���� �������� �� �������
function getField($sql)
{
	$res = sql($sql); 
	$field = @mysql_result($res,0,0);
	return $field;
}	
// �������� ������ ������ ������ �������
function getRow($sql)
{
	$res = sql($sql); 
	$row = mysql_fetch_array($res);
	return $row;
}	

// �������� ������ ����� �������
function getArr($sql, $simple=true) // $simple=true - ��������� "�������" ������ (��� �������� � ����� �������)
{
	$res = sql($sql);
	if($simple)
	{
		while($row = mysql_fetch_array($res))
			if(mysql_num_fields($res)>1)
				$arr[$row[0]] = $row[1];
			else
				$arr[] = $row[0];
	}
	else
		while($row = mysql_fetch_array($res))
			$arr[] = $row;

	return @$arr;
}	

// ������ mysql_query - ������� ����� ������� � ������ �������
function sql($sql, $debug=false)
{
	global $debugSql;
	$res = mysql_query($sql);
	if((!$res && @$_SESSION['priv']) || $debugSql || $debug)
	{
		$text = $sql."\r\n".mysql_error()."\r\n";
		echo nl2br($text);
		?><script>
			if(top.window !== window && <?=(!$debugSql && !$debug ? "true" : "false")?>) // ���� �� �� ������, �� ������� ����� � ��������� �����
			{
			    console.log('<?=cleanJS($text)?>');
				alert('<?=cleanJS($text)?>');
				location.href = "/inc/none.html";
			}
		</script><?
	}
	return $res;
}

// ���������� ������/������������ ��� �������/�������
function dll($obj, $properties, $value="", $default=NULL) // ������/������, ��-�� ������, �������� (����� ���� ��������), "������" ��������(����� ���� ��������)
{ 
	ob_start();
?>
	<select <?=$properties?>>
	<?	if($default !== NULL)
			if(is_array($default)) {	?>
				<option value="<?=$default[0]?>"><?=$default[1]?></option>
		<?	} else { ?>
				<option value=""><?=$default?></option>
		<?	}
		$arr = is_array($obj) ? $obj : getArr($obj);
		foreach($arr as $key=>$val)
		{ 
			$selected = is_array($value) ? in_array($key, $value) : $key==$value;
		?>	<option value="<?=$key?>" <?=($selected ? "selected" : "")?>><?=$val?></option>
	<? } ?>
	</select>
<? 	
	return ob_get_clean();
}
// ���������� ������ ��� ���� enum
function dllEnum($sql, $properties, $value="") // $sql="SHOW COLUMNS FROM tbl LIKE 'fill'", ��-�� ������, ��������
{ 
	ob_start();
?>
	<select <?=$properties?>>
	<? $res = sql($sql);
		$val = mysql_result($res,0,1);
		$val = str_replace(array("enum(",")","'"), "", $val);
		$arr = explode(",",$val);
		foreach($arr as $val) { ?>
			<option value="<?=$val?>" <?=($val==$value ? "selected" : "")?>><?=$val?></option>
	<? } ?>
	</select>
<? 	
	return ob_get_clean();
}

// �������� ������ ������ �������
function aMail_($to, $subject="", $message="", $from="", $files="", $html=true, $charset="windows-1251") // ����������, ����, ���������, �����������, ���� ��� ������ ������, � HTML, ���������
{
	$random_hash = md5(date('r', time()));
	// ��������� ���������
	$headers = $from ? "From: {$from}\r\nReply-To: {$from}\r\n" : "";
	$headers .= "Content-Type: multipart/mixed; boundary=\"{$random_hash}\"";
	// ��������� ���� ������
	// �������� $message � ���� doctype, ���� ����� ����������� ���������� HTML
	$message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitinal//EN\">\n<html><head><meta http-equiv=Content-Type content=\"text/html; charset={$charset}\"><META content=\"MSHTML 6.00.2800.1276\" name=GENERATOR></head><body>".$message."</body></html>";
	$body =	"--{$random_hash}\r\nContent-Type: text/".($html ? "html" : "plain")."; charset=\"{$charset}\"\r\n".
				"Content-Transfer-Encoding: 8bit\r\n\r\n".$message."\r\n\r\n";
	
	// ��������� � ���� ������ ����� (���� ����)
	if($files)
		foreach((array)$files as $file) {
			$file = array("data"=>chunk_split(base64_encode(file_get_contents($file))), "name"=>basename($file));
			$body .= "--{$random_hash}\r\nContent-Type: application/octet-stream; name=\"{$file['name']}\"\r\n".
						"Content-Transfer-Encoding: base64\r\nContent-Disposition: attachment\r\n\r\n".$file['data']."\r\n\r\n";
		}
	$body .= "--{$random_hash}--";
	//mb_convert_encoding( $string, "UTF-8", "BASE64");
	return @mail($to, $subject, $body, $headers);
}

// �������� ������ ������� HTML
function aMail($to, $subject="", $message="", $from="", $files="", $html=true, $charset="windows-1251") // ����������, ����, ���������, �����������, ���� ��� ������ ������, � HTML, ���������
{
	$headers  = "Content-type: text/html; charset={$charset} \r\n";
	if($from)
		$headers .= "From: {$from}\r\n";
	//$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($subject, "w","k")).'?=';
	return @mail($to, $subject, $message, $headers);
}


// PHP ��������� �� Windows-1251 � UTF-8, ������: iconv("windows-1251", "utf-8", $text);
function win2utf($s)
{
	for($i=0, $m=strlen($s); $i<$m; $i++)
	{
		$c=ord($s[$i]);
		if($c<=127) {
			@$t.=chr($c); continue; 
		}
		if($c>=192 && $c<=207) {
			@$t.=chr(208).chr($c-48); continue; 
		}
		if($c>=208 && $c<=239) {
			@$t.=chr(208).chr($c-48); continue; 
		}
		if($c>=240 && $c<=255) {
			@$t.=chr(209).chr($c-112); continue; 
		}
		if($c==184) { 
			@$t.=chr(209).chr(209);	continue; 
		}
		if($c==168) { 
			@$t.=chr(208).chr(129);	continue; 
		}
	}
	return $t;
}
// PHP ��������� �� UTF-8 � Windows-1251, ������: iconv("utf-8", "windows-1251", $text);
function utf2win($fcontents) 
{
	$out = $c1 = '';
	$byte2 = false;
	for($c=0; $c<strlen($fcontents); $c++)
	{
		$i = ord($fcontents[$c]);
		if ($i <= 127)
			$out .= $fcontents[$c];

		if($byte2) 
		{
			$new_c2 = ($c1 & 3) * 64 + ($i & 63);
			$new_c1 = ($c1 >> 2) & 5;
			$new_i = $new_c1 * 256 + $new_c2;
			if($new_i == 1025)
				$out_i = 168;
			else 
			{
				if($new_i == 1105)
					$out_i = 184;
				else
					$out_i = $new_i-848;
			}
			$out .= chr($out_i);
			$byte2 = false;
		}
		if(($i >> 5) == 6) 
		{
			$c1 = $i;
			$byte2 = true;
		}
	}
	return $out;
}

// �������������� ������
function trans($str) { 
	$str = strtr($str,  
		"������������������������������������������������", 
		"abvgdegziyklmnoprstufhieABVGDEGZIYKLMNOPRSTUFHIE" 
	); 
	$str = strtr($str, array( 
		'�'=>"yo",	'�'=>"ts",	'�'=>"ch",	'�'=>"sh",	'�'=>"shch",
		'�'=>"",		'�'=>"",		'�'=>"yu",	'�'=>"ya", 
		'�'=>"Yo",	'�'=>"Ts",	'�'=>"Ch",	'�'=>"Sh",	'�'=>"Shch",
		'�'=>"",		'�'=>"",		'�'=>"Yu",	'�'=>"Ya" 
	)); 
	return $str;
}
// �������� ����� � ���������� ��� ������
function makeUrl($str)
{
	$str = trans($str);
	$str = str_replace(array(" ",".",","), "_", $str);
	$str = strtolower($str);
	$str = preg_replace('#[^a-z0-9_\-]#isU','',$str); // ��������� ������ �����, �����, - � _
	return $str; 
}

// ������������ ��� ����� �� ������ - ��� � ����������(� ������)
function expFileName($path) // ���� � �����
{
	$file = basename($path);
	$ext = explode('.', $file);
	if(count($ext)>1)
	{
		$ext = ".".$ext[count($ext)-1];
		$file = substr($file, 0, -strlen($ext));
	}
	else
		$ext = "";
	return array($file, $ext);
}

// ��������� ������
function getPwd($n=10) // ����� ������
{
	$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$pass = "";
	for($i=0; $i<$n; $i++) 
		$pass .= $str[rand(0,strlen($str)-1)];
	return $pass;
}

// ����� ALERT �� ������ (� ���������� ����������)
function errorAlert($msg)
{
	?><script>
		alert("<?=$msg?>");
		top.showLoad(false);
//		top.topBack(<?//=count(@$_POST)?>//);
	</script><?
	exit;
}

// ���������� ������� ����� (ajax) (������������ ��� �������)
function debug($exit=true)
{
	?><script>
		_ajax = top.document.getElementById("ajax");
		_ajax.style.display = "block";
	</script><?
	if($exit)
		exit;
}

// ������� ����� �� HTML � RGB
function html2rgb($color="#FFFFFF")
{
	$color = substr($color, 1);
	
	list($r, $g, $b) = strlen($color)==6
		? array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5])
		: array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	
	return array(hexdec($r), hexdec($g), hexdec($b));
}
// ������� ����� �� RGB � HTML
function rgb2html($r=255, $g=255, $b=255)
{
	foreach(array(dechex($r), dechex($g), dechex($b)) as $c)
		@$color .= (strlen($c)<2 ? '0' : '').$c;

	return '#'.$color;
}

// ���������� / ���������� / �������� ������ � �������
function update($table, $set="", $id=0) // �������, ����������� ����, id (��� �������� id ����� ���� �������� ��� ������� ����� ',')
{
	global $prx;
	
	if(!$set)
	{
		if(is_array($id))
			$id = "'".implode("','",$id)."'";
		sql("DELETE FROM {$prx}{$table} WHERE id IN ({$id})");
		return;
	}
	
	if($id)
	{
		sql("UPDATE {$prx}{$table} SET {$set} WHERE id='{$id}'");
	}
	else
	{
		sql("INSERT INTO {$prx}{$table} SET {$set}");
		$id = mysql_insert_id();
	}
	return $id;
}

// ���������� ��������� �����
function setVisit()
{
	global $prx;
	if(!getField("SELECT COUNT(*) AS c FROM {$prx}visit_day WHERE date='".date("Y-m-d")."'"))
		if($date = getField("SELECT date FROM {$prx}visit_day LIMIT 1"))
		{
			$all = getField("SELECT COUNT(*) AS c FROM {$prx}visit_day");
			$unic = count(getArr("SELECT DISTINCT ip FROM {$prx}visit_day"));
			update("visit_all","date='{$date}', whole='{$all}', unic='{$unic}'");
			sql("TRUNCATE TABLE {$prx}visit_day");
		}
	update("visit_day","date=NOW(), ip='{$_SERVER['REMOTE_ADDR']}'");
}

// �������� �������� ��������� POST-���������
function file_post_contents($url="http://", $post_arr=array("var"=>"value")) // ����� ��������, ������ POST-����������
{
	$postfields = http_build_query($post_arr);  
	$opts["http"] = array(  
		'method'  => 'POST',  
		'header'  => 'Content-type: application/x-www-form-urlencoded',  
		'content' => $postfields
	);  
	$context  = stream_context_create($opts);  
	return file_get_contents($url, false, $context);  
}

// ���������� ���� ������
function getKurs($valuta='usd')
{
	$date = date("Y/m/d");
	$codes = array(
		'usd'=>840,
		'eur'=>978,
	);
	$data = file_get_contents("http://cbrates.rbc.ru/tsv/{$codes[$valuta]}/{$date}.tsv");
	if($data){
		$ratio = explode("\t", $data);		
		return trim($ratio[1]);
	}else{
		return false;
	}		
	// $arr = array('usd'=>'R01235', 'eur'=>'R01239');
	// $xml = @simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d/m/Y'));
	// if($xml)
		// foreach($xml->Valute as $v) 
		// {
			// if((string)$v['ID'] == $arr[$valuta])
				// return str_replace(',', '.', $v->Value);
		// }
}

// HTTP-�����������
function wwwAuth($login, $pwd)
{
	if(strcasecmp(trim($_SERVER['PHP_AUTH_USER']),$login) || $_SERVER['PHP_AUTH_PW']!=$pwd)
	{
		header('WWW-Authenticate: Basic realm="Private area"');
		header('HTTP/1.0 401 Unauthorized');
		return false;
		exit;
	}
	return true;
}

// ������� FLASH
function flash($src, $properties="") // ����� � �����, �������� (������, ������...)
{
	ob_start();
?>
	<embed src='<?=$src?>' <?=$properties?> quality='high' wmode='transparent'
		 type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed>
<?
	return ob_get_clean();
}

// ������ �������� strtolower � strtoupper
function strto($case="lower", $str)
{
	$uc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ�����Ũ��������������������������';
	$lc = 'abcdefghijklmnopqrstuvwxyz��������������������������������';
	$outstr = $case=="lower" ? strtr($str,$uc,$lc) : strtr($str,$lc,$uc);
	return $outstr;
}
// �������� mail ������
function check_mail($mail)
{
	$shablon = "/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i";
	
	if(preg_match($shablon,$mail))
		return true;
	else
		return false;
}
// ��������� ������ �� textarea �� �������
function break_to_str($text)
{	
	return strtr($text,array("\r\n"=>"<br>"));
}
// ��������� ������ �� textarea �� �������
function break_to_str1($text)
{	
	return strtr($text,array("\r\n"=>"\n","\r"=>"\n"));
}

// �������� HTML ������
function mailTo($to, $subject, $message, $from="", $charset="windows-1251")
{
	$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($subject, "w","k")).'?='; 	// ���� ��������� �������� � ����� ������
	$headers  = "Content-type: text/html; charset={$charset} \r\n";
	if($from)
		$headers .= "From: {$from}\r\nReply-To: {$from}\r\n";
	//$message = strip_tags(nl2br(str_replace("<br>","\r\n",$message)));
	return @mail($to, $subject, $message, $headers);
}
?>