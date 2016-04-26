const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE      = 'TF';
const ESSAY_QUESTION_TYPE           = 'ESSAY';
const MATCHING_QUESTION_TYPE        = 'MATCH';
const DEFAULT_QUESTION_WEIGHT = 1;
const MAX_TEST_SIZE           = 3;
const MAX_MINUTE_DIGITS       = 4;
const MAX_POINT_DIGITS        = 2;

//****************************************************************
//*                        Functions                             *
//****************************************************************
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
	var question_weight = parseInt($("#txt_" + question_type.toLowerCase() + "_weight").val());
	var answers         = [];
	var validated       = true;
		
	if (jQuery.trim(question_text).length <= 0 || !(question_weight > 0)) {
		$("#err_empty_tf").show();
		$("#err_empty_mc").show();
		$("#err_empty_eq").show();
		validated = false;
	}
	
	if (question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {					   
		
		if (jQuery.trim(question_text).length <= 0) {
			validated = false;
		}
		else {
			$('.mc_answer').each(function (index) {
				var answer = $(this).find('.answer_text').val();
				
				if (jQuery.trim(answer).length <= 0) {
					validated = false;
					$(this).find('.answer_text').attr('placeholder', 'Answer cannot be left blank.');
				}
				else {
					answers[index] = {answer_text: answer, is_correct : $(this).find('[name="rb_is_answer"]').prop('checked') ? 'Y' : 'N'};
				}
			});
			$('#msg_adding_mc').show();
		}
	}
	else if (question_type == TRUE_FALSE_QUESTION_TYPE) {
		answers = [{answer_text: $("#rb_answer_true").prop( "checked" ) ? "T" : "F",
                     is_correct: "Y" }];
		$('#msg_adding_tf').show();
	}
	else if (question_type == ESSAY_QUESTION_TYPE) {
		answers = [{answer_text : $("#txt_essay_answer").val(),
		            is_correct : "Y"}];
		$('#msg_adding_essay').show();
	}
	
	clear_question_fields();
	
	if(validated){
	$.ajax({
			url: 'ajax/add_question.php',
			type: 'POST',
			data: { 
				test_id: test_id,
				question_type: question_type,
				question_text: question_text,
				question_weight: question_weight,
				answers: answers
			},
			success: function (question) {
				$("#" + question_type).find("ul").append(question);
				$("#" + question_type).show();
				number_questions();
				
				$('.adding_message').hide();
			},
			error: function(error) {
				alert('Question was not added!');
			}
		});
	}
	else {
		$('.adding_message').hide();
	}

}

function add_matching_section() {
	var validated   	  = true;
	var description 	  = $('#txt_matchq_entry').val();
	var question_weight = parseInt($('#txt_match_weight').val());
	var question    	  = [];
	var answer      	  = [];
	var question_count  = 0;
	var answer_count    = 0;
	
	if (jQuery.trim(description).length <= 0 || !(question_weight > 0)) {
		validated = false
		$('#err_empty_match').show();
	}
	
	$('.match_question').each(function(){
		var question_text = $(this).find('.txt_match_question').val();
		
		if (jQuery.trim(question_text).length > 0) {
			question[question_count++] = { text : question_text,
			                             answer : $(this).find('.ddl_matched_answer').val(), 
												  id     : null};
		}
	});
	
	$('.txt_match_answer').each(function(index){
		var answer_text = $(this).val();
		
		if (jQuery.trim(answer_text).length > 0) {
			answer[answer_count++] = { text : answer_text,
											  index : index,
											  id    : null };
		}
	});
	
	if (question.length == 0) {
		validated = false;
		$('#err_empty_match_question').show();
	}
	if (answer.length == 0) {
		validated = false;
		$('#err_empty_match_answer').show();
	}
	$('#msg_adding_match').show();
	
	if (validated) {
		for (i in question) {
			validated = false;
			
			for (j in answer){
				if (question[i].answer == answer[j].index) {
					validated = true;
				}
			}
			
			if (validated == false){
				$('#err_unlinked_match_question').show();
				break;
			}
		}
	}
	
	if (validated){
		$.ajax({
			url: 'ajax/add_matching_section.php',
			data: {
				test_id : test_id,
				section_description: description,
				question_weight: question_weight,
				questions : question,
				answers : answer
			},
			success: function(section) {
				$('#' + MATCHING_QUESTION_TYPE).find('.section_list').append(section);
				$('#' + MATCHING_QUESTION_TYPE).show();
				number_questions();
				clear_question_fields();
				$('.adding_message').hide();
			}
		});
	}
	else {
		$('.adding_message').hide();
	}
}

