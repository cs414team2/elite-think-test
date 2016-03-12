const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE      = 'TF';
const ESSAY_QUESTION_TYPE           = 'ESSAY';
const MAX_TEST_SIZE = 3;
const TEST_NOT_STARTED = '0';
const TEST_STARTED     = '1';
const TEST_COMPLETED   = '2';
const TEST_TIMED_OUT   = '3';

//var test_clock;

//*******************Functions****************************

// Check to see if a student has or has not started taking a test, or has finished taking a test.
function check_status() {
	$.ajax({
		url: "ajax/get_test_status.php",
		data: {
			test_id: test_id,
			student_id: 3        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! change this to a variable!!!!!!!!!!!!!!!!!!!!!!!!!!
		},
		success: function(status){
			switch(status){
				case TEST_NOT_STARTED:
					$("#btn_start").removeAttr("disabled");
					$("#btn_complete").attr("disabled", "disabled");
					break;
				case TEST_STARTED:
					start_test(false);
					break;
				case TEST_COMPLETED:
					complete_test();
					break;
				case TEST_TIMED_OUT:
					disable_test();
					break;
			}
		}
	});
}

function load_questions() {
	$.ajax({
		url: "ajax/get_questions.php",
		data: { test_id : test_id },
		success: function (questions) {
			$('#test_content').html(questions);
			number_questions();
		}
	});
}

// Display the question numbers.
function number_questions() {
	$( ".question_number" ).each(function( index ) {
		var formatted_number = "";
		for (i = 0; i < (MAX_TEST_SIZE - (index + 1).toString().length); i++) {
			formatted_number = formatted_number + "&nbsp;";
		}
		formatted_number = formatted_number + (index + 1 + ")");
		$(this).html(formatted_number);
	});
}

function start_test(first_time) {
	//var end_time = new Date();
	
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").removeAttr("disabled");
	/*
	if(first_time) {
		//Do ajax to create instance of a taking of a test and begin the timer
		// Maybe begin the timer after the ajax returns so we can be sure it exists in the database before creating the countdown.
	}
	else {
		// get the timer based on what the current time value should be (check in the database).
		end_time.setMinutes(end_time.getMinutes() + 50);
	}
	
	test_clock = setInterval(countdown_time(end_time), 1000);*/
	load_questions();
}

function complete_test() {
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").attr("disabled", "disabled");
	
}

function disable_test () {
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").removeAttr("disabled");
}

/*function countdown_time(end_time) {
	$("#div_minutes").html(new Date());
	$("#div_seconds").html(end_time);
}*/

//***********************Events************************
$(document).ready(function(){
	check_status();
	
	$("#btn_start").click(function(){
		start_test(true);
	});
	
	$("#btn_complete").click(function(){
		complete_test();
	});
});