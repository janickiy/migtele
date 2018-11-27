<?
require('inc/common.php');
$tbl = 'managers';
$top_menu = 'managers';
$rubric = 'Менеджеры';
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY name";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'save':
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			if(!$name || !$login || !$pass)
				errorAlert('Необходимо заполнить все поля.');
			
			$ids_cattmr = implode(',',$_POST['ids_cattmr']);
			$ids_goods = implode(',',$_POST['ids_goods']);
			
			$where = $id ? " and id<>'{$id}'" : '';
			if(getField("SELECT id FROM {$prx}{$tbl} WHERE login='{$login}'{$where}"))
				errorAlert('Данный логин уже занят.');
			
			$set = "name='{$name}',login='{$login}',pass='{$pass}',type='{$type}',ids_cattmr='{$ids_cattmr}',ids_goods='{$ids_goods}'";
			$id = update($tbl, $set, $id);

			$p = getPage($sqlmain,$id,$k);
			?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
			break;
	
		case 'del':
			update($tbl,'',$id);
			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET['red']))
{
	$rubric .= ' &raquo; '.($id ? 'Редактирование' : 'Добавление');
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	?>
	<form id="frm" action="?id=<?=$id?>&action=save" method="post" target="ajax">
		<table class="red" style="width:700px;">
			<tr>
				<th>Имя</th>
				<td><input name="name" type="text" value="<?=$row['name']?>"></td>
			</tr>
      <tr>
				<th>Логин</th>
				<td><input name="login" type="text" value="<?=$row['login']?>"></td>
			</tr>
      <tr>
				<th>Пароль</th>
				<td><input name="pass" type="text" value="<?=$row['pass']?>"></td>
			</tr>
       <tr>
				<th>Тип</th>
				<td>
					<?=dll(array('1'=>'менеджер 1','2'=>'менеджер 2'),'name="type"',$row['type'])?>
          <div style="padding-top:5px; color:#999; font-style:italic; font-size:10px;">
          	"менеджер 1" обладает привелегиями на редактирование текста товара<br>
            "менеджер 2" - редактирование текста и фото товара<br>
          </div>
        </td>
			</tr>
      <tr>
				<th>
        	Доступные связки
          <div style="padding-top:10px; color:#999; font-style:italic; font-weight:normal; font-size:10px;">
          	пустой список говорит о том,<br>что менеджеру разрешено<br>редактировать любой товар
          </div>
        </th>
				<td>
          <a class="red" id="add_cattmr" href="">редактировать</a>
          <a class="clear" href="" style="margin-left:30px;">очистить</a>
          <select name="ids_cattmr[]" id="ids_cattmr" style="height:100px; margin-top:10px;" multiple>
          <?
          if($row['ids_cattmr'])
          {
            foreach(explode(',',$row['ids_cattmr']) as $v)
            {
							$arr = getRow(sprintf($sqlCattmr," WHERE tmr.id='{$v}'"));
              ?><option value="<?=$v?>"><?=$arr['cattmr']?></option><?
            }
          }
          ?>
          </select>
        </td>
			</tr>
      <tr>
				<th>
        	Доступные товары
          <div style="padding-top:10px; color:#999; font-style:italic; font-weight:normal; font-size:10px;">
          	пустой список говорит о том,<br>что менеджеру разрешено<br>редактировать любой товар<br>
            из выбранный связок
          </div>
        </th>
				<td>
          <a class="red" id="add_goods" href="">редактировать</a>
          <a class="clear" href="" style="margin-left:30px;">очистить</a>
          <select name="ids_goods[]" id="ids_goods" style="height:100px; margin-top:10px;" multiple>
          <?
          if($row['ids_goods'])
          {
            foreach(explode(',',$row['ids_goods']) as $v)
            {
							$arr = getRow("SELECT id_cattmr,name FROM {$prx}goods WHERE id='{$v}'");
              ?><option value="<?=$v?>" cid="<?=$arr['id_cattmr']?>"><?=$arr['name']?></option><?
            }
          }
          ?>
          </select>
        </td>
			</tr>
			<tr>
				<td align="center" colspan="2"><?=btnAction()?></td>
			</tr>
		</table>
	</form>	
  <script>	
	jQuery(function(){
		var $list_cattmr = jQuery('#ids_cattmr');
		var $list_goods = jQuery('#ids_goods');
		var $frm = jQuery('#frm');
		
		$frm.submit(function(){
			$list_cattmr.add($list_goods).find('option').attr('selected',true);
			//$('#frm_edit').submit();
		});
		//
		jQuery('#add_cattmr').click(function(){
			jQuery('a.clear').add(jQuery('a.red')).hide();
			var ids = '';
			$list_cattmr.find('option').each(function(){
				ids += (ids?',':'')+jQuery(this).val();
			});
			win = window.open('managers_ids_cattmr.php?ids='+ids,'my2','resizable=yes,width=800,height=600,scrollbars=1');
			win.focus();
			return false;
		});
		//
		jQuery('#add_goods').click(function(){
			jQuery('a.clear').add(jQuery('a.red')).hide();
			var ids = '';
			$list_goods.find('option').each(function(){
				ids += (ids?',':'')+jQuery(this).val();
			});
			var ids_cattmr = '';
			$list_cattmr.find('option').each(function(){
				ids_cattmr += (ids_cattmr?',':'')+jQuery(this).val();
			});
			win = window.open('managers_ids_goods.php?ids='+ids+'&ids_cattmr='+ids_cattmr,'my2','resizable=yes,width=800,height=600,scrollbars=1');
			win.focus();
			return false;
		});
		//
		jQuery('a.clear').click(function(){
			var $list = jQuery(this).next();
			clean_list($list);
			if($list.attr('id')=='ids_cattmr')
				clean_list(jQuery('#ids_goods'));
			return false;
		});
	})
	function clean_list($list)
	{
		$list.find('option').remove();
	}
	function remove_goods(cid)
	{
		jQuery('#ids_goods option[cid="'+cid+'"]').remove();
	}
	</script>		  
	<?
}
// -----------------ПРОСМОТР-------------------
else
{
	echo lnkAction('Add');
	?>
	<table class="content">
		<tr>
			<th>Имя</th>
			<th>Логин</th>
			<th>Тип</th>
			<th></th>
		</tr>
		<? 
		$p = @$_GET['p'] ? $_GET['p'] : 1;
		$res = sql($sqlmain.' LIMIT '.($p-1)*$k.", {$k}");
		while($row = mysql_fetch_array($res))
		{
			$id = $row['id'];
			?>
			<tr id="tr<?=$id?>">
				<td><a name="<?=$id?>"></a><?=$row['name']?></td>
				<td><?=$row['login']?></td>
				<td>менеджер <?=$row['type']?></td>
				<td><?=lnkAction("Red,Del")?></td>
			</tr>
			<?
		}
		?>
		<tr>
			<td colspan="4" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
		</tr>
	</table>
<?
}
$content = ob_get_clean();

require('template.php');
?>