function add_mc_answer(answer_text, is_answer) {

	$('#area_mc_answers').append(
	  "\r\n <div class='mc_answer'>"
	  + "\r\n		<br />"
	  + "\r\n		<label for='txt_mc_answer_' class='questionLabel letter_label'></label>"
	  + "\r\n		<input id='txt_mc_answer_' type='text' name='txt_mc_answer_' class='questionStyle answer_text' maxlength='500'>"
	  + "\r\n		<input type='radio' id='rb_is_answer_' name='rb_is_answer'"
	  +	(is_answer ? "checked" : "")
	  +">"
	  + "\r\n		<label for='rb_is_answer_' class='questionLabel radio_label'>Answer</label>"
	  + "<img src='images/delete.png' class='clickable_img clickable_img_circular' title='Delete Answer' style='width: 29px; height: 29x;' onclick='delete_multiple_choice_answer(this.parentElement)'/>"
	  + "\r\n	</div>"
	);
	
	$(".answer_text").keypress(function(){
		$("#err_unanswered_mc").hide();
	});
	number_answers();
}

// Fill the question dropdowns that link a question to an answer.
function fill_matching_answer_ddls() {
	var alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
	var answer_count;
	$('.ddl_matched_answer').html('');
	
	for (answer_count = 0; answer_count < $('.txt_match_answer').length; answer_count++){
		$('.ddl_matched_answer').append('<option value="' + answer_count + '">' + alphabet[answer_count] + '</option>');
	}
}

