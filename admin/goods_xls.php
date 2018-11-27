<?
// echo mysql_real_escape_string("Зажимы для ОК типа '8'");exit();
require('inc/common.php');
require_once(dirname(__FILE__).'/../yii/protected/models/Goods.php');
require_once(dirname(__FILE__).'/../yii/protected/models/Settings.php');
require_once(dirname(__FILE__).'/../yii/protected/models/Catmaker.php');
$tbl = 'goods';
$rubric = 'Товары &raquo; XLS импорт';
$top_menu = 'goods';
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'import':
			require_once('inc/excel_import.php');

			$categoryId = (int) $_POST['catmaker'];
			$currency = $_POST["valuta"];
			//Делаем всех невалидными(на разбор)
			$sql = "UPDATE `{$prx}goods`, `{$prx}cattmr` 
				SET `{$prx}goods`.`valid` = 0 
				WHERE `{$prx}goods`.`id_cattmr` = `{$prx}cattmr`.`id` 
				AND `{$prx}cattmr`.`id_catmaker` = {$categoryId}";

			Yii::app()->db->createCommand($sql)->execute();

			$vendor = Catmaker::model()->findByPk($_POST['catmaker']);
			/**@var $vendor Catmaker*/
			$rows = @excel_make_sheets($_FILES['file']['tmp_name']);
//			$siteName = Settings::model()->findByPk('sitename');
			/** Опция для изменения доступности товара */
			$availabilitySetting = Settings::model()->findByPk('set_aviability_in_import');
			/**@var $availabilitySetting Settings*/
			/**@var $siteName Settings*/
			$count = array();


			foreach($rows as $line=>$row) {

				$kod = $name = $price = $availability = null;
				list($kod, $name, $price, $availability) = $row;

                $price = str_replace(array(" ", "€", "$"), "", $price);
                $price = str_replace(",", ".", $price);

                    $price = floatval($price);

                if(!$price){
                    $price = 0;
                }

				if ($kod) {
					$count["all"]++;

					$model = Goods::model()->findByAttributes(array(
						'kod' => $kod,
					));
					/**@var $model Goods */
					if ($model === NULL || $model->importNew == 1) {
						$model = ($model === NULL) ? new Goods : $model;
						$model->kod = $kod;
						$model->text1 = $name;
						$model->name = $vendor->name.' '.$model->kod;
//						$model->name = ($siteName !== NULL) ? $siteName->value . ' ' . $model->kod : $model->kod;
						$model->importNew = 1;
						$model->link = makeUrl($vendor->name.'_'.$model->kod);
                        $model->price_markup = rand(5, 15);
//						$model->link = ($siteName !== NULL) ? $siteName->value . '_' . $model->kod : $model->kod;
//						$model->link = str_replace(' ', '_', $model->link);
//						$model->link = trans($model->link);

                        $model->created_at = date("Y-m-d H:i:s");
						$count["importNew"]++;

					} else {
                        $model->updated_at = date("Y-m-d H:i:s");
						$count["update"]++;
					}
					/** Если опция создана и ее значение равно true - меняем значение доступности товара*/
					if ($availabilitySetting !== NULL && $availabilitySetting->value == 'true') {
						$model->nalich = ($availability == '') ? Goods::AVIABILITY_FALSE : Goods::AVIABILITY_TRUE;
					}
					$model->price = $price;
					$model->valuta = $currency;
					$model->valid = 1;

					$model->hide = 0;
					$model->nalich = 1;

					$model->save(false);

				} else {
				    if($name) {
                        //Если не прописан код - это название раздела, добавляем тестовый товар в качестве маркера категории
                        $model = new Goods;
                        $model->name = $name;
                        $model->price = $price;
                        $model->kod = '---';
                        $model->importNew = 1;
                        $model->nalich = 1;
                        $model->save(false);
                    }
				}
			}
			?><script>
				alert("Импорт завершен.\r\n\r\nВсего товаров: <?=(int)$count["all"]?>\r\nОбновлено цен: <?=(int)$count["update"]?>\r\nДобавлено товаров категорию новый товар:<?=(int)$count["importNew"]?>");
				top.document.forms["frmContent"].reset();
				top.topBack(true);
			</script><?
			break;
		case "import_old":
			require_once('inc/excel_import.php');
			// sql("UPDATE {$prx}{$tbl} SET valid = 0");
			$catmaker = (int) $_POST['catmaker'];
			sql("
				UPDATE `{$prx}goods`, `{$prx}cattmr`, `{$prx}catmaker` 
				SET `{$prx}goods`.`valid` = 0 
				WHERE `{$prx}goods`.`id_cattmr` = `{$prx}cattmr`.`id` 
				AND `{$prx}cattmr`.`id_catmaker` = `{$prx}catmaker`.`id` 
				AND `{$prx}catmaker`.`id` = {$catmaker}
			");
			$valuta = $_POST['valuta'];
			$rows = @excel_make_sheets($_FILES['file']['tmp_name']);
			$import = array();
			foreach($rows as $num=>$row)
			{
				list($kod,$name,$price) = $row;
				$kod = mysql_real_escape_string($kod);
				$valuta = mysql_real_escape_string($valuta);
				if(!$kod) continue;
				if(!getField("SELECT id FROM {$prx}{$tbl} WHERE kod='{$kod}'")) { $import['skip']++; continue; }
				
				preg_match('/([0-9,.]+)/',$price,$m);
				$price = $m[1];
				$price = str_replace(',','.',$price);
				$price = round($price,2);

				sql("UPDATE {$prx}{$tbl} SET price='{$price}', valuta='{$valuta}', valid = 1 WHERE kod='{$kod}'");
				$import['count']++;
				$import['update'] += getField("SELECT COUNT(*) FROM {$prx}{$tbl} WHERE kod='{$kod}'");
				
				// обновляем он-лайн прайсы
				sql("UPDATE {$prx}price SET price='{$price}', valuta='{$valuta}' WHERE kod='{$kod}' AND razd='0'");
			}
			?><script>
			alert("Импорт завершен.\r\n\r\nВсего товаров: <?=(int)$import['count']?>\r\nОбновлено цен: <?=(int)$import['update']?>\r\nПропущено товаров: <?=(int)$import['skip']?>");
			top.document.forms["frmContent"].reset();
			top.topBack(true);
			</script><?
			break;
	}
	exit;
}

ob_start();

?>
<form action="?action=import"  target="ajax" method="post" name="frmContent" enctype="multipart/form-data">
	<table class="content" width="450">
		<tr>
    	<th>Файл</th>
			<td><input type="file" name="file" style="width:100%"></td>
		</tr>
    <tr>
      <th>Валюта</th>
      <td><?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'valuta'", "name='valuta' style='width:auto;'")?></td>
    </tr>
	<tr>
      <th>Производитель</th>
      <td><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY name", "name='catmaker' style='width:auto;'")?></td>
    </tr>
    <tr>
      <td colspan="2" align="right"><?=btnAction("Save", "Загрузить")?></td>
    </tr>
		<tr>
			<td colspan="2"><b>Формат файла:</b><br>Код товара, Название, Цена</td>
		</tr>
	</table>	
</form>
<?
$content = ob_get_clean();
$tbl .= '_xls';
require('template.php');
?>