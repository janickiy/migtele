// alert('123');

window.onload = function () {
	console.log( "ready!" );
	// $('.gimg').find('.add .i2 a').click(function (e) {
	$('.gimg').on('click', '.add .i2 a', function (e) {
		e.preventDefault();
		$block = jQuery(this).parents('div.gimg:first');
		// инструмент в списке товаров
        var id = $(this).closest('.gimg').data('id');

		if($block.hasClass('inlist'))
		{
			console.log('1');
			id = $block.find('.gid').val();
			$glist = $block.find('.glist');
			n = $glist.find('.add').size();

			// убираем у предыдущего поля "ещё"
			$last = $glist.find('.add').eq(n-1);
			$last.find('.i2').remove();

			data  = '<div class="add">';
			data += '	<div class="i1"><input type="file" name="gimg['+id+'][]"></div>';
			if(n<4)
				data += '	<div class="i2"><a href="" title="добавить">ещё</a></div>';
			data += '</div>';
			$last.after(data);
		}
		// инструмент в добавлении/редактировании товара
		else
		{
			console.log('2');
			$glist = $block.find('.glist');
			n = $glist.find('.add').size();



			// убираем у предыдущего поля "ещё"
			$last = $glist.find('.add').eq(n-1);
			$last.find('.i2').remove();

			data  = '<div class="add">';
			data += '	<div class="i1"><input type="file" name="Goods['+id+'][gimg][]"></div>';
			if(n<4)
				data += '	<div class="i2"><a href="" title="добавить">ещё</a></div>';
			data += '</div>';
			$last.after(data);
		}
	});
}
jQuery(function(){
// 	alert('123');
	/*$('.gimg').find('.add .i2 a').live('click',function(){
		$block = jQuery(this).parents('div.gimg:first');
		// инструмент в списке товаров
		if($block.hasClass('inlist'))
		{
			id = $block.find('.gid').val();
			$glist = $block.find('.glist');
			n = $glist.find('.add').size();
			
			// убираем у предыдущего поля "ещё"
			$last = $glist.find('.add').eq(n-1);
			$last.find('.i2').remove();
			
			data  = '<div class="add">';
			data += '	<div class="i1"><input type="file" name="gimg['+id+'][]"></div>';
			if(n<4)
				data += '	<div class="i2"><a href="" title="добавить">ещё</a></div>';
			data += '</div>';
			$last.after(data);
		}
		// инструмент в добавлении/редактировании товара
		else
		{
			$glist = $block.find('.glist');
			n = $glist.find('.add').size();
			
			// убираем у предыдущего поля "ещё"
			$last = $glist.find('.add').eq(n-1);
			$last.find('.i2').remove();
			
			data  = '<div class="add">';
			data += '	<div class="i1"><input type="file" name="gimg[]"></div>';
			if(n<4)
				data += '	<div class="i2"><a href="" title="добавить">ещё</a></div>';
			data += '</div>';
			$last.after(data);
		}

		return false;
	});*/
	
	// check_all
	jQuery('input.check_all').click(function(){
		var $this = jQuery(this);
		jQuery('input[type="checkbox"][name^="'+$this.data('name')+'"]').attr('checked',$this.attr('checked'));
	});

});
function checkAll(obj){
	var $this = jQuery(obj);
	jQuery('input[type="checkbox"][name^="'+$this.data('name')+'"]').attr('checked',$this.attr('checked'));
}