// Open a form to edit a question
function open_question_editor(question) {
	var question_id   = question.id;
	var question_type = question.getAttribute('data-question-type');
	var question_text = $(question).find('.question_text').html();
	var question_weight = $(question).find('.question_weight').text();
	var answers = [];
	
	$(question).find(".answer").each(function(index){
		answers[index] = { id : $(this).data("answer-id"),
		                   content : $(this).html(),
						   is_correct : $(this).data("is-correct")};
	});
	
	$("#dlg_" + question_type.toLowerCase()).data("question-id", question_id);
	$("#dlg_" + question_type.toLowerCase()).dialog('option', 'show', {
		effect: "size",
		duration: 500
	});
	switch(question_type){
		case TRUE_FALSE_QUESTION_TYPE:
			$("#txt_tfq_entry").val(html_special_chars_decode(question_text));
			
			$("#dlg_tf").data("answer-id", answers[0].id);
			if (answers[0].content.substr(0, 1) == "T") {
				$("#rb_answer_true").prop( "checked", true );
			}
			else {
				$("#rb_answer_false").prop( "checked", true );
			}
			$("#txt_tf_weight").val(question_weight);
		
			$("#btn_add_tf").unbind("click");
			$("#btn_add_tf").click(function() {
				edit_question($("#dlg_tf").data("question-id"), TRUE_FALSE_QUESTION_TYPE);
			});
			break;
		case MULTIPLE_CHOICE_QUESTION_TYPE:
			$("#txt_mcq_entry").val(html_special_chars_decode(question_text));
			
			$('#area_mc_answers').html('');
			for (i in answers) {
				$('#area_mc_answers').append(
					"\r\n <div class='mc_answer' data-answer-id='" + answers[i].id + "'>"
				  + "\r\n		<br />"
				  + "\r\n		<label for='txt_mc_answer_' class='questionLabel letter_label'></label>"
				  + "\r\n		<input id='txt_mc_answer_' type='text' value='" + answers[i].content + "' name='txt_mc_answer_' maxlength='500' class='questionStyle answer_text'>"
				  + "\r\n		<input type='radio' id='rb_is_answer_' name='rb_is_answer'"
				  +	(answers[i].is_correct == "Y" ? "checked" : "")
				  +">"
				  + "\r\n		<label for='rb_is_answer_' class='questionLabel radio_label'>Answer</label>"
				  + "<img src='images/delete.png' class='clickable_img clickable_img_circular' title='Delete Answer' style='width: 29px; height: 29x;' onclick='delete_multiple_choice_answer(this.parentElement)'/>"
				  + "\r\n	</div>"
				);
			}
			
			$(".answer_text").keypress(function(){
				$("#err_unanswered_mc").hide();
			});
			number_answers();
			
			$("#txt_mc_weight").val(question_weight);
		
			$("#btn_add_mc").unbind("click");
			$("#btn_add_mc").click(function() {
				edit_question($("#dlg_mc").data("question-id"), MULTIPLE_CHOICE_QUESTION_TYPE);
			});
			break;
		case ESSAY_QUESTION_TYPE:
			if (answers[0].content == "(no description)")
				answers[0].content = "";
			$("#txt_eq_entry").val(html_special_chars_decode(question_text));

			$("#txt_essay_answer").data("answer-id", answers[0].id);
			$("#txt_essay_answer").val(html_special_chars_decode(answers[0].content));
			$("#txt_essay_weight").val(question_weight);
			
			$("#btn_add_essay").unbind("click");
			$("#btn_add_essay").click(function() {
				edit_question($("#dlg_essay").data("question-id"), ESSAY_QUESTION_TYPE);
			});
			break;
	}

	$("#dlg_" + question_type.toLowerCase()).dialog("open");
}

