<?
// ПОЛУЧЕНИЕ ДЕРЕВА
function getTree($sqlmain, $id_parent=0, $depth=0, $level=0) // $sql = "SELECT * FROM tbl WHERE id_parent = '%s'", ветка с которой начинаем стоить дерево, "глубина" дерева, текущая глубина - не задается
{
	if(!$depth || $depth>$level)
	{
		$sql = sprintf($sqlmain,$id_parent);
		$res = sql($sql);
		while ($row = mysql_fetch_array($res)) 
		{
			$id = $row[0];
			$tree[] = array("level" => $level, "row" =>  $row);
			$tree = array_merge($tree, (array)getTree($sqlmain, $id, $depth, $level+1));
		}
	}
	return @$tree;
}

// префикс относительно уровня вложенности дерева
function getPrefix($level=0, $prefix="&raquo;&nbsp;") 
{
	$prefix = str_repeat("&mdash;&nbsp;",$level).$prefix;
	return $prefix;
}

// возвращает id ветки и всех ее подветок
function getTreeChilds($sql, $id=0, $arr=false) // $sql = "SELECT id FROM tbl WHERE id_parent = '%s'", id ветки, возврещать в виде массива/строки
{
	$childs[] = $id;
	$tree = getTree($sql, $id);
	if($tree)
		foreach($tree as $vetka)
			$childs[] = $vetka["row"][0];

	return $arr	? $childs : implode(",", $childs);
}

// возвращает массив ветки и всех ее родителей
function getTreeParents($sql, $id=0, $parent_fill="id_parent") // $sql = "SELECT * FROM tbl WHERE id = '%s'"
{
	do
	{
		$row = getRow(sprintf($sql, $id));
		$tree[] = $row;
		$id = $row[$parent_fill];
	}
	while($id);

	return array_reverse($tree);
}

// ВЫПАДАЮЩИЙ СПИСОК ДЛЯ ДЕРЕВА
function dllTree($sql, $properties, $value="", $default=NULL, $hidevalue="", $id_parent=0, $depth=0) // $sql = "SELECT * FROM tbl WHERE id_parent = '%s'", св-ва списка, значение, "пустое" значение(может быть массивом),  значение скрываемой рубрики (и ее подрубрик), id начала веток, глубина дерева
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
		if($tree = getTree($sql, $id_parent, $depth))
			foreach ($tree as $vetka) 
			{
				$row =  $vetka["row"];
				$level = $vetka["level"];
				
				// не выводим скрываемую рубрику и ее подрубрики
				if($row[0] == $hidevalue)
				{
					$hide_pages_level = $level;
					continue;
				}
				if(isset($hide_pages_level) && $hide_pages_level < $level)
					continue;
				else
					unset($hide_pages_level);
				
				$prefix = getPrefix($level);
			?>					
				<option value="<?=$row[0]?>" <?=($row[0]==$value ? "selected='selected'" : "")?>><?=$prefix.$row["name"]?></option>
		<?	}	?>				
	</select>
<? 	
	return ob_get_clean();
}	
?>