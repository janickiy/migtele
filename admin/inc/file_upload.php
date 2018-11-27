<? 
	// ÔÓÍÊÖÈÎÍÀË ÇÀÃÐÓÇÊÈ ÔÀÉËÀ
	function fileUpload($path="/img/file1.jpg", $properties="name='file'")  // $path - àáñîëþòíûé ïóòü
	{	
		// íàõîäèì name â $properties
		preg_match("#name\s*=\s*['\"]+(.*)['\"]+#iU", $properties, $name);
		$name = $name[1];
		ob_start();
	?>
		<script>
			function delFile(name)
			{
				_input = document.getElementById('del_'+name);
				_span = document.getElementById('span_'+name);
				_input.value = 1;
				_span.style.display = 'none';
			}
		</script>

		<input type="file" <?=$properties?>>
		<input name="del_<?=$name?>" id="del_<?=$name?>" type="hidden" value="0">
	<? if($path && file_exists($_SERVER['DOCUMENT_ROOT'].$path) && !is_dir($_SERVER['DOCUMENT_ROOT'].$path)) { ?>
			<span id="span_<?=$name?>">
				<a href="<?=$path?>?rand=<?=rand()?>" target="my" onClick="openWindow(800,600)"><img src="<?=getIcoType($path)?>" alt="file" hspace="1" align="absmiddle" title="Îòêðûòü"></a>
				<a href="javascript:delFile('<?=$name?>')"><img src="img/del16.gif" alt="óä." hspace="1" align="absmiddle" title="Óäàëèòü"></a>
			</span>
	<? }

		return ob_get_clean();
	}	
	
	// ÂÎÇÂÐÀÙÀÅÒ ÊÀÐÒÈÍÊÓ ÑÎÎÒÂÅÒÑÒÂÓÞÙÓÞ ÒÈÏÓ ÔÀÉËÀ
	function getIcoType($path) // ïóòü ê ôàéëó
	{
		if(!function_exists("scandir"))
			return "img/ico/default.icon.gif";
			
		$arr = explode('.',$path);
		$need_ico = @$arr[count($arr)-1].".gif";
		$arr_ico = @scandir("img/ico"); // ïîëó÷àåì ìàññèâ ôàéëîâ äèðåêòîðèè ñ êàðòèíêàìè "èêîíîê"

		return in_array($need_ico, $arr_ico)
			? "img/ico/".$need_ico
			: "img/ico/default.icon.gif";
	}
	
	// ÄÎÁÀÂËÅÍÈÅ / ÓÄÀËÅÍÈÅ ÔÀÉËÀ
	function upfile($file, $post, $del=false, $createFileName=false, $width=0, $height=0) // îòíîñèòåëüíûé ïóòü ê ôàéëó, ïåðåìåííàÿ $_FILES[''], true - óäàëèòü ôàéë, ãåíåðèòüñÿ èìÿ ôàéëà àâòîìàòîì, øèðèíà è âûñîòà (äëÿ êàðòèíîê)
	{
		if($del)
			@unlink($file);

		if($post['name'])
		{
			if($createFileName)
			{
				$fn = expFileName($post['name']);
				$fileName = makeUrl($fn[0]).$fn[1];
				$file = (is_dir($file) ? $file : dirname($file)."/").$fileName;
			}
			else
				$fileName = basename($file);
				
			move_uploaded_file($post['tmp_name'], $file);
			@chmod($file, 0644);
			
			if($width || $height)
				imgResize($file, $width, $height);
			
			return $fileName;
		}
		
		return $del ? "" : basename($file);
	}
	
	// ÑÎÕÐÀÍÅÍÈÅ ÊÀÐÒÈÍÊÈ Ñ ÍÎÂÛÌÈ ÐÀÇÌÅÐÀÌÈ
	function imgResize($src, $width, $height=0) // ïóòü ê êàðòèíêè, øèðèíà, âûñîòà
	{
		if (!file_exists($src)) 
			return false;
	
		$quality = 90;
		
		$size = @getimagesize($src);
		if ($size === false) 
			return false;
		
		$type = $size['mime'];
		$format = strtolower(substr($type, strpos($type, '/')+1));
		if($format == "bmp")
			include("bmp.php");
	
		$icfunc = "imagecreatefrom" . $format;
		if (!function_exists($icfunc))
			return false;
		
		if(!$width || $width > $size[0])
			$width = $size[0];
		if(!$height || $height > $size[1])
			$height = $size[1];
		
		$x_ratio = $width / $size[0];
		$y_ratio = $height / $size[1];
		
		$ratio = min($x_ratio, $y_ratio);
		$use_x_ratio = ($x_ratio == $ratio);
		
		$width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
		$height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
		
		if($width==$size[0] || $height==$size[1])
		{
			return true;
		}
		else
		{
			$isrc = $icfunc($src);
			$idest = imagecreatetruecolor($width, $height);
			
			imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			
			imagejpeg($idest, $src, $quality);
			
			imagedestroy($isrc);
			imagedestroy($idest);
		}	
		return true;
	}
?>