//***************Functions********************
function loadTeachers() {
	$("#tbl_teachers").load("ajax/get_table.php?table=teacher", function(){
		$(".N").hide();
	});
}

// ******************Events*******************
$(document).ready(function(){
	loadTeachers();
	
	// Read the enter key press if user is in the add form and press the add button.
	$(".input_field").keypress(function(e){
	  if(e.keyCode==13)
	  $("#btn_add").click();
	});
	
	// Take a new teacher's name, password, and email address and add them to the database.
	$("#btn_add").click(function() {
		
		var password = $("#password").val();
		var first_name = $("#first_name").val();
		var last_name = $("#last_name").val();
		var email = $("#email").val();
		var validated = true;
		var email_expression = /^.+@.+\..+$/i;
		
		if (email_expression.test(email) == false)
		{
			validated = false;
			$("#err_email").text("Invalid email format.");
			$("#err_email").show();
		}
		if (jQuery.trim(password).length <= 0) {
			$("#err_password").show();
			validated = false;
		}
		if (jQuery.trim(first_name).length <= 0) {
			$("#err_first_name").show();
			validated = false;
		}
		if (jQuery.trim(last_name).length <= 0) {
			$("#err_last_name").show();
			validated = false;
		}
		if (jQuery.trim(email).length <= 0) {
			$("#err_email").text("Email cannot be blank.");
			$("#err_email").show();
			validated = false;
		}
	
		if (validated)
		{	$.ajax({
				url: "ajax/add_teacher.php",
				type: "POST",
				data: { password: password,
						first_name: first_name,
						last_name: last_name,
						email: email
					  },
				success: function () {
					
					loadTeachers();
				
					$("#password").val('');
					$("#first_name").val('');
					$("#last_name").val('');
					$("#email").val('');
					
					window.scroll(0,0);
				}
			});
			
		}
	})
	
	// Remove the error message for a field is a user types in it.
	$("#password").keypress(function(){
		$("#err_password").hide();
	});
	$("#first_name").keypress(function(){
		$("#err_first_name").hide();
	});
	$("#last_name").keypress(function(){
		$("#err_last_name").hide();
	});
	$("#email").keypress(function(){
		$("#err_email").hide();
	});
});