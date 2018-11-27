<?

require('inc/common.php');

$tbl = "goods";
$top_menu = "goods";
$rubric = "Товары";
$id = (int)@$_GET['id'];

$p = @$_GET['p'] ? $_GET['p'] : 1;
$k = 40;

if($id_cattmr = (int)@$_GET["id_cattmr"])
	list($id_cattype, $id_catmaker, $id_catrazdel, $id_sub_catrazdel) = getRow("SELECT id_cattype, id_catmaker, id_catrazdel, id_sub_catrazdel FROM {$prx}cattmr WHERE id='{$id_cattmr}'");
else
{
	$id_cattype = (int)@$_GET["id_cattype"];
	$id_catmaker = (int)@$_GET["id_catmaker"];
	$id_catrazdel = (int)@$_GET["id_catrazdel"];
    $id_sub_catrazdel = (int)@$_GET["id_sub_catrazdel"];
	$id_cattmr = getField("SELECT id FROM {$prx}cattmr WHERE id_cattype='{$id_cattype}' AND id_catmaker='{$id_catmaker}' AND id_catrazdel='{$id_catrazdel}'");


}

$id_catsr = (int)@$_GET['id_catsr'];
$noprv = isset($_GET['noprv']) ? true : false;

//echo $sqlmain = "SELECT * FROM {$prx}{$tbl} %s ORDER BY ".(($id_cattype && !$id_catmaker && $id_catrazdel) ? "sort_tr" : "sort");
$sqlmain = "SELECT * FROM {$prx}{$tbl} %s ";

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	if(is_array($_SESSION['priv']) && $_GET['action']!='save_')
		errorAlert('У вас нет соответствующих привелегий.');
		
	switch($_GET['action'])
	{
		case "moveImport":
			if ($_GET['moveCat']>0)
				foreach($_GET["id"] as $id)
				{
//					echo "UPDATE {$prx}goods SET importNew='0', id_cattmr='".(int)$_GET['moveCat']."' WHERE id='".(int)$id."'";
					if ($id>0)
						sql("UPDATE {$prx}goods SET importNew='0', id_cattmr='".(int)$_GET['moveCat']."', created_at = NOW()  WHERE id='".(int)$id."' ");

				}

				$page_id = isset($_GET['p']) && $_GET['p'] ? $_GET['p'] : 1;

			?><script>top.location.href = "/admin/goods.php?importNew=1&p=<?=$page_id?>";</script><?
			break;
		case "deleteValid":
			sql("DELETE FROM {$prx}goods WHERE `valid` = '0'");
			?><script>top.location.href = "/admin/goods.php";</script><?
			break;
		case "nullValid":
			sql("UPDATE {$prx}goods SET valid='1'");
			?><script>top.location.href = "/admin/goods.php";</script><?
			break;
		case "saveall":
				
			foreach($_POST['id'] as $id=>$val)
			{

				$set = '';
				foreach(array('kod','name','yml','hide','nalich','sp','none','new','valid', 'sale') as $key)
				{
					$value = isset($_POST[$key]) && isset($_POST[$key][$id]) ? $_POST[$key][$id] : 0;

                    if($key=='valid'){
                        $value = isset($_POST[$key]) && isset($_POST[$key][$id]) ? 0 : 1;
                    }

					$set .= ($set?',':'')."{$key}='{$value}'";
				}		
						
				update($tbl, $set, $id);
				
				// загружаем картинки
				if(sizeof((array)$_FILES['gimg']['name'][$id]))
				{
					foreach($_FILES['gimg']['name'][$id] as $num=>$null)
					{
						if(!$_FILES['gimg']['name'][$id][$num]) continue;
						
						if($id_img = update('goods_img',"id_goods='{$id}'"))
						{
							$path = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img}.jpg";
							@move_uploaded_file($_FILES['gimg']['tmp_name'][$id][$num],$path);
							@chmod($path,0644);
						}
					}
				}
			}

			// удаляем картинки
			foreach((array)$_POST['imdel'] as $id_img)
			{
				update('goods_img','',$id_img);
				@unlink("../uploads/goods_img/{$id_img}.jpg");
			}
			
			?><script>top.topReload(true);</script><?

			break;

		case "save":
