function add_question(test_id, question_type) {
	$.ajax({
		url: 'ajax/add_question.php',
		data { 
			test_id: test_id,
			question_type: question_type
		}
	});
}

function edit_question(question_id, question_type, question_text,
					   question_weight, question_number, answers) {
	$.ajax({
		url: 'ajax/edit_question.php',
		data {
			question_id: question_id,
			question_type: question_type,
			question_text: question_text,
			question_weight: question_weight,
			question_number: question_number,
			answers: answers
		}
	});
}

function delete_question(question_id) {
		$.ajax({
		url: 'ajax/delete_question.php',
		data { question_id: question_id }
	});
}