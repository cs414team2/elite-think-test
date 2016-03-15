const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE      = 'TF';
const ESSAY_QUESTION_TYPE           = 'ESSAY';
const MAX_TEST_SIZE   = 3; // Maximum number of digits in the number of questions (example 999)
const TEST_LOAD_DELAY = 3;
const TEST_NOT_STARTED = '0';
const TEST_STARTED     = '1';
const TEST_COMPLETED   = '2';
const TEST_TIMED_OUT   = '3';

var test_clock;
var seconds_left;

//*******************Functions****************************

// Check to see if a student has or has not started taking a test, or has finished taking a test.
function check_status() {
	$.ajax({
		url: "ajax/get_test_status.php",
		data: {
			test_id : test_id,
			student_id : student_id
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

// Display the test questions.
function load_questions() {
	$.ajax({
		url: "ajax/get_questions.php",
		data: { test_id : test_id },
		success: function (questions) {
			$('#test_content').html(questions);
			number_questions();
			start_timer();
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
	
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").removeAttr("disabled");
	
	if(first_time) {
		$.ajax({
			url: "ajax/start_test.php",
			data: {
				test_id : test_id,
				student_id : student_id
			},
			success: function(data) {
				seconds_left = parseInt(data) + TEST_LOAD_DELAY;
				load_questions();
			}
		});
	}
	else {
		// get the timer based on what the current time value should be (check in the database).
		//end_time.setMinutes(end_time.getMinutes() + 2);
		load_questions();
	}
}

function complete_test() {
	var test = [];
	var question_count = 0;
	
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").attr("disabled", "disabled");
	
	$(".answer:checked").each(function(index){
		test[question_count++] = { question_id : $(this).attr('name'),
			                       answer_given : $(this).val()}
	});
	
	$(".studentEssayQuestion").each(function(index){
		test[question_count++] = { question_id : $(this).attr('name'),
			                       answer_given : $(this).val()}
	});
	
	$.ajax({
		url: "ajax/store_student_answers.php",
		data: { test : test,
		       student_id : student_id },
		success: function (pledge) {
			$('#test_content').html(pledge);
		}
	})
}

function disable_test () {
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_complete").removeAttr("disabled");
}

function start_timer() {
	countdown_time();
	test_clock = setInterval(countdown_time, 1000);
	setTimeout(disable_timer, seconds_left * 1000);
}

function countdown_time() {
	var minutes_left = Math.floor(seconds_left / 60);
	
	$("#div_minutes").html(minutes_left);
	$("#div_seconds").html(seconds_left-- % 60);
}

function disable_timer(){
	clearInterval(test_clock);
	
	$("#div_minutes").html("--");
	$("#div_seconds").html("--");	
}

//***********************Events************************
$(document).ready(function(){
	check_status();
	
	$("#btn_start").click(function(){
		start_test(true);
	});
	
	$("#btn_complete").click(function(){
		complete_test();
		disable_timer();
	});
});