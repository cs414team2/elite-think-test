const MULTIPLE_CHOICE_QUESTION_TYPE = "MC";
const TRUE_FALSE_QUESTION_TYPE = "TF";
const ESSAY_QUESTION_TYPE = "ESSAY";

//*******************Functions****************************
function add_question(question_type) {
	$.ajax({
		url: 'ajax/add_question.php',
		data: { 
			test_id: test_id,
			question_type: question_type
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

function delete_question(question_id) {
		$.ajax({
		url: 'ajax/delete_question.php',
		data: { question_id: question_id }
	});
}

//***********************Events************************
$(document).ready(function(){
	
	$("#btn_add_mc").click(function(){
		add_question(MULTIPLE_CHOICE_QUESTION_TYPE);
	});
	
	$("#btn_add_tf").click(function(){
		add_question(TRUE_FALSE_QUESTION_TYPE);
	});
	
	$("#btn_add_essay").click(function(){
		add_question(ESSAY_QUESTION_TYPE);
	});
});