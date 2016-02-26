//***************Functions********************

// Load the list of classes and set the row's to redirect to the class management page.
function loadClasses() {
	$("#tbl_classes").load("ajax/get_table.php?table=class", function(){
		$('.class_record, .Y').click(function(){
			var class_id = $(this).attr('id');
			window.location = 'index.php?action=admin_class_manager&id=' + class_id;
		});
		
		$('.class_record, .N').click(function(){
			var class_id = $(this).attr('id');
			window.location = 'index.php?action=admin_class_manager&id=' + class_id;
		});
	});
}

// ******************Events*******************
$(document).ready(function(){	
	loadClasses();

	// Read the enter key press if user is in the add form and press the add button.
	$(".inputField").keypress(function(e){
	  if(e.keyCode==13)
	  $("#btn_add").click();
	});

	// Take a new course name, number, and a teacher id and add them to the database.
	$("#btn_add").click(function() {
		var course_name = $("#courseName").val();
		var course_number = $("#courseNumber").val();
		var teacher_id = $("#Teacher").val();
		var validated = true;
		
		if (jQuery.trim(course_name).length <= 0) {
			$("#add_course_name_err").show();
			validated = false;
		}
		if (jQuery.trim(course_number).length <= 0) {
			$("#add_course_number_err").show();
			validated = false;
		}
		
		if (validated) {
			$.ajax({
				url: 'ajax/add_class.php',
				type: 'POST',
				data: { course_name: course_name,
						course_number: course_number,
						teacher_id: teacher_id
					  }
			});
			
			loadClasses();
			
			$("#courseName").val('');
			$("#courseNumber").val('');
			$("#Teacher").val('');
			
			window.scroll(0,0);
		}
		
	});
	
	// Remove the error message for a field is a user types in it.
	$("#courseName").keypress(function(){
		$("#add_course_name_err").hide();
	});
	$("#courseNumber").keypress(function(){
		$("#add_course_number_err").hide();
	});
});