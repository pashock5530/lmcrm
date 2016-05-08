$(function(){
	$('select').selectpicker();


	$(".dialog").click(function(){
		var href=$(this).attr("href");
		$.ajax({
			url:href,
			success:function(response){
				var dialog = bootbox.dialog({
					message:response,
					show: false
				});
				dialog.on("show.bs.modal", function() {
					$(this).find('.ajax-form').ajaxForm(function() {
						dialog.modal('hide');
					});
				});
				dialog.modal("show");
			}
		});
		return false;
	});
});