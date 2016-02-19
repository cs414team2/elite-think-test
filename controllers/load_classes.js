$(document).ready(function(){
	$('.class_record').click(function(e){
		if($(e.target).is('.btn_delete')){
			e.preventDefault();
			return;
		}
		else{
			var class_id = $(this).attr('id');
			window.location = 'index.php?action=admin_class_manager&id=' + class_id;
		}
	});
});