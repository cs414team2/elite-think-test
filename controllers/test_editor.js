const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE = 'TF';
const ESSAY_QUESTION_TYPE = 'ESSAY';
const DEFAULT_QUESTION_WEIGHT = 1; // Should change this after we add ability to set a specific weight.
const MAX_TEST_SIZE = 3;

//*******************Functions****************************
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

function add_question(question_type, question_text) {

	var question_weight = DEFAULT_QUESTION_WEIGHT;
	var answers = [{answer_text: "", is_correct: "" }];
	var validated = true;
	
	if (question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {					   
		
		if (jQuery.trim(question_text).length <= 0) {
			validated = false;
		}
		else {
			$(".mc_answer").each(function (index) {
				var answer = $(this).val();
				
				if (jQuery.trim(answer).length <= 0) {
					validated = false;
					$(this).attr("placeholder", "Answer cannot be left blank.");
				}
				else {
					answers[index] = {answer_text: answer, is_correct : false ? "Y" : "N"};
				}
			});
			if (validated) {
				$("[name='rb_is_answer']").each(function(index){
					answers[index].is_correct = $(this).prop("checked") ? "Y" : "N";
				});
			}
		}
	}
	else if (question_type == TRUE_FALSE_QUESTION_TYPE) {
		answers = [{answer_text: $("#rb_answer_true").prop( "checked" ) ? "T" : "F",
                      is_correct: "Y" }];
	} 
	
	if(validated){
		$.ajax({
			url: 'ajax/add_question.php',
			data: { 
				test_id: test_id,
				question_type: question_type,
				question_text: question_text,
				question_weight: question_weight,
				answers: answers
			},
			success: function (question) {
				$("#" + question_type).append(question);
				$("#" + question_type).show();
				number_questions();
				clear_question_fields(question_type);
				// Commented out to avoid focus on adding question
				// $('html, body').animate({scrollTop: $("#" + question_type).height() }, 1);
			}
		});
	}

}

function edit_question(question_id, question_type, question_text,
					   question_weight, answers) {
	$.ajax({
		url: 'ajax/edit_question.php',
		data: {
			question_id: question_id,
			question_type: question_type,
			question_text: question_text,
			question_weight: question_weight,
			answers: answers
		}
	});
}

function delete_question(question) {
		var question_id = question.id;
		
		var section_thingy = question.parentElement;
		
		$.ajax({
		url: 'ajax/delete_question.php',
		data: { question_id: question_id },
		success: function(data) {
			question.remove();
			number_questions();
			if ($(section_thingy).children().length == 0 )
				$(section_thingy).hide();
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

function clear_question_fields(question_type) {
	switch (question_type) {
		case MULTIPLE_CHOICE_QUESTION_TYPE:
			$("#txt_mcq_entry").val('');
			$(".mc_answer").each(function(){
				$(this).val('');
				$(this).attr("placeholder", "");
			});
			break;
		case TRUE_FALSE_QUESTION_TYPE:
			$("#txt_tfq_entry").val('');
			$("#rb_answer_true").prop('checked', true);
			break;
		case ESSAY_QUESTION_TYPE:
			$("#txt_eq_entry").val('');
			break;
		default:
			$(".questionStyle").val('');
			break;
	}
}

//***********************Events************************
$(document).ready(function(){
	load_questions();
		
	// Code to execute on Adding a TF Question
	$('#btn_add_tf').click(function(){
		var tfTextbox = $("#txt_tfq_entry").val();
		var validated = true;
		
		if (jQuery.trim(tfTextbox).length <= 0) {
			$("#err_empty_tf").show();
			validated = false;
		}
	
		if (validated)
		{
			add_question(TRUE_FALSE_QUESTION_TYPE, $("#txt_tfq_entry").val());
		}	
	});
	
	// Code to execute on Adding a Multiple Choice Question
	$('#btn_add_mc').click(function(){
		var mcTextbox = $("#txt_mcq_entry").val();
		var validated = true;
		
		if (jQuery.trim(mcTextbox).length <= 0) {
			$("#err_empty_mc").show();
			validated = false;
		}
	
		if (validated)
		{
			add_question(MULTIPLE_CHOICE_QUESTION_TYPE, $("#txt_mcq_entry").val());
		}
	});
	
	// Code to execute on Adding an Essay Question
	$('#btn_add_essay').click(function(){
		var eqTextbox = $("#txt_eq_entry").val();
		var validated = true;
		
		if (jQuery.trim(eqTextbox).length <= 0) {
			$("#err_empty_eq").show();
			validated = false;
		}
	
		if (validated)
		{	
			add_question(ESSAY_QUESTION_TYPE, $("#txt_eq_entry").val());
		}
	});
	
	// Remove the error message for a field as a user types in it
	$("#txt_tfq_entry").keypress(function(){
		$("#err_empty_tf").hide();
	});
	$("#txt_mcq_entry").keypress(function(){
		$("#err_empty_mc").hide();
	});
	$("#txt_eq_entry").keypress(function(){
		$("#err_empty_eq").hide();
	});
	
	// Code to Reset all error messages on button reset
	$('.reset').click(function(){
		$("#err_empty_tf").hide();
		$("#err_empty_mc").hide();
		$("#err_empty_eq").hide();
	});
});