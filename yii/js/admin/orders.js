$(document).ready(function(){	
	var baseDir = $("#baseDir").val();	
	reloadGoods();
	$("#Orders_landingId").change(function(){
		reloadGoods();
	});
	function reloadGoods(){
		var landingId = $("#Orders_landingId").val();
		// alert(landingId);//return false;
		$.post(
			baseDir + '/admin/orders/getListGoodsByLanding',
			{
				landingId:landingId
			},function(data){
				// alert(data);
				$("#for-list-of-goods").html(data);
			}
		);
	}
});
