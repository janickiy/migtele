<?
	// ����� ����
	ob_start();
	if(is_array($_SESSION['priv']))
	{
		?>
    &raquo; <a href="goods.php" id="a_goods_gr">������</a><br>
    &raquo; <a href="visit.php" id="a_visit">���������� ���������</a>
    <?
	}
	else
	{
		?>	
		&raquo; <a href="pages.php" id="a_pages">��������</a><br>
		&raquo; <a href="news.php" id="a_news">�������</a><br>
        &raquo; <a href="sliders.php" id="a_slider">�������</a><br>
    &raquo; <a href="gr.php" id="a_gr">������ ������������</a><br>
    &raquo; <a href="otr.php" id="a_otr">������� ������������</a><br>
        &raquo; <a href="category_vendor_texts.php" id="a_category_vendor_texts_gr">���-����� ������</a><br>
		&raquo; <a href="cattype.php" id="a_cattype_gr">���� ������������</a><br>
		&raquo; <a href="catmaker.php" id="a_catalog_gr">�������</a><br>
        &raquo; <a href="tags.php" id="a_tags">�����</a><br>
		&raquo; <a href="goods.php" id="a_goods_gr">������</a><br>
		&raquo; <a href="valuta.php" id="a_valuta">����� �����</a><br>
        &raquo; <a href="users.php" id="a_users">�������</a><br>
		&raquo; <a href="orders.php" id="a_orders">������</a><br>
		&raquo; <a href="call_orders.php" id="a_call_orders">������ ������ + �������</a><br>
		&raquo; <a href="counters.php" id="a_counters">��������</a><br>
		&raquo; <a href="settings.php" id="a_settings">���������</a><br>
		&raquo; <a href="payment_methods.php" id="a_payment_methods">������� ������</a><br>
		&raquo; <a href="delivery_methods.php" id="a_delivery_methods">������� ��������</a><br>
        &raquo; <a href="mail_templates.php" id="a_mail_templates">������� �����</a><br>
		&raquo; <a href="visit.php" id="a_visit">���������� ���������</a>
		<?
	}
	$left_menu = ob_get_clean();

	// ������� ����
	function topMenu($top_menu)
	{	
		ob_start(); 
		switch($top_menu)
		{
			case "price":	?>
				<div class="lnk_top">
					<a href="price.php" id="a_price">On-line ������</a> 
					&nbsp; | &nbsp; <a href="price_xls.php" id="a_price_xls">XLS ������</a> 
				</div>	
				<script>get('a_price_gr').className='active';</script>
			<?	break;

			case "goods":
				if(!is_array($_SESSION['priv']))
				{
					?>
					<div class="lnk_top">
						<a href="goods.php" id="a_goods">������</a> 
						 &nbsp; | &nbsp; <a href="goods.php?valid=0">������</a>
						&nbsp; | &nbsp; <a href="goods.php?importNew=1">����� ������</a>
						&nbsp; | &nbsp; <a href="goods_xls_prv.php" id="a_goods_xls_prv">XLS ������ (� ���������)</a>
						&nbsp; | &nbsp; <a href="goods_xls.php" id="a_goods_xls">XLS ������</a>
						&nbsp; | &nbsp; <a href="ymarket.php" id="a_ymarket">������-������</a>
						&nbsp; | &nbsp; <a href="mixmarket.php" id="a_mixmarket">Mix-������</a>
                        &nbsp; | &nbsp; <a href="google_merchant_feed.php" id="a_googlemerchant">Google Merchant</a>
                                          &nbsp; | &nbsp; <a href="javascript:toajax('inc/min_image.php')" id="aa_service_goods_resize">������ �������� ��� �������</a>
					</div>
					<?
				}
				?><script>get('a_goods_gr').className='active';</script><?
				break;

			case "cattype":	?>
				<div class="lnk_top">
					<a href="cattype.php" id="a_cattype">���� ������������</a>
				</div>	
				<script>get('a_cattype_gr').className='active';</script>
			<?	break;

			case "catalog":	?>
				<div class="lnk_top">
					<a href="catmaker.php" id="a_catmaker">�������</a> 
					&nbsp; | &nbsp; <a href="catrazdel.php" id="a_catrazdel">���������</a>
					&nbsp; | &nbsp; <a href="cattmr.php" id="a_cattmr">���-������-���������</a>
				</div>	
				<script>get('a_catalog_gr').className='active';</script>
			<?	break;
			
			case "managers":	?>
				<div class="lnk_top">
					<a href="managers.php" id="a_managers">���������</a>
					&nbsp; | &nbsp; <a href="mstat.php" id="a_mstat">���������� ����������</a>
				</div>	
				<script>get('a_managers_gr').className='active';</script>
			<?	break;
			case 'Settings': ?>
				<div class="lnk_top">
					<a href="settings.php">���������</a>
					&nbsp; | &nbsp; <a href="actions.php?action=erase_clicker"  data-success-message="�������� ������� ��������" class="js-background" id="a_catrazdel">�������� ���������� ������</a>
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

				if(!confirm('�� �������?'))
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