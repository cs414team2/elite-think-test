//****************************************************************
//*                        Functions                             *
//****************************************************************


//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	$('.gradeTestButton').click(function(){		
		$.ajax({
			url : "ajax/get_completed_test_teacher.php",
			data : {
				student_id : $(this).data('student-id'),
				test_id : 1//test_id
			},
			success : function(test){
				$("#test_content").html(test);
			}
		});
	})
});