const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE = 'TF';
const ESSAY_QUESTION_TYPE = 'ESSAY';
const DEFAULT_QUESTION_WEIGHT = 1; // Should change this after we add ability to set a specific weight.

//*******************Functions****************************
function add_question(question_type, question_text) {

	var question_weight = DEFAULT_QUESTION_WEIGHT;
	
	$.ajax({
		url: 'ajax/add_question.php',
		data: { 
			test_id: test_id,
			question_type: question_type,
			question_text: question_text,
			question_weight: question_weight
		},
		success: function (question) {
			
			$("#test_content").append(question);
			number_questions();
			clear_question_fields(question_type);
		}
	});

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
		
		$.ajax({
		url: 'ajax/delete_question.php',
		data: { question_id: question_id },
		success: function(data) {
			question.remove();
			number_questions();
		}
	});
}

function number_questions() {
	$( ".question_number" ).each(function( index ) {
		$(this).html(index + 1);
	});
}

function clear_question_fields(question_type) {
	
	switch (question_type) {
		case MULTIPLE_CHOICE_QUESTION_TYPE:
			$("#txt_mcq_entry").val('');
			$("#mcAnswer1").val('');
			$("#mcAnswer2").val('');
			$("#mcAnswer3").val('');
			$("#mcAnswer4").val('');
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
	
	$('#btn_add_mc').click(function(){
		add_question(MULTIPLE_CHOICE_QUESTION_TYPE, $("#txt_mcq_entry").val());
	});
	
	$('#btn_add_tf').click(function(){
		add_question(TRUE_FALSE_QUESTION_TYPE, $("#txt_tfq_entry").val());
	});
	
	$('#btn_add_essay').click(function(){
		add_question(ESSAY_QUESTION_TYPE, $("#txt_eq_entry").val());
	});
});