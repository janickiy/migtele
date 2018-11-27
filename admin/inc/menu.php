<?
	// ЛЕВОЕ МЕНЮ
	ob_start();
	if(is_array($_SESSION['priv']))
	{
		?>
    &raquo; <a href="goods.php" id="a_goods_gr">Товары</a><br>
    &raquo; <a href="visit.php" id="a_visit">Статистика посещений</a>
    <?
	}
	else
	{
		?>	
		&raquo; <a href="pages.php" id="a_pages">Страницы</a><br>
		&raquo; <a href="news.php" id="a_news">Новости</a><br>
        &raquo; <a href="sliders.php" id="a_slider">Слайдер</a><br>
    &raquo; <a href="gr.php" id="a_gr">Группы оборудования</a><br>
    &raquo; <a href="otr.php" id="a_otr">Отрасли оборудования</a><br>
        &raquo; <a href="category_vendor_texts.php" id="a_category_vendor_texts_gr">Тип-ведор тексты</a><br>
		&raquo; <a href="cattype.php" id="a_cattype_gr">Типы оборудования</a><br>
		&raquo; <a href="catmaker.php" id="a_catalog_gr">Разделы</a><br>
        &raquo; <a href="tags.php" id="a_tags">Метки</a><br>
		&raquo; <a href="goods.php" id="a_goods_gr">Товары</a><br>
		&raquo; <a href="valuta.php" id="a_valuta">Курсы валют</a><br>
        &raquo; <a href="users.php" id="a_users">Клиенты</a><br>
		&raquo; <a href="orders.php" id="a_orders">Заказы</a><br>
		&raquo; <a href="call_orders.php" id="a_call_orders">Заказы звонка + Вопросы</a><br>
		&raquo; <a href="counters.php" id="a_counters">Счетчики</a><br>
		&raquo; <a href="settings.php" id="a_settings">Настройки</a><br>
		&raquo; <a href="payment_methods.php" id="a_payment_methods">Способы оплаты</a><br>
		&raquo; <a href="delivery_methods.php" id="a_delivery_methods">Способы доставки</a><br>
        &raquo; <a href="mail_templates.php" id="a_mail_templates">Шаблоны писем</a><br>
		&raquo; <a href="visit.php" id="a_visit">Статистика посещений</a>
		<?
	}
	$left_menu = ob_get_clean();

	// ВЕРХНЕЕ МЕНЮ
	function topMenu($top_menu)
	{	
		ob_start(); 
		switch($top_menu)
		{
			case "price":	?>
				<div class="lnk_top">
					<a href="price.php" id="a_price">On-line прайсы</a> 
					&nbsp; | &nbsp; <a href="price_xls.php" id="a_price_xls">XLS прайсы</a> 
				</div>	
				<script>get('a_price_gr').className='active';</script>
			<?	break;

			case "goods":
				if(!is_array($_SESSION['priv']))
				{
					?>
					<div class="lnk_top">
						<a href="goods.php" id="a_goods">Товары</a> 
						 &nbsp; | &nbsp; <a href="goods.php?valid=0">Разбор</a>
						&nbsp; | &nbsp; <a href="goods.php?importNew=1">Новые товары</a>
						&nbsp; | &nbsp; <a href="goods_xls_prv.php" id="a_goods_xls_prv">XLS импорт (с привязкой)</a>
						&nbsp; | &nbsp; <a href="goods_xls.php" id="a_goods_xls">XLS импорт</a>
						&nbsp; | &nbsp; <a href="ymarket.php" id="a_ymarket">Яндекс-Маркет</a>
						&nbsp; | &nbsp; <a href="mixmarket.php" id="a_mixmarket">Mix-Маркет</a>
                        &nbsp; | &nbsp; <a href="google_merchant_feed.php" id="a_googlemerchant">Google Merchant</a>
                                          &nbsp; | &nbsp; <a href="javascript:toajax('inc/min_image.php')" id="aa_service_goods_resize">Импорт картинок для товаров</a>
					</div>
					<?
				}
				?><script>get('a_goods_gr').className='active';</script><?
				break;

			case "cattype":	?>
				<div class="lnk_top">
					<a href="cattype.php" id="a_cattype">Типы оборудования</a>
				</div>	
				<script>get('a_cattype_gr').className='active';</script>
			<?	break;

			case "catalog":	?>
				<div class="lnk_top">
					<a href="catmaker.php" id="a_catmaker">Вендоры</a> 
					&nbsp; | &nbsp; <a href="catrazdel.php" id="a_catrazdel">Категории</a>
					&nbsp; | &nbsp; <a href="cattmr.php" id="a_cattmr">Тип-Вендор-Категория</a>
				</div>	
				<script>get('a_catalog_gr').className='active';</script>
			<?	break;
			
			case "managers":	?>
				<div class="lnk_top">
					<a href="managers.php" id="a_managers">Менеджеры</a>
					&nbsp; | &nbsp; <a href="mstat.php" id="a_mstat">Активность менеджеров</a>
				</div>	
				<script>get('a_managers_gr').className='active';</script>
			<?	break;
			case 'Settings': ?>
				<div class="lnk_top">
					<a href="settings.php">Настройки</a>
					&nbsp; | &nbsp; <a href="actions.php?action=erase_clicker"  data-success-message="Счетчики успешно обнулены" class="js-background" id="a_catrazdel">Сбросить статистику кликов</a>
				</div>
			 <?php
				break;
			case "none":	?>
				<div class="lnk_top">
					<a href=".php" id="a_"></a>
					&nbsp; | &nbsp; <a href=".php" id="a_"></a>
				</div>	
				<script>get('a_').className='active';</script>
			<?	break;
		}
		?>
		<script>
			$('.js-background').on('click',function(e){
				e.preventDefault();

				if(!confirm('Вы уверены?'))
					return;
				var url = $(this).attr('href');
				var successMessage = $(this).data('success-message');
				$.get(
					url,
					{},
					function(data){
						alert(successMessage);
					}
				);
				console.log(url);
			});
		</script>
<?php
		return ob_get_clean();
	}
?>