//			print_r($_FILES[]);
//			exit();
			foreach($_POST['Goods'] as $id => $data){
				GoodSaver::save($data, $_FILES['Goods']['tmp_name'][$id]['gimg'] , array(
					'id' => $id,
                    'new' => $id ? 1 : 0,
                    'hide' => 0,
                    'none' => 0,
                    'importNew' => 0,
                    'yml' => 0,
                    'text3'=> '2',
//					'sqlmain' => $sqlmain,
				), count($_POST['Goods']) > 1);
			}
			$id_cattmr = $data['id_cattmr'];
			$p = getPage(sprintf($sqlmain,"WHERE id_cattmr='{$id_cattmr}'"), $id, $k);
			?><script>top.location.href = "?id_cattmr=<?= $id_cattmr?>&id=<?= $id?>&p=<?= $p?>&rand=<?=rand()?>";</script><?
			updateOnlinePrice();
			exit();


			foreach($_POST as $key=>$val)
				$$key = clean($val);
				
			if(!$id_cattmr)
				errorAlert("Укажите расположение");
			if(!$link)
				errorAlert("Введите ссылку");
			if(getField("SELECT count(*) AS c FROM {$prx}{$tbl} WHERE id<>'{$id}' AND link='{$link}'"))
				errorAlert("Товар с такой ссылкой уже существует");
			
			$price = str_replace(",",".",$price);
			

			$set = "id_cattmr='{$id_cattmr}', id_catsr='{$id_catsr}', nalich='{$nalich}', name='{$name}', link='{$link}', kod='{$kod}', kod2='{$kod2}', text1='{$text1}', text2='{$text2}', text4='{$text4}', 
						price='{$price}', valuta='{$valuta}', teh='{$teh}', yml='{$yml}', hide='{$hide}', sp='{$sp}', none='{$none}', new='{$new}', soft='{$soft}'";
			$set .= ", importNew = '{$importNew}'";
			
			if($id = update($tbl, $set, $id))
			{
				// ------------ сопутствующие товары
				// удаляем старые сопутствующие товары
				sql("UPDATE {$prx}goods SET ids_goods='' WHERE id='{$id}'");
				// добавляем новые
				$ids_goods = $_POST['ids_goods'];
				if(count($ids_goods))
				{
					$ids_goods = implode(',',$ids_goods);
					sql("UPDATE {$prx}goods SET ids_goods='{$ids_goods}' WHERE id='{$id}'");
				}
				
				// обновляем "дополнительные" таблицы
				foreach(array("img") as $t)
					sql("UPDATE {$prx}goods_{$t} SET id_goods='{$id}' WHERE id_goods='0'");
				
				updateOnlinePrice();
				
				// загружаем картинки
				if(sizeof((array)$_FILES['gimg']['name']))
				{
					foreach($_FILES['gimg']['name'] as $num=>$null)
					{
						if(!$_FILES['gimg']['name'][$num]) continue;
						
						// сохраняем в базе
						if($id_img = update('goods_img',"id_goods='{$id}'"))
						{
							$path = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img}.jpg";
							@move_uploaded_file($_FILES['gimg']['tmp_name'][$num],$path);
							@chmod($path,0644);
						}
					}
				}
				
				// удаляем картинки
				foreach($_POST['imdel'] as $id_img)
				{
					update('goods_img','',$id_img);
					@unlink("../uploads/goods_img/{$id}.jpg");
				}
				
				$p = getPage(sprintf($sqlmain,"WHERE id_cattmr='{$id_cattmr}'"), $id, $k);
				?><script>top.location.href = "?id_cattmr=<?=$id_cattmr?>&id=<?=$id?>&p=<?=$p?>&rand=<?=rand()?>";</script><?
			}
			else
				errorAlert('Ошибка при сохранении данных!');
			break;
		
		case "save_":
				
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$set = "text1='{$text1}', text2='{$text2}', teh='{$teh}'";
			
			if($id = update($tbl, $set, $id))
			{
				// статистика действий менеджера
				update('mstat',"`date`=NOW(),id_manager='{$_SESSION['priv']['id']}',id_good='{$id}'");
				
				if($_SESSION['priv']['type']==2)
				{			
					// загружаем картинки
					if(sizeof((array)$_FILES['gimg']['name'][$id]))
					{
						foreach($_FILES['gimg']['name'][$id] as $num=>$null)
						{
							if(!$_FILES['gimg']['name'][$id][$num]) continue;
							
							if($id_img = update('goods_img',"id_goods='{$id}'"))
							{
								$path = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img}.jpg";
								@move_uploaded_file($_FILES['gimg']['tmp_name'][$id][$num],$path);
								@chmod($path,0644);
							}
						}
					}				
					// удаляем картинки
					foreach($_POST['imdel'] as $id_img)
					{
						update('goods_img','',$id_img);
						@unlink("../uploads/goods_img/{$id_img}.jpg");
					}
				}
				$id_cattmr = getField("SELECT id_cattmr FROM {$prx}{$tbl} WHERE id='{$id}'");				
				$p = getPage(sprintf($sqlmain,"WHERE id_cattmr='{$id_cattmr}'"), $id, $k);
				?><script>top.location.href = "?id_cattmr=<?=$id_cattmr?>&id=<?=$id?>&p=<?=$p?>&rand=<?=rand()?>";</script><?
			}
			else
				errorAlert('Ошибка при сохранении данных!');
			break;
	
		case "del":
			update($tbl, "", $id);

			foreach(array("img") as $t)
			{
				$ids = getArr("SELECT id FROM {$prx}goods_{$t} WHERE id_goods='{$id}'");
				foreach($ids as $id_goods)
					@unlink("../uploads/goods_{$t}/{$id_goods}.jpg");
			}
			foreach(array("img") as $t)
				sql("DELETE FROM {$prx}goods_{$t} WHERE id_goods='{$id}'");
			
			?><script>top.topReload();</script><?
			break;
		
		case "delall":
			
			foreach($_POST['del'] as $id)
			{
				update($tbl, "", $id);
	
				foreach(array("img") as $t)
				{
					$ids = getArr("SELECT id FROM {$prx}goods_{$t} WHERE id_goods='{$id}'");
					foreach($ids as $id_goods)
						@unlink("../uploads/goods_{$t}/{$id_goods}.jpg");
				}
				foreach(array("img") as $t)
					sql("DELETE FROM {$prx}goods_{$t} WHERE id_goods='{$id}'");
			}
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			if(isset($_GET["sort_tr"]))
			{
				//debug(false);
				$res = sql("SELECT id, id_cattmr FROM {$prx}{$tbl}");
				while($row = mysql_fetch_assoc($res))
				{
					$tr = getField("SELECT CONCAT(id_cattype,'-',id_catrazdel) AS tr FROM {$prx}cattmr WHERE id='{$row['id_cattmr']}'");
					update($tbl, "tr='{$tr}'", $row['id']);
				}
				moveSort((@$move ? "up" : "down"), $tbl, $id, "tr", "sort_tr");
			}
			else
				moveSort((@$move ? "up" : "down"), $tbl, $id, "id_cattmr");
			?><script>top.topReload();</script><?
			break;
		case "deleteImportNew":
			sql("DELETE FROM {$prx}goods WHERE `importNew` = '1'");
			?><script>top.location.href = "/admin/goods.php";</script><?
			break;
		case "nullImportNew":
			sql("UPDATE {$prx}goods SET importNew='0'");
			?><script>top.location.href = "/admin/goods.php";</script><?
			break;
			
	}
	exit;
}

