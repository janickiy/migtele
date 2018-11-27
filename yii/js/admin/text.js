$(document).ready(function(){	
	var baseDir = $("#baseDir").val();
	// alert(baseDir);
	$("#Texts_landingId").change(function(){
		var landingId = $(this).val();
		$.get(
			baseDir + '/admin/ajax/getSelectPages/landingId/' + landingId,
			{},
			function(data){
				// alert(data);
				$("#for-select-pages").html(data);
			}
		);
	});
});