function edit_question(question_id, question_type) {
	var question_text;
	var question_weight;
	var validated = true;
	var answers   = [];

	switch(question_type) {
		case TRUE_FALSE_QUESTION_TYPE:
			question_text = $("#txt_tfq_entry").val();
			answers[0] = {answer_id : $("#dlg_tf").data("answer-id"),
			              answer_text : $("#rb_answer_true").prop("checked") ? "T" : "F",
						  is_correct : "Y"}
			question_weight = $("#txt_tf_weight").val();
			break;
		case MULTIPLE_CHOICE_QUESTION_TYPE:
			question_text = $("#txt_mcq_entry").val();
			$('.mc_answer').each(function (index) {
				var answer = $(this).find('.answer_text').val();
				
				if (jQuery.trim(answer).length <= 0) {
					validated = false;
					$(this).find('.answer_text').attr('placeholder', 'Answer cannot be left blank.');
				}
				else {
					answers[index] = { answer_id : null,
					                 answer_text : answer,
									      is_correct : $(this).find("[name='rb_is_answer']").prop("checked") ? "Y" : "N"};
				}
			});
			question_weight = $("#txt_mc_weight").val();
			break;
		case ESSAY_QUESTION_TYPE:
			question_text = $("#txt_eq_entry").val();
			answers[0] = {answer_id : $("#txt_essay_answer").data("answer-id"),
						  answer_text : $("#txt_essay_answer").val(),
						  is_correct : "Y"}
			question_weight = $("#txt_essay_weight").val();
			break;
		default:
			validated = false;
			break;
	}

	if (jQuery.trim(question_text).length <= 0 || !(question_weight > 0)) {
		$("#err_empty_tf").show();
		$("#err_empty_mc").show();
		$("#err_empty_eq").show();
		validated = false;
	}
	
	if (validated) {	
		question_text = question_text.trim();
		question_text = question_text[0].toUpperCase() + question_text.substr(1);
		
		$.ajax({
			url: 'ajax/edit_question.php',
			type: 'POST',
			data: {
				question_id: question_id,
				question_type: question_type,
				question_text: question_text,
				question_weight: question_weight,
				answers: answers
			},
			success : function(edited_answers){
				$("#" + question_id).find(".question_text").html(html_special_chars(question_text));
				$("#" + question_id).find(".question_weight").html(question_weight);
				if (question_type == TRUE_FALSE_QUESTION_TYPE){
					if (answers[0].answer_text == "T") {
						$("#" + question_id).find(".true_answer").data("answer-id", answers[0].answer_id);
						$("#" + question_id).find(".true_answer").css("color" , "#47CC7A");
						$("#" + question_id).find(".true_answer").removeClass("answer").addClass("answer");
						$("#" + question_id).find(".true_answer").html("True &#10004;");
						
						$("#" + question_id).find(".false_answer").removeData("answer-id");
						$("#" + question_id).find(".false_answer").css("color" , "#CC1C11");
						$("#" + question_id).find(".false_answer").removeClass("answer");
						$("#" + question_id).find(".false_answer").html("False &#10006;");
					}
					else {
						$("#" + question_id).find(".false_answer").data("answer-id", answers[0].answer_id);
						$("#" + question_id).find(".false_answer").css("color" , "#47CC7A");
						$("#" + question_id).find(".false_answer").removeClass("answer").addClass("answer");
						$("#" + question_id).find(".false_answer").html("False &#10004;");
						
						$("#" + question_id).find(".true_answer").removeData("answer-id");
						$("#" + question_id).find(".true_answer").css("color" , "#CC1C11");
						$("#" + question_id).find(".true_answer").removeClass("answer");
						$("#" + question_id).find(".true_answer").html("True &#10006;");
					}
				}
				else if (question_type == MULTIPLE_CHOICE_QUESTION_TYPE){
					$("#" + question_id).find("ol").html(edited_answers);
				}
				else {
					$("#" + question_id).find(".answer").each(function(index){
						if (answers[index].answer_text == "")
							answers[index].answer_text = "(no description)";
						
						$(this).html(html_special_chars(answers[index].answer_text));
						
						
					});
				}
				$("#" + question_id).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
				$("#dlg_" + question_type.toLowerCase()).dialog("close");
			}
		});
	}
}

function open_matching_section_editor(section) {
	var section_id      = section.getAttribute('data-section-id');
	var section_desc    = $(section).find('.section_desc').html();
	var question_weight = DEFAULT_QUESTION_WEIGHT;
	var question = [];
	var answer   = [];
	
	$(section).find('.question_item').each(function(index){
		question_weight = $(this).data('weight');
		question[index] = { text : $(this).find('.question_text').html(),
								  answer_id : $(this).data('matching-answer-id')} 
	});
	
	$(section).find('.answer_item').each(function(index){
		answer[index] = { id : $(this).data('answer-id'),
                        text : $(this).find('.answer_text').html(),
								index : index }
	});
	
	$('#dlg_match').data('section-id', section_id);
	$('#dlg_match').dialog('option', 'show', {
		effect: "size",
		duration: 500
	});

	$("#txt_matchq_entry").val(section_desc);
	$('#txt_match_weight').val(question_weight);
	$('.txt_match_answer').each(function(index){
		if (index < answer.length)
			$(this).val(answer[index].text);
	});
	$('.match_question').each(function(index){
		var matched_answer;
		if (index < question.length) {
			$(this).find('.txt_match_question').val(question[index].text);
			
			for(i in answer) {
				if (question[index].answer_id == answer[i].id) {
					$(this).find('.ddl_matched_answer').val(answer[i].index);
				}
			}
		}
	});
	
	$('#btn_add_match_section').unbind('click');
	$('#btn_add_match_section').click(function() {
		edit_matching_section();
	});
	
	$('#dlg_match').dialog('open');
}