ob_start();

// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	$rubric .= " &raquo; ".($row ? "Редактирование" : "Добавление");
	$id_cattype = getField("SELECT id_cattype FROM {$prx}cattmr WHERE id='{$id_cattmr}'");
	
	if(is_array($_SESSION['priv']))
	{
		if(!$row) { header("Location: goods.php"); exit; }
		// проверим разрешено ли манагеру редактировать этот товар
		if($_SESSION['priv']['ids_cattmr'])
		{
			$ids_cattmr = explode(',',$_SESSION['priv']['ids_cattmr']);
			if(!in_array($row['id_cattmr'],$ids_cattmr)) { header("Location: goods.php"); exit; }
			
			if($_SESSION['priv']['ids_goods'])
			{
				$ids_goods = explode(',',$_SESSION['priv']['ids_goods']);
				if(!in_array($row['id'],$ids_goods)) { header("Location: goods.php"); exit; }
			}
		}
	}
	
	?>
  <script>


	function frm_edit_submit(form)
	{
		showLoad(true);
		setTimeout( function(){for(var i=0; i<get('ids_goods').options.length; i++) {get('ids_goods').options[i].selected='true';}}, 1 );
		setTimeout( function(){form.submit();}, 500 );
	}
	</script>
	<script language="JavaScript" src="/inc/gimg.js?v=1"></script>
  <?
	$style = '';
	if(is_array($_SESSION['priv']))
	{
		?><div style="color:#090; font-style:italic; padding-bottom:10px;">Ваша учетная запись имеет ограниченные права,<br>зелёным цветом выделены параметры, которые Вы можете редактировать</div><?
		$style = ' style="color:#090;"';
	}
	?>
	<form action="?id=<?=$id?>&action=save<?=is_array($_SESSION['priv'])?'_':''?>&id_cattmr=<?=$id_cattmr?>" method="post" enctype="multipart/form-data" target="ajax">

		<?php Display::staticRender('_good',array(
			'style' => $style,
			'id' => $id,
			'row' => $row,
//			'id_cattmr' => $id_cattmr,
			'id_cattmr' => $row['id_cattmr'],
			'sqlCattmr' => $sqlCattmr,
			'id_cattype' => $id_cattype,
		))?>
	</form>			  
