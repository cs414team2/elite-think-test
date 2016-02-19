$(document).ready(function(){
	$(".N").hide();
	$("#copy").change(function() {
		if(this.checked) {
			$(".N").show();
		}
		else
			$(".N").hide();
	});
});