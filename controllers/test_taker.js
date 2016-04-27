const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE      = 'TF';
const ESSAY_QUESTION_TYPE           = 'ESSAY';
const MATCHING_QUESTION_TYPE        = 'MATCH';
const MAX_TEST_SIZE   = 3; // Maximum number of digits in the number of questions (example 999)
const TEST_LOAD_DELAY = 3;
const TEST_NOT_STARTED = '0';
const TEST_STARTED     = '1';
const TEST_SUBMITTED   = '2';
const TEST_TIMED_OUT   = '3';

var test_clock;
var seconds_left;

//*********************************************************
//*                     Functions              			  *
//*********************************************************

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
					$("#btn_start").show();
					$("#btn_complete").attr("disabled", "disabled");
					break;
				case TEST_STARTED:
					start_test(false);
					break;
				case TEST_SUBMITTED:
					$("#btn_start").attr("disabled", "disabled");
					$("#btn_start").hide();
					$("#btn_complete").attr("disabled", "disabled");
					break;
				case TEST_TIMED_OUT:
					load_questions();
					disable_test();
					$("#test_content").show();
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
			updateProgressBar();
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
	$("#btn_start").hide();
	$("#btn_complete").removeAttr("disabled");
	$("#test_content").show();
	
	if(first_time) {
		$.ajax({
			url: "ajax/start_test.php",
			data: {
				test_id : test_id,
				student_id : student_id
			},
			success: function(data) {
				seconds_left = parseInt(data);
				load_questions();
			}
		});
	}
	else {
		$.ajax({
			url: "ajax/get_remaining_test_time.php",
			data: {
				test_id : test_id,
				student_id : student_id
			},
			success: function(data) {
				seconds_left = parseInt(data);
				load_questions();
			}
		});
	}
}

function submit_answers() {
	var test = [];
	var question_count = 0;
	var answer_count   = 0;
	
	$('#' + MULTIPLE_CHOICE_QUESTION_TYPE).find(".question_item").each(function(i, question) {
		$(question).find(".answer:checked").each(function(){
			answer_count++;
			test[question_count++] = { question_id : $(this).attr('name'),
			                          answer_given : $(this).val(),
									       question_type : MULTIPLE_CHOICE_QUESTION_TYPE }
		});
		if (answer_count == 0) {
			test[question_count++] = { question_id : $(this).attr('id'),
			                          answer_given : 'null',
											 question_type : MULTIPLE_CHOICE_QUESTION_TYPE }
		}
		answer_count = 0;
	});
	$('#' + TRUE_FALSE_QUESTION_TYPE).find(".question_item").each(function(i, question) {
		$(question).find(".answer:checked").each(function(){
			answer_count++;
			test[question_count++] = { question_id : $(this).attr('name'),
			                          answer_given : $(this).val(),
											 question_type : TRUE_FALSE_QUESTION_TYPE}
		});
		if (answer_count == 0) {
			test[question_count++] = { question_id : $(this).attr('id'),
			                          answer_given : 'null',
											 question_type : TRUE_FALSE_QUESTION_TYPE }
		}
		answer_count = 0;
	});
	
	$('.studentEssayQuestion').each(function(index){
		test[question_count++] = { question_id : $(this).attr('name'),
			                       answer_given : $(this).val(),
										 question_type : ESSAY_QUESTION_TYPE }
	});

	$('#' + MATCHING_QUESTION_TYPE).find('.question_item').each(function(){
		test[question_count++] = { question_id : $(this).data('question-id'),
										  answer_given : $(this).find('select').val(),
										 question_type : MATCHING_QUESTION_TYPE }
	});
	
	$.ajax({
		url: "ajax/store_student_answers.php",
		type: "POST",
		data: { test : test,
				  student_id : student_id },
		success: function(data) {
		}
	});
}

function disable_test () {
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_start").hide();
	$("#btn_complete").removeAttr("disabled");
	$(".answer").prop('disabled', true);
	$(".studentEssayQuestion").prop('disabled', true);
	$(".matching_input_box").prop('disabled', true);
	disable_timer();
}

function submit_pledge() {
	$("#btn_start").attr("disabled", "disabled");
	$("#btn_start").hide();
	$("#btn_complete").attr("disabled", "disabled");
	$.ajax({
		url : "ajax/submit_pledge.php",
		data: {
			test_id : test_id,
			student_id : student_id
		},
		success : function(){
			window.location = './';
			//                     Load the graded answers maybe
		}
	});
}

function start_timer() {
	countdown_time();
	test_clock = setInterval(countdown_time, 1000);
	setTimeout(disable_test, seconds_left * 1000);
}

function countdown_time() {
	var minutes_left = Math.floor(seconds_left / 60);
	
	if ((seconds_left % 5) == 0) {
		submit_answers();
	}
	updateProgressBar();
	
	$("#div_minutes").html(minutes_left < 10 ? "0" + minutes_left : minutes_left);
	$("#div_seconds").html((seconds_left % 60) < 10 ? "0" + (seconds_left % 60) : seconds_left % 60);
	seconds_left--;
}

function disable_timer(){
	clearInterval(test_clock);
	
	$("#div_minutes").html("--");
	$("#div_seconds").html("--");
}

function updateProgressBar(){
	var answered = 0;
	var total_questions = $(".question_item").length;
	$(".question_item").each(function(index){
		switch($(this).data("question-type")){
			case TRUE_FALSE_QUESTION_TYPE:
				if($(this).find("[type='radio']:checked").length > 0)
					answered++;
			
				break;
			case MULTIPLE_CHOICE_QUESTION_TYPE:
				if($(this).find("[type='radio']:checked").length > 0)
					answered++;			
			
				break;
			case ESSAY_QUESTION_TYPE:
				var essay_txt = $(this).find("#txt_eq_entry").val()
				if(jQuery.trim(essay_txt).length > 0)
					answered++;
			
				break;
			case MATCHING_QUESTION_TYPE:
				if($(this).find("select").val() != 'null')
					answered++;
			
				break;
		}
	});
	$("progress").val((answered/total_questions)*100);
	$("#questionAnswered").html(answered);
	$("#total").html(total_questions);
	$("#percentage").html(Math.round((answered/total_questions)*100));
	
}

//*********************************************************
//*                      Events                				 *
//*********************************************************
$(document).ready(function(){
	check_status();
	
	$("#btn_start").click(function(){
		start_test(true);
	});		
	
	$( "#btn_complete" ).click(function() {
		submit_answers();
		$( "#pledgeDialog" ).dialog( "open" );
	});
	
	$('#txt_pledge_signature').keypress(function(){
		$('#err_empty_signature').hide();
	});
	
	$( "#pledgeDialog" ).dialog({
		autoOpen: false,
		modal: true,
		width: 500,
		buttons: {
			"Sign Pledge": function() {
				
				var signature = $('#txt_pledge_signature').val();
				
				if (jQuery.trim(signature).length > 0) {
					disable_test();
					submit_pledge();
					$( this ).dialog( "close" );
				}
				else {
					$('#err_empty_signature').show();
				}
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		},
		show: {
			effect: "size",
			duration: 500
		},
		hide: {
			effect: "size",
			duration: 500
		},
		close: function(){
			$('#err_empty_signature').hide();
		}
	});
	
});