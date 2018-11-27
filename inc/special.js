jQuery(function(){

    //-------всплывающие окна ---------
    jQuery(document).jB({'color':'#f4f4f4'});
    jQuery(document).jPop();
   
   jQuery('#call_img, #operator').click(function(){
    jQuery(document).jPop('show',{'w':'560','h':'140','url':'/call_popup.php'})
   }); 
     
	initCatalog();
	initCart();
	initGoodVk();
	jQuery('#frmSend').add(jQuery('#frmQuest')).add(jQuery('#frmCall')).submit(function(){ jQuery(this).append('<input type="hidden" name="oursite">') });
    jQuery('#img_text').click(function(){
       jQuery('#hide_text').toggle();
       if (jQuery('#hide_text').css('display')=='none')
       	get(this).src='/img/down.png';
       else  
       	get(this).src='/img/up.png';
    });
});

function toCompare(id_goods)
{
	toajax("/compare.php?action=tocompare&id_goods="+id_goods);	
}

function initCatalog()
{
	// Категории
	$RazdelGroup = jQuery('.catRazdelGroup');
	$RazdelGroup.each(function(){
		$type = jQuery(this).prev('div:first table.btn');
		jQuery(this).DropMain({obj:$type});
	});	
	// Производители
	$MakerGroup = jQuery('.catMakerGroup');
	$MakerGroup.each(function(){
		$type = jQuery(this).prev('div.catRazdel');
		jQuery(this).DropMain({obj:$type});
	});	
	// Серии
	$SrGroup = jQuery('.catSrGroup');
	$SrGroup.each(function(){
		$type = jQuery(this).prev('div.catMaker');
		jQuery(this).DropMain({obj:$type});
	});
	// Товары серии
	$GoodGroup = jQuery('.catGoodGroup');
	$GoodGroup.each(function(){
		$type = jQuery(this).prev('div.catSr');
		jQuery(this).DropMain({obj:$type});
	});
}

function initCart()
{
	$cart = jQuery('#cart');
	if($cart.size())
	{
		preloadImg('/img/cart_.png');
		$cart.hover(
			function(){ jQuery(this).addClass('over') },
			function(){ jQuery(this).removeClass('over') }
		);
		$cart.click(function(){ location.href='/cart.php' });
	}
}

function toCart(id,kol)
{
	tmp = new Date();
	jQuery.getJSON('/cart.php?action=tocart&id='+id+'&kol='+(kol*1<1?1:kol)+'&tmp='+tmp,function(data){
		if(data['find']=='1')
			alert('Данный товар уже присутствует в Вашей корзине.\nИзменить количество можно на странице заказа.');
		else
		{
			var count = parseInt(data['count']);
			var itogo = data['itogo'];
			if(count)
			{
				/*
                if(count==1)
				{
                    data  = '<div id="cart">';
					data += '<div class="h">Ваш заказ</div>';
					data += '<div class="c">';
					data += 'товаров: <span id="cart_count">'+count+'</span><br>';
					data += 'на сумму: <span id="cart_itogo">'+number_format(itogo,0,',',' ')+'</span> Р';
					data += '</div></div>';
					
					jQuery('#logo').after(data);
					initCart();
				}
				else
				{
					$block = jQuery('#cart');
					$block.find('#cart_count').html(count);
					$block.find('#cart_itogo').html(number_format(itogo,0,',',' '));
				}
               */
                jQuery("#cart_count").html(count);
                jQuery("#cart_itogo").html(number_format(itogo,0,',',' ') + "р");
                
				alert('Товар добавлен в корзину.');
			}
		}
	});
}

function regSS($url,$data)
{
	jQuery.ajax({type:"GET",url:"/inc/regss.php",data:$data,success:function(data){location.href=$url}});
}

function update_captcha()
{
	tmp = new Date();
	document.getElementById('captcha').src = '/inc/advanced/antirobot/antirobot.php?tmp='+tmp;
}

function smaker(id_cattype,id_catmaker)
{
	if(!id_cattype || !id_catmaker) return;
	location.href = '/type'+id_cattype+'/maker'+id_catmaker+'/';
}

var startScroll=null;

function scrollMakers(to)
{
	scrollRight = to;
	startScroll = setInterval('portScroll('+to+',5)',1);	
}

function portScroll(to,step)
{
	var _div = get('slider');
	if(to)
		_div.scrollLeft += step;
	else
		_div.scrollLeft -= step;

	return _div.scrollLeft;
}

function stopScroll()
{
	clearInterval(startScroll);
}

function initGoodVk()
{
	if(!jQuery('.vk').size()) return;
	
	preloadImg('/img/vk_l_over.gif','/img/vk_c_over.gif','/img/vk_r_over.gif','/img/vk_l_cur.gif','/img/vk_c_cur.gif','/img/vk_r_cur.gif');
	
	jQuery('.vk').hover(function(){if(jQuery(this).hasClass('cur')) return;jQuery(this).addClass('over');},function(){if(jQuery(this).hasClass('cur')) return;jQuery(this).removeClass('over');});
	jQuery('.vk').click(function(){
		
		if(jQuery(this).hasClass('cur')) return;
		
		jQuery('.vk').not(jQuery(this)).each(function(){
			jQuery(this).removeClass('cur');
			jQuery(this).removeClass('over');
			jQuery(this).css('z-index',1);
			ind = jQuery(this).index();
			jQuery('.vk_cont').eq(ind).hide();
		});
		
		ind_cur = jQuery(this).index();
		jQuery(this).addClass('cur');
		jQuery(this).css('z-index',5);
		jQuery('.vk_cont').eq(ind_cur).show();
	});
}

jQuery.fn.DropMain = function(settings){
	
	// Settings
	settings = jQuery.extend({
		obj : Object
	}, settings);
	
	//var $obj = jQuery(this); // объект к которому ляпаем всплывашку
	//var $wind = settings.jQuery('#cp'+$obj.attr('id')); // всплывашка
	
	var $wind = jQuery(this); // всплывашка
	var $obj = settings.obj; // объект к которому ляпаем всплывашку
	
	//if(!$wind.size())
		//return;
		
	var hide = true;
	var t1,t2;
	
	$obj.hover(
		function(){ swind() },
		function(){ hwind1() }
	);
	
	$wind.hover(
		function(){ hide = false },
		function(){ hwind2() }
	);
	
	function swind()
	{
		clearTimeout(t2);
		if(!$wind.is(':visible'))
			$wind.show();
	}
	function hwind1()
	{
		hide = true;
		t1 = setTimeout(function(){
			if(hide && $wind.is(':visible'))
			{
				clearTimeout(t2);
				$wind.hide();
			}
		},200);
	}
	function hwind2()
	{
		hide = true;
		t2 = setTimeout(function(){
			if(hide && $wind.is(':visible'))
			{
				clearTimeout(t1);
				$wind.hide();
			}
		},200);
	}
}
// ВЫДЕЛЕНИЕ ЧЕКБОКСОВ "ГЛАВНЫМ" ЧЕКБОКСОМ В ТАБЛИЦЕ
function setCbTable(obj) // checkbox
{
	var inputName = $(obj).data('name');
	console.log(inputName);
	$( "input[name^='" + inputName + "']" ).prop('checked',$(obj).prop("checked"));


}