function edit_matching_section(){
	var validated   	  = true;
	var section_id      = $('#dlg_match').data('section-id');
	var description 	  = $('#txt_matchq_entry').val();
	var question_weight = parseInt($('#txt_match_weight').val());
	var question    	  = [];
	var answer      	  = [];
	var question_count  = 0;
	var answer_count    = 0;
	
	if (jQuery.trim(description).length <= 0 || !(question_weight > 0)) {
		validated = false
		$('#err_empty_match').show();
	}
	
	$('.match_question').each(function(){
		var question_text = $(this).find('.txt_match_question').val();
		
		if (jQuery.trim(question_text).length > 0) {
			question[question_count++] = { text : question_text,
			                             answer : $(this).find('.ddl_matched_answer').val(), 
										 id     : null};
		}
	});
	
	$('.txt_match_answer').each(function(index){
		var answer_text = $(this).val();
		
		if (jQuery.trim(answer_text).length > 0) {
			answer[answer_count++] = { text : answer_text,
									  index : index,
									  id    : null };
		}
	});
	
	if (question.length == 0) {
		validated = false;
		$('#err_empty_match_question').show();
	}
	if (answer.length == 0) {
		validated = false;
		$('#err_empty_match_answer').show();
	}
	
	if (validated) {
		for (i in question) {
			validated = false;
			
			for (j in answer){
				if (question[i].answer == answer[j].index) {
					validated = true;
				}
			}
			
			if (validated == false){
				$('#err_unlinked_match_question').show();
				break;
			}
		}
	}
	
	if (validated){
		

		$.ajax({
			url: 'ajax/edit_matching_section.php',
			data: {
				test_id : test_id,
				section_id : section_id,
				section_description: description,
				question_weight: question_weight,
				questions : question,
				answers : answer
			},
			success: function(section) {
				$('[data-section-id="' + section_id + '"]').fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeOut(100).fadeIn(100);
				var temp_div = document.createElement('div');
				temp_div.innerHTML = section;

				$('[data-section-id="' + section_id + '"]').html('');
				
				$(temp_div).children().each(function(){
					$('[data-section-id="' + section_id + '"]').append($(this).html());
				});
				
				$('#dlg_match').dialog('close');
				number_questions();
				clear_question_fields();
			}
		});
	}
}

function delete_question(question) {
		var question_id = question.id;
		var section = question.parentElement;
		
		$.ajax({
		url: 'ajax/delete_question.php',
		data: { question_id: question_id,
				  test_id: test_id},
		success: function(data) {
			question.remove();
			number_questions();
			if ($(section).children().length == 0 )
				$("#" + question.getAttribute('data-question-type')).hide();
		}
	});
}

function delete_multiple_choice_answer(answer) {
	if($(answer).find('input[type="radio"]').prop('checked')) {
		$('#err_unanswered_mc').show();
	}
	else {
		$(answer).remove();
		number_answers();
		$("#err_unanswered_mc").hide();
	}
}

function delete_matching_section(section) {
	var section_id = section.getAttribute('data-section-id');
	var section_area = section.parentElement;
	
	$.ajax({
		url: 'ajax/delete_matching_section.php',
		data: { section_id : section_id },
		success: function(data) {
			$(section).remove();
			number_questions();
			if ($(section_area).children().length == 0)
				$('#MATCH').hide();
		}
	});
}

