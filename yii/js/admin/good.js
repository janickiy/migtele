$(document).ready(function(){	
	var baseDir = $("#baseDir").val();
	bindDeleteTr();	
	$("#add-price").click(function(){
		var colorName = $("#choose-colors option:selected").text();
		var colorId = $("#choose-colors").val();	
		var sizeName = $("#choose-sizes option:selected").text();
		var sizeId = $("#choose-sizes").val();
		var price = Number($("#choose-prices").val());
		// alert(Number($("#choose-prices").val()));
		if(isNaN(price)|| price<=0){
			alert('Введите корректную цену');
			$("#choose-prices").focus();
			return false;
		}
		var trHtml = '<tr><td>'+sizeName+'<input type="hidden" value="'+sizeId+'" name="sizes[]" /></td><td>'+colorName+'<input type="hidden" value="'+colorId+'" name="colors[]" /></td><td>'+price+'<input type="hidden" value="'+price+'" name="prices[]" /></td>		<td><span class="span-link delete-price">Удалить</span></td></tr>';
		$(trHtml).appendTo("#good-prices-table");
		$("#choose-prices").val('');
		bindDeleteTr();		
	});
	priceTypeChange($("#Goods_priceType"));
	$("#Goods_priceType").change(function(){
		priceTypeChange(this);
	});
	$(".delete-image").click(function(){
		$(this).parent().hide(1000);
		var imgId = $(this).attr("data-img-id");
		var html = "<input type='hidden' name='delete-image[]' value='"+imgId+"' />";
		$("#for-deleted-images").append(html);
		// alert(imgId);
	});
	$("#Goods_name").change(function(){
		var val = $(this).val();
		$.get(
			baseDir + '/admin/ajax/toUrl/text/' + val,
			{},
			function(data){
				// alert(data);
				$("#Goods_url").val(data);
			}
		);
	});
	
});
function bindDeleteTr(){
	$(".delete-price").unbind().click(function(){
		$(this).parents('tr').remove();
	});
}
function priceTypeChange(obj){
	var priceType = $(obj).val();		
	if(priceType==0){
		$("#choose-colors").parent().show();
		$("#choose-sizes").parent().show();
	}else if(priceType==1){
		$("#choose-colors").parent().show();
		$("#choose-sizes").val(0).parent().hide();
	}else if(priceType==2){			
		$("#choose-sizes").parent().show();
		$("#choose-colors").val(0).parent().hide();
	}else if(priceType==3){
		$("#choose-colors").val(0).parent().hide();
		$("#choose-sizes").val(0).parent().hide();
	}
}