<?
}

// -----------------ПРОСМОТР-------------------
else
{	
	if(!is_array($_SESSION['priv']))
	{
		?>
		<form>
			<table class="content">
				<tr>
					<th>Тип</th>
					<th>Вендор</th>
					<th>Категория</th>
                    <th>Подкатегория</th>
				</tr>
				<tr>
					<th><?=dll("SELECT id,name FROM {$prx}cattype ORDER BY name, sort", 'name="id_cattype" style="width:auto"', $id_cattype, "")?></th>
					<th><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY name, sort", 'name="id_catmaker" style="width:auto"', $id_catmaker, "")?></th>
					<th><?=dll("SELECT id,name FROM {$prx}catrazdel ORDER BY name, sort", 'name="id_catrazdel" style="width:auto"', $id_catrazdel, "")?></th>
                    <th><?=dll("SELECT id,name FROM {$prx}catrazdel ORDER BY name, sort", 'name="id_sub_catrazdel" style="width:auto"', $id_sub_catrazdel, "")?></th>
				</tr>
				<tr>
					<?
					// $search = htmlspecialchars(stripslashes(trim(ereg_replace(' +',' ',$_GET['search']))));
					$search = htmlspecialchars(stripslashes(trim(preg_replace ('/ +/',' ',$_GET['search']))));
					?>
					<th colspan="2"><div align="left">Поиск товара<input type="text" name="search" value="<?=$search?>" style="margin-left:10px; width:200px;"></div></th>
					<?if(isset($_GET['importNew'])&&$_GET['importNew']==1){?>
						<th colspan="4">
							<?=dll(sprintf($sqlCattmr,""), 'style="width:200px;" id="move-to-category"', $id_cattmr, "")?>
							<input type="text" class="js-catalog-autocompleteMove" style="width:200px;" placeholder="Быстрый поиск категории">

							<input value="Перенести товар" id="moveButton" type="submit" style="width:auto;">
						</th>
					<?}?>
				</tr>
				<tr>
					<th colspan="4"><div align="left"><input type="checkbox" name="noprv"<?=$noprv?' checked':''?>> только товары без привязки</div></th>
				</tr>
				<tr>
					<?=(isset($_GET['valid']))?CHtml::hiddenField('valid',(int)$_GET['valid']):''?>
					<?=(isset($_GET['importNew']))?CHtml::hiddenField('importNew',(int)$_GET['importNew']):''?>
					<th colspan="4" style="text-align:center; border:none; "><?=btnAction("Save", "Показать")?></th>
				</tr>
			</table>
			<script>
				var tags = $("#move-to-category option");
				var availableTags = [];
				for(var i=0;i<tags.length;i++){
					availableTags.push({
						'label' : $(tags[i]).html(),
						'value' : $(tags[i]).val()
					});
				}
				$( ".js-catalog-autocompleteMove" ).autocomplete({
					source: availableTags,
					select:function( event, ui ) {
//						console.log(ui.item);
						$('#move-to-category').val(ui.item.value);
						$(this).val('');
//						changeCat();
						return false;
					}
				});
				console.log(availableTags);
			</script>
		</form>
		<?
		$where = '';
		if($noprv)
			$where .= ' and id_cattmr=0 and id_catsr=0';
		else
		{
			if($id_cattype || $id_catmaker || $id_catrazdel || $id_catsr || $id_sub_catrazdel)
			{
				$ids = getArr("SELECT id FROM {$prx}cattmr WHERE 1 ".($id_cattype ? " AND id_cattype='{$id_cattype}' " : "").($id_catmaker ? " AND id_catmaker='{$id_catmaker}' " : "").($id_catrazdel ? " AND (id_catrazdel='{$id_catrazdel}') " : "").($id_sub_catrazdel ? " AND id_sub_catrazdel='{$id_sub_catrazdel}' " : ""));
				$ids = implode(",", (array)$ids);
				$where .= $ids ? " and id_cattmr IN ({$ids})".($id_catsr?" and id_catsr={$id_catsr}":'') : ($id_catsr?" and id_catsr={$id_catsr}":'');
			}
			else
				$where .= $id_catsr?" and id_catsr={$id_catsr}":'';
		}

	}
	// если манагер
	else
	{
		?>
    <form>
			<table class="content">
				<tr>
					<?
					$search = htmlspecialchars(stripslashes(trim(ereg_replace(' +',' ',$_GET['search']))));
					?>
					<th>
          	<div align="left">Поиск товара<input type="text" name="search" value="<?=$search?>" style="margin-left:10px; width:200px;"><?=btnAction("Save", "Показать")?></div>
          </th>
				</tr>
			</table>
		</form>
		<?
		$where = '';
		// проверим разрешено ли манагеру редактировать этот товар
		if($_SESSION['priv']['ids_cattmr'])
			$where .= " and id_cattmr IN ({$_SESSION['priv']['ids_cattmr']})";
		if($_SESSION['priv']['ids_goods'])
			$where .= " and id IN ({$_SESSION['priv']['ids_goods']})";
	}




    if($search)
		$where .= $search ? " AND (	kod LIKE '%".mysql_escape_string($search)."%' OR
																kod2 LIKE '%".mysql_escape_string($search)."%' OR
																	name LIKE '%".mysql_escape_string($search)."%')" : '';



	$importNew = (int)$_GET['importNew'];
	$orderBy = ' ORDER BY sort ';
	if((isset($_GET['search']) && $_GET['search'] !='') === false || 1){
//		echo 123;
		if(isset($_GET['valid'])){
			$valid = (int)$_GET['valid'];
			$where .= ' AND `valid` = '.$valid;
			$where .= ' AND `importNew` = 0';
			$pageEnd = 'valid='.$valid;
		}elseif(isset($_GET['importNew'])){
			$importNew = (int)$_GET['importNew'];
			$where .= ' AND `importNew` = '.$importNew;
			//Меняем порядок сортировки для "новых товаров"
			$orderBy = 'ORDER BY id ';
			$pageEnd = 'importNew='.$importNew;
		}else{
			$where .= ' AND `valid` = 1';
			$where .= ' AND `importNew` = 0';
		}
	}
	if(isset($_GET['orderBy'])){
		switch($_GET['orderBy']){
			case 'clickCount':
				$orderBy = ' ORDER BY clickCount DESC, sort ASC';
				break;
		}
	}




	$sqlmain = sprintf($sqlmain,$where?"WHERE 1{$where}":'');
	$sqlmain .= $orderBy;



	$res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");
	?>
  <style>
	table.content tr th { text-align:center; }
	table.content tr td, table.content tr th {
		padding:5px 5px 5px 5px;
	}
	</style>
	<?
	if(!is_array($_SESSION['priv']))
	{
		?>		
		<script language="JavaScript" src="/inc/gimg.js"></script>
		<form action="?action=saveall" target="ajax" method="post" enctype="multipart/form-data" id="frmContent">
			<?= (isset($_GET['importNew'])) ? CHtml::hiddenField('', $_GET['importNew'], array('id' => 'import-new-value')) : ''?>
			<?= (isset($_GET['valid'])) ? CHtml::hiddenField('', $_GET['valid'], array('id' => 'valid-value')) : ''?>
<!--		<input type="hidden" id="import-new-value" value="--><?//=(int)$_GET['importNew']?><!--">-->
<!--		<input type="hidden" id="valid-value" value="--><?//=(isset($_GET['valid']))?$_GET['valid']:''?><!--">-->
		<?=lnkAction("Add", "&id_cattmr={$id_cattmr}")?>
		<?php
			$getData = $_GET;
			$getData['orderBy'] = 'clickCount';
			$urlData = http_build_query($getData);
		?>
		<a href="" style="margin-left:10px;" id="edit-all-button"><img src="img/red16.gif" hspace="2" alt="ред." title="редактировать выделенное" align="absmiddle">редактировать выделенное</a>
		<a href="?<?=$urlData?>">
			<img src="img/arr-sort-down.gif" hspace="2" alt="ред." title="Отсортировать по количеству кликов" align="absmiddle">
			Отсортировать по количеству кликов
		</a>
		<?if(isset($_GET['valid'])&&$_GET['valid']==0){?>
			<a href="/admin/goods_export.php"><img src="img/im-ardown.gif" hspace="2" alt="ред." title="Экспортировать в xls" align="absmiddle">Экспортировать в xls</a>
		<?}?>
		<?if(isset($_GET['importNew'])&&$_GET['importNew']==1){?>
			<br/><br/>
			<a href="?action=nullImportNew" onclick="return confirm('Вы уверены?')"><img src="img/green-flag.png" hspace="2" alt="ред." title="Восстановить все" align="absmiddle" >Восстановить все</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?action=deleteImportNew" onclick="return confirm('Вы уверены?')"><img src="img/del16.gif" hspace="2" alt="ред." title="Удалить все" align="absmiddle" >Удалить все</a>
		<?}?>
		<?php if(isset($_GET['valid'])&&$_GET['valid']==0){?>
			<br/><br/>
			<a href="?action=nullValid" onclick="return confirm('Вы уверены?')"><img src="img/green-flag.png" hspace="2" alt="ред." title="Восстановить все" align="absmiddle" >Восстановить все</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="?action=deleteValid" onclick="return confirm('Вы уверены?')"><img src="img/del16.gif" hspace="2" alt="ред." title="Удалить все" align="absmiddle" >Удалить все</a>
		<?}?>
		<br/>
		<br/>
		<input type="button" value="удалить" title="удалить отмеченные" onclick="showLoad(true);this.form.action='?action=delall';this.form.submit()" />
		<?=btnAction("Save")?>
		<br>
    <table class="content">
    	<tr>
				<td colspan="50" align="center"><?=lnkPages($sqlmain, $p, $k, "?p=%s&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}&{$pageEnd}")?></td>
			</tr>
			<tr>
      	<th><input type="checkbox" class="check_all" data-name="del"></th>
				<th>ID</th>
				<th>Кол-во кликов</th>
				<th>Изображение</th>
				<th>Расположение</th>
				<th>Код</th>
				<th>Название</th>
				<th>Цена</th>
				<th>В наличии<br><input type="checkbox" class="check_all" data-name="nalich"></th>
				<th>Выгружать<br>в YML<br><input type="checkbox" class="check_all" data-name="yml"></th>
                <th>Распродажа<br><input type="checkbox" class="check_all" data-name="sale"></th>
				<th>Скрыть<br>товар<br><input type="checkbox" class="check_all" data-name="hide"></th>
				<!--th>На разбор<br><input type="checkbox" class="check_all" data-name="valid" onClick="jQuery('#frmContent').submit();"></th-->
				<th>На разбор<br><input type="checkbox" data-name="valid" class="check_all" onClick123="checkAll(this);jQuery('#frmContent').submit();" <?=(isset($_GET['valid'])&&$_GET['valid']==0)?'checked':''?>></th>
				<th>Ссылка</th>
				<th></th>
			</tr>
      <?
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
				?>
				<tr id="tr<?=$id?>">
					<td><input name="del[]" class="check-good" type="checkbox" value="<?=$id?>"></td>
					<td><?=$id?></td>
					<td align="right" nowrap><?=$row['clickCount']?></td>
					<td align="center">
						<a name="<?=$id?>"></a>
						<?
						$href = '/images/original/uploads/nophoto.gif';
						if($id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$id}' ORDER BY sort,id LIMIT 1"))
							$href = "/images/original/uploads/goods_img/{$id_img}.jpg";
						?>
						<a href="<?=$href?>" target="my" onClick="openWindow(800,600)">
                            <img src="/images/small/uploads/goods_img/<?=$id_img?>.jpg" title="увеличить">
                        </a>
					</td>
					<td><? 
						$cattmr = getRow(sprintf($sqlCattmr, "WHERE tmr.id='{$row['id_cattmr']}'"));
						echo $cattmr["cattmr"];
					?></td>
					<td><input type="text" name="kod[<?=$id?>]" value="<?=htmlspecialchars($row['kod'])?>"></td>
					<td><input type="text" name="name[<?=$id?>]" value="<?=htmlspecialchars($row['name'])?>"></td>

					<td align="right" nowrap><?=number_format($row["price"],2,","," ")?> <?=$row["valuta"]?></td>

          <td align="center">
						<input name="nalich[<?=$id?>]" type="checkbox" <?=($row["nalich"] ? "checked" : "")?> value="1">
					</td>
                    <td align="center">
						<input name="yml[<?=$id?>]" type="checkbox" <?=($row["yml"] ? "checked" : "")?> value="1">
					</td>
                    <td align="center">
						<input name="sale[<?=$id?>]" type="checkbox" <?=($row["sale"] ? "checked" : "")?> value="1">
					</td>
					<td align="center">
						<input type="hidden" name="id[<?=$id?>]">
						<input name="hide[<?=$id?>]" type="checkbox" <?=($row["hide"] ? "checked" : "")?> value="1">
					</td>
					<td align="center">						
						<input name="valid[<?=$id?>]" type="checkbox" <?=($row["valid"] ? "" : "checked")?> onClick="jQuery('#frmContent').submit();" value="1">
					</td>


          <td><a href="/tovar/<?=$row["link"]?>.htm" target="_blank">/tovar/<?=$row["link"]?>.htm</a></td>
					<td><?=lnkAction(($id_cattmr || ($id_cattype && !$id_catmaker && $id_catrazdel) ? "Up,Down,Red,Del" : "Red,Del"), "&id_cattmr={$row['id_cattmr']}".(($id_cattype && !$id_catmaker && $id_catrazdel) ? "&sort_tr" : ""))?></td>
				</tr>

				<?
			}
			?>
			<tr>
				<td colspan="50" align="center"><?=lnkPages($sqlmain, $p, $k, "?p=%s&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}&{$pageEnd}")?></td>
			</tr>
		</table>
    </form>
		<script>