// Delete the current test draft.
function delete_draft() {
	$.ajax({
		url: "ajax/delete_test.php",
		data : {test_id : test_id}
	});
	window.location = "./";
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

// Display the multiple choice answer letters
function number_answers() {
	var alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	
	$('.mc_answer').each(function(index){
		$(this).find('.letter_label').html(alphabet[index] + ') ');
		$(this).find('.letter_label').prop('for', 'txt_mc_answer_' + index);
		$(this).find('.answer_text').prop('id', 'txt_mc_answer_' + index);
		$(this).find('input[type="radio"]').prop('id', 'rb_is_answer_' + index);
		$(this).find('.radio_label').prop('for', 'rb_is_answer_' + index);
	});
}

// Swap the given question with the question above it.
function raise_question(question) {
	var prev_question = $(question).prev();
	if ($(prev_question).length > 0) {
		$.ajax({
			url: 'ajax/swap_questions.php',
			data : {
				question_id_1 : $(question).attr('id'),
				question_id_2 : $(prev_question).attr('id')
			},
			success : function(data){
				$(question).insertBefore($(prev_question));
				number_questions();
			}
		});
	}
}

// Swap the given question with the question below it.
function lower_question(question) {
	var next_question = $(question).next();
	if ($(next_question).length > 0) {
		$.ajax({
			url: 'ajax/swap_questions.php',
			data : {
				question_id_1 : $(question).attr('id'),
				question_id_2 : $(next_question).attr('id')
			},
			success : function(){
				$(question).insertAfter($(next_question));
				number_questions();
			}
		});
	}
}

// Swap the given section with the section above it.
function raise_section(section) {
	var prev_section = $(section).prev();
	if ($(prev_section).length > 0) {
		$.ajax({
			url: 'ajax/swap_sections.php',
			data : {
				section_id_1 : $(section).data('section-id'),
				section_id_2 : $(prev_section).data('section-id')
			},
			success : function() {
				$(section).insertBefore($(prev_section));
				number_questions();
			}
		});
	}
}

// Swap the given section with the section below it.
function lower_section(section){
	var next_section = $(section).next();
	if ($(next_section).length > 0) {
		$.ajax({
			url: 'ajax/swap_sections.php',
			data : {
				section_id_1 : $(section).data('section-id'),
				section_id_2 : $(next_section).data('section-id')
			},
			success : function(data) {
				$(section).insertAfter($(next_section));
				number_questions();
			}
		});
	}
}

function clear_error_messages() {
	$("#err_empty_tf").hide();
	$("#err_empty_mc").hide();
	$("#err_unanswered_mc").hide();
	$("#err_empty_eq").hide();
	$("#err_empty_match").hide();
	$("#err_empty_match_question").hide();
	$("#err_unlinked_match_question").hide();
	$("#err_empty_match_answer").hide();
	$('.adding_message').hide();
}

function clear_question_fields() {
	$("#txt_mcq_entry").val('');
	$(".mc_answer").each(function(){
		$(this).find('.answer_text').val('');
		$(this).find('.answer_text').attr("placeholder", "");
	});
	
	$("#txt_tfq_entry").val('');
	$("#rb_answer_true").prop('checked', true);
	
	$("#txt_eq_entry").val('');
	$("#txt_essay_answer").val('');
	
	$("#txt_matchq_entry").val('');
	$(".txt_match_question").val('');
	$(".txt_match_answer").val('');
	$(".ddl_matched_answer").val(0);
	
	$(".weight_entry").val(DEFAULT_QUESTION_WEIGHT);
	$('.adding_message').hide();
}

// Change the time limit for a test.
function update_time_info() {
	var date_due    = $("#datepicker").datepicker( "getDate" );
	var date_active = $("#activeDatepicker").datepicker( "getDate" );
	var time_limit  = $("#txt_time_limit").val();
	var validated = true;
	
	if (isNaN(parseInt(time_limit))) {
		validated = false;
		$("#txt_time_limit").val($("#txt_time_limit").attr('name'));
	}

	if (date_active != null) {
		if (date_due.getDate() == date_active.getDate()) {
			date_due.setDate(date_active.getDate() + 1);
			$("#datepicker").datepicker( "setDate", date_due );
		}
		else if (date_due < date_active) {
			date_due.setDate(date_active.getDate() + 1);
			$("#datepicker").datepicker( "setDate", date_due );
		}
	}
	
	if (validated) {
		$.ajax({
			url : "ajax/update_test_time_info.php",
			data : {
				test_id : test_id,
				date_due : date_due.getTime() / 1000,
				date_active : (date_active != null ? date_active.getTime() / 1000 : null),
				time_limit : time_limit
			}
		});
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

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	var default_dialog = {
		autoOpen: false,
		modal: true,
		width: 500,
		maxHeight: 675,
		show: {
			effect: "drop",
			duration: 500
		},
		hide: {
			effect: "size",
			duration: 500
		},
		close: function() {
			clear_question_fields();
			clear_error_messages();
		}
	};
	
	load_questions();
	fill_matching_answer_ddls();

	// close dialog boxes when clicking outside of them.
	$("body").on("click",".ui-widget-overlay",function() {
		$(".ui-dialog-titlebar-close").click();
    });
	
	// Prevent negatives, decimals, and the enter key from being input in number boxes.
	$('input[type="number"]').keydown(function(event){
		if(event.keyCode == 109 || event.keyCode == 189       // Negative keycode
           || event.keyCode == 190 || event.keyCode == 110    // Decimal keycode
           || event.keyCode == 13 )
			event.preventDefault();
	});
	
	// Set the Dialog boxes and transition effects
	$( "#dlg_tf" ).dialog(default_dialog);
	$( "#dlg_mc" ).dialog(default_dialog);
	$( "#dlg_mc" ).dialog( "option", "width", 600 );
	$( "#dlg_essay" ).dialog(default_dialog);
	$( "#dlg_match" ).dialog(default_dialog);
	$( "#dlg_match" ).dialog( "option", "width", 800 );
	$( "#dlg_match" ).dialog( "option", "maxHeight", 700 );
	
	$("#txt_time_limit").on('input', function () {
		if ($(this).val().length > MAX_MINUTE_DIGITS) {
			$(this).val($(this).val().slice(0, MAX_MINUTE_DIGITS));
		}
    });
	 
	$(".weight_entry").on('input', function () {
		if ($(this).val().length > MAX_POINT_DIGITS) {
			$(this).val($(this).val().slice(0, MAX_POINT_DIGITS));
		}
   });
	
	// Change the time limit for a test.
	$("#txt_time_limit").blur(function (){
		update_time_info();
	});
		
	// Code to execute on Adding a TF Question
	$('#btn_add_tf').click(function() {
		add_question(TRUE_FALSE_QUESTION_TYPE, $("#txt_tfq_entry").val());
	});
	
	// Code to execute on Adding a Multiple Choice Question
	$('#btn_add_mc').click(function() {
		add_question(MULTIPLE_CHOICE_QUESTION_TYPE, $("#txt_mcq_entry").val());
	});
	
	// Code to execute on Adding an Essay Question
	$('#btn_add_essay').click(function() {
		add_question(ESSAY_QUESTION_TYPE, $("#txt_eq_entry").val());
	});
	
	// Add a Matching Section
	$('#btn_add_match_section').click(function() {
		add_matching_section();
	});
	
	// Add a matching question
	$("#btn_insert_match_question").click(function(){
		insert_matching_question();
	});
	// Add a matching answer
	$("#btn_insert_match_answer").click(function(){
		insert_matching_answer();
	});
	
   	$('#btn_save_draft').click(function() {
		window.location = "./";
	});
	
	$('#btn_post_test').click(function() {
		$('#dlg_confirm_post').dialog({
			modal: true,
			width: 500,
			maxHeight: 400,
			title: "Make this test active",
			show: {
				effect: "size",
				duration: 500
			},
			hide: {
				effect: "size",
				duration: 500
			},
			buttons: {
				"Yes": function() {
					$( "#activeDatepicker" ).datepicker("setDate", new Date());
					update_time_info();
					window.location = "./";
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			}
		});
	});
	
	$('#btn_delete_test').click(function(){
		$('#dlg_confirm_delete').dialog({
			modal: true,
			width: 500,
			maxHeight: 400,
			title: "Delete This Draft",
			show: {
				effect: "size",
				duration: 500
			},
			hide: {
				effect: "size",
				duration: 500
			},
			buttons: {
				"Yes": function() {
					delete_draft();
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			}
		});
	});

	// Remove the error message for a field as a user types in it
	$("#txt_tfq_entry").keypress(function(){
		$("#err_empty_tf").hide();
	});
	$("#txt_mcq_entry").keypress(function(){
		$("#err_empty_mc").hide();
		$("#err_unanswered_mc").hide();
	});
	$(".answer_text").keypress(function(){
		$("#err_unanswered_mc").hide();
	});
	$("#txt_eq_entry").keypress(function(){
		$("#err_empty_eq").hide();
	});
	$("#txt_matchq_entry").keypress(function(){
		$("#err_empty_match").hide();
	});
	$(".txt_match_question").keypress(function(){
		$("#err_empty_match_question").hide();
	});
	$(".txt_match_answer").keypress(function(){
		$("#err_empty_match_answer").hide();
	});
	$(".ddl_matched_answer").click(function(){
		$("#err_unlinked_match_question").hide();
	});
	
	$(".weight_entry").keypress(function(){
		clear_error_messages();
	});
	
	// Code to Reset all error messages on button reset
	$('.reset').click(clear_error_messages);
	
	// Open a dialog box if a user clicks the open button.
	$( "#btn_open_TFDialog" ).click(function() {
		$("#dlg_tf").data("question-id", 0);
		
		
		$("#dlg_tf").dialog('option', 'show', {
			effect: "drop",
			duration: 500
		});
		$("#btn_add_tf").unbind("click");
		$("#btn_add_tf").click(function() {
			add_question(TRUE_FALSE_QUESTION_TYPE, $("#txt_tfq_entry").val());
		});
		$( "#dlg_tf" ).dialog( "open" );
	});	
	$( "#btn_open_MCDialog" ).click(function() {
		$("#dlg_mc").data("question-id", 0);
		
		$('#area_mc_answers').html('');
		
		add_mc_answer('', true);
		add_mc_answer('', false);
		add_mc_answer('', false);
		add_mc_answer('', false);
		
		$(".mc_answer").each(function(){
			$(this).data("answer-id", 0);
		});
		$("#dlg_mc").dialog('option', 'show', {
			effect: "drop",
			duration: 500
		});
		$("#btn_add_mc").unbind("click");
		$("#btn_add_mc").click(function() {
			add_question(MULTIPLE_CHOICE_QUESTION_TYPE, $("#txt_mcq_entry").val());
		});
		$( "#dlg_mc" ).dialog( "open" );
	});
	$( "#btn_open_EssayDialog" ).click(function() {
		$("#dlg_essay").data("question-id", 0);
		$("#txt_essay_answer").data("answer-id", 0);
		
		$("#dlg_essay").dialog('option', 'show', {
			effect: "drop",
			duration: 500
		});
		$("#btn_add_essay").unbind("click");
		$("#btn_add_essay").click(function() {
			add_question(ESSAY_QUESTION_TYPE, $("#txt_eq_entry").val());
		});
		$( "#dlg_essay" ).dialog( "open" );
	});
	$("#btn_open_MatchDialog").click(function() {
		fill_matching_answer_ddls();
		$("#dlg_match").data("section-id", 0);
		
		$("#dlg_match").dialog('option', 'show', {
			effect: "drop",
			duration: 500
		});
		
		$("#btn_add_match_section").unbind("click");
		$('#btn_add_match_section').click(function() {
			add_matching_section();
		});
		$( "#dlg_match" ).dialog( "open" );
	});
});