$(document).ready(function(){
	$(".inputField").keypress(function(e){
	  if(e.keyCode==13)
	  $("#btn_add").click();
	});
	
	$("#btn_add").click(function() {
		
		var password = $("#password").val();
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var email = $("#emailAddress").val();
		var validated = true;
		
		if (jQuery.trim(password).length <= 0) {
			$("#add_password_err").show();
			validated = false;
		}
		if (jQuery.trim(firstname).length <= 0) {
			$("#add_first_err").show();
			validated = false;
		}
		if (jQuery.trim(lastname).length <= 0) {
			$("#add_last_err").show();
			validated = false;
		}
		if (jQuery.trim(email).length <= 0) {
			$("#add_email_err").show();
			validated = false;
		}
	
		if (validated)
		{	$.ajax({
				url: "ajax/add_student.php",
				type: "POST",
				data: { password: password,
						firstname: firstname,
						lastname: lastname,
						email: email
					  }
			});
		
			$("#password").val('');
			$("#firstname").val('');
			$("#lastname").val('');
			$("#emailAddress").val('');
			
			location.href = "./?action=admin_student_manager";
		}
	})
	
	$("#password").keypress(function(){
		$("#add_password_err").hide();
	});
	$("#firstname").keypress(function(){
		$("#add_first_err").hide();
	});
	$("#lastname").keypress(function(){
		$("#add_last_err").hide();
	});
	$("#emailAddress").keypress(function(){
		$("#add_email_err").hide();
	});
});