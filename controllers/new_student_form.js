//***************Functions********************
function loadStudents() {
	$("#tbl_students").load("ajax/get_table.php?table=student");
}

// ******************Events*******************
$(document).ready(function(){
	loadStudents();
	
	// Read the enter key press if user is in the add form and press the add button.
	$(".inputField").keypress(function(e){
	  if(e.keyCode==13)
	  $("#btn_add").click();
	});
	
	// Take a new student's name, password, and email address and add them to the database.
	$("#btn_add").click(function() {
		
		var password = $("#password").val();
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var email = $("#emailAddress").val();
		var validated = true;
		var email_expression = /^.+@.+\..+$/i;
		
		if (email_expression.test(email) == false)
		{
			validated = false;
			$("#add_email_err").text("Invalid email format.");
			$("#add_email_err").show();
		}
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
			$("#add_email_err").text("Email cannot be blank.");
			$("#add_email_err").show();
			validated = false;
		}
		
		if (email_expression.test(email) == false)
		{
			validated = false;
		}
	
		if (validated){
		$.ajax({
				url: "ajax/add_student.php",
				type: "POST",
				data: { password: password,
						firstname: firstname,
						lastname: lastname,
						email: email
					  }
			});
			
			loadStudents();
		
			$("#password").val('');
			$("#firstname").val('');
			$("#lastname").val('');
			$("#emailAddress").val('');
			
			window.scroll(0,0);
		}
	})
	
	// Remove the error message for a field is a user types in it.
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