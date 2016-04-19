const STUDENT_NOT_ENROLLED = 0;
const STUDENT_IS_ENROLLED  = 1;

//***************Functions********************
function edit_student() {
	var password = $('#password').val();
	var first_name = $('#first_name').val();
	var last_name = $('#last_name').val();
	var email = $('#email').val();
	var validated = true;
	var email_expression = /^.+@.+\..+$/i;
	
	if (email_expression.test(email) == false)
	{
		validated = false;
		$('#err_email').text('Invalid email format.');
		$('#err_email').show();
	}
	if (jQuery.trim(password).length <= 0) {
		$('#err_password').show();
		validated = false;
	}
	if (jQuery.trim(first_name).length <= 0) {
		$('#err_first_name').show();
		validated = false;
	}
	if (jQuery.trim(last_name).length <= 0) {
		$('#err_last_name').show();
		validated = false;
	}
	if (jQuery.trim(email).length <= 0) {
		$('#err_email').text('Email cannot be blank.');
		$('#err_email').show();
		validated = false;
	}

	if (validated)
	{
		$.ajax({
			url: 'ajax/edit_student.php',
			data: { id : $('#info_id').html(),
			        first_name : first_name,
			        last_name : last_name,
			        email : email,
			        password : password,
			},
			success : function(student){
				var temp_div = document.createElement('div');
				temp_div.innerHTML = student;
				
				$('#h_student_info').html(
					$(temp_div).find('#info_last').html() + ', '
					+ $(temp_div).find('#info_first').html() + ' ('
					+ $(temp_div).find('#info_id').html() + ')'
				);
				$( '#ddl_switch_student option:selected' ).text(
					$(temp_div).find('div').text()
					+ $(temp_div).find('#info_last').text() + ', '
					+ $(temp_div).find('#info_first').text()
				);
				$('#tbl_student_info').html($(temp_div).find('tbody').html());
			}
		});
		$( '#dlg_edit_student_info' ).dialog( 'close' );
	}
}

function enroll_student(){
	var student = [{ id : $('#info_id').html(),
	        enrolled : STUDENT_IS_ENROLLED}];


	
	if ($('#ddl_select_class').val() != 'null') {
		$('#area_enroll_class').hide();
		$('#area_enroll_loader').show();
		
		$.ajax({
			url: 'ajax/update_enrollment.php',
			data : {
				class_id : $('#ddl_select_class').val(),
				student : student
			},
			success : function(){				
				$.ajax({
					url: 'ajax/get_student_info.php',
					data : { student_id : $('#info_id').html() },
					success : function(student) {
						var temp_div = document.createElement('div');
						temp_div.innerHTML = student;
						
						$('#tbl_classes').html($(temp_div).find('#class_table tbody').html());
						set_class_links();
						$('#ddl_select_class').html($(temp_div).find('#unenrolled_classes').html());
						
						$('#area_enroll_loader').hide();
						$('#area_enroll_class').show();
					}
				});
			}
		});
	}
}

// Populate the page with information from a student.
function load_student() {
	$('#area_student_info').hide();
	$('#area_loader').show();
	$('#area_enroll_class').hide();
	$('#area_enroll_loader').show();
	
	$.ajax({
		url: 'ajax/get_student_info.php',
		data : { student_id : $('#ddl_switch_student').val()},
      dataType : 'html',
		success: function(student){
			var temp_div = document.createElement('div');
			temp_div.innerHTML = student;
			
			$('#h_student_info').html($(temp_div).find('#heading_info').html());
			$('#tbl_student_info').html($(temp_div).find('#information_line tbody').html());
			$('#tbl_classes').html($(temp_div).find('#class_table tbody').html());
			set_class_links();
			$('#ddl_select_class').html($(temp_div).find('#unenrolled_classes').html());
			
			$('#area_loader').hide();
			$('#area_student_info').show();
			$('#area_enroll_loader').hide();
			$('#area_enroll_class').show();
		}
	});
}

function set_class_links() {
	$('#tbl_classes').find('tr').each(function(){
		if(!($(this).hasClass('no_classes'))) {
			$(this).click(function() {
					window.location = './?action=admin_edit_class&id=' + $(this).attr('id');
			});
			$(this).addClass('clickable_row');
		}
	});
}

function check_unenrolled_classes() {
	if ($('#ddl_select_class').children().length == 0) {
		$('#area_enroll_class').hide();
	}
}

// Strip HTML tags from a string.
function html_special_chars(str) {
	if (typeof(str) == "string") {
		str = str.replace(/&/g, "&amp;");
		str = str.replace(/"/g, "&quot;");
		str = str.replace(/'/g, "&#039;");
		str = str.replace(/</g, "&lt;");
		str = str.replace(/>/g, "&gt;");
	}
	return str;
}

// Decode HTML character codes in a string.
function html_special_chars_decode(str) {
	if (typeof(str) == "string") {
		str = str.replace(/&lt;/g, "<");
		str = str.replace(/&gt;/g, ">");
		str = str.replace(/&quot;/g, "\"");
		str = str.replace(/&#039;/g, "'");
		str = str.replace(/&amp;/g, "&");
	}
	return str;
}

// ******************Events*******************
$(document).ready(function(){
	set_class_links();
	check_unenrolled_classes();
	
	// Take a new student's name, password, and email address and add them to the database.
	$('#btn_save').click(function() {
		edit_student();
	});	
	
	$('#btn_enroll').click(function(){
		enroll_student();
	});
	
	$('#ddl_switch_student').change(function(){
		load_student();
	});
	
	// Read the enter key press if user is in the add form and press the add button.
	$('.input_field').keypress(function(e){
	  if(e.keyCode==13)
	  $('#btn_save').click();
	});
	
	// Remove the error message for a field is a user types in it.
	$('#password').keypress(function(){
		$('#err_password').hide();
	});
	$('#first_name').keypress(function(){
		$('#err_first_name').hide();
	});
	$('#last_name').keypress(function(){
		$('#err_last_name').hide();
	});
	$('#email').keypress(function(){
		$('#err_email').hide();
	});
	
	// Open a dialog box if a user clicks the open button.
	$( '#dlg_edit_student_info' ).dialog({
      autoOpen: false,
	  modal: true,
	  width: 600,
      show: {
        effect: 'size',
		duration: 500
      },
      hide: {
        effect: 'size',
		duration: 500
      },
		close: function(){
			$('#err_password').hide();
			$('#err_first_name').hide();
			$('#err_last_name').hide();
			$('#err_email').hide();
		}
    });
 
    $( '#btn_open_edit_studnet_dialog' ).click(function() {
		$('#first_name').val(html_special_chars_decode($('#info_first').html()));
		$('#last_name').val(html_special_chars_decode($('#info_last').html()));
		$('#password').val(html_special_chars_decode($('#info_password').html()));
		$('#email').val(html_special_chars_decode($('#info_email').html()));
		 
	  $( '#dlg_edit_student_info' ).dialog( 'open' );
    });
});