//			alert('123');
			$('.check_all').change(function(){
				setCbTable(this);
			});
			$("#edit-all-button").click(function(e){
				console.log('click edit-all-button');
				e.preventDefault();
				var goods = $('.check-good:checked');
				var importNewValue= $('#import-new-value').val();
				var validValue= $('#valid-value').val();
				// console.log(importNewValue);return;
				var url = '';
				if(goods.length==0)
					return false;
				for (index = 0; index < goods.length; ++index) {
					url = url + 'id[]=' + $(goods[index]).val() + '&';
					// console.log($(goods[index]).val());
				}
				if(importNewValue)
					url = url + 'importNew=' + importNewValue + '&';
				if(validValue)
					url = url + 'valid=' + validValue + '&';
				top.location.href = "/admin/goods_edit.php?" + url;
				// console.log(url);
			});
			$("#moveButton").click(function(e){
				e.preventDefault();
				var goods = $('.check-good:checked');
				var importNewValue= $('#import-new-value').val();
				var validValue= $('#valid-value').val();
				var moveCat = $('#move-to-category').val();
				var url = '';
				if(goods.length==0)
				{
					alert('Выберите товары для перемещения');
					return false;
				}
				if(moveCat.length==0)
				{
					alert('Выберите категорию для перемещения');
					return false;
				}
				for (index = 0; index < goods.length; ++index) {
					url = url + 'id[]=' + $(goods[index]).val() + '&';
				}
				url = url + 'importNew=' + importNewValue + '&';
				if(validValue)
					url = url + 'valid=' + validValue + '&';
				if(moveCat)
					url = url + 'moveCat=' + moveCat+ '&';

				var pageId = parseInt($('#lnkPages .active').first().text());

                pageId = pageId ? pageId : 1;

                url = url + 'p=' + pageId;

				top.location.href = "/admin/goods.php?action=moveImport&" + url;
			});
		</script>

    <?
	}
	else
	{
		?>
    <form action="?action=saveall" target="ajax" method="post" enctype="multipart/form-data" id="frmContent">
	<table class="content">
    	<tr>
				<td colspan="50" align="center"><?=lnkPages($sqlmain, $p, $k, "?p=%s&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}&valid={$valid}")?></td>
			</tr>
			<tr>
      	<th><input type="checkbox" class="check_all"></th>
				<th>ID</th>
				<th>Изображение</th>
				<th>Название</th>
				<th>Ссылка</th>
				<th></th>
			</tr>
      <?
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
				?>
				<tr id="tr<?=$id?>">
					<td><input name="del[]" type="checkbox"  class="check-good" value="<?=$id?>"></td>
          <td><?=$id?></td>
					<td align="center">
						<a name="<?=$id?>"></a>
					<?	$id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$id}' ORDER BY sort LIMIT 1");	?>
						<a href="/images/original/uploads/goods_img/<?=$id_img?>.jpg" target="my" onClick="openWindow(800,600)">
							<img src="/images/small/uploads/goods_img/<?=$id_img?>.jpg" title="увеличить">
						</a>
					</td>
					<td><?=$row['name']?></td>
          <td><a href="/tovar/<?=$row["link"]?>.htm" target="_blank">/tovar/<?=$row["link"]?>.htm</a></td>
					<td><?=lnkAction(($id_cattmr || ($id_cattype && !$id_catmaker && $id_catrazdel) ? "Up,Down,Red,Del" : "Red,Del"), "&id_cattmr={$row['id_cattmr']}".(($id_cattype && !$id_catmaker && $id_catrazdel) ? "&sort_tr" : ""))?></td>
				</tr>
        <?
			}
			?>
			<tr>
				<td colspan="50" align="center"><?=lnkPages($sqlmain, $p, $k, "?p=%s&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}&valid={$valid}")?></td>
			</tr>
		</table>
		</form>
    <?
	}
	
}
$content = ob_get_clean();

require("template.php");
?>