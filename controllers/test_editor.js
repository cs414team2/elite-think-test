const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
const TRUE_FALSE_QUESTION_TYPE      = 'TF';
const ESSAY_QUESTION_TYPE           = 'ESSAY';
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
			$(".question_list").sortable({
				update: function( event, ui ) {
					number_questions();
				}
			});
		}
	});
}

function add_question(question_type, question_text) {
	var question_weight = DEFAULT_QUESTION_WEIGHT;
	var answers         = [];
	var validated       = true;
		
	if (jQuery.trim(question_text).length <= 0) {
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
	else if (question_type == ESSAY_QUESTION_TYPE) {
		answers = [{answer_text : $("#txt_essay_answer").val(),
		            is_correct : "Y"}]
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
				$("#" + question_type).find("ul").append(question);
				$("#" + question_type).show();
				number_questions();
				clear_question_fields();
				// Commented out to avoid focus on adding question
				// $('html, body').animate({scrollTop: $("#" + question_type).height() }, 1);
			}
		});
	}

}

// Open a form to edit a question
function open_question_editor(question) {
	var question_id   = question.id;
	var question_type = question.getAttribute('data-question-type');
	var question_text = $(question).find('.question_text').html();
	var answers = [];
	
	$(question).find(".answer").each(function(index){
		answers[index] = { id : $(this).data("answer-id"),
		                   value : $(this).html() };
	});
	
	$("#dlg_" + question_type.toLowerCase()).data("question-id", question_id);
	$("#dlg_" + question_type.toLowerCase()).dialog('option', 'show', {
		effect: "size",
		duration: 500
	});
	switch(question_type){
		case TRUE_FALSE_QUESTION_TYPE:
			$("#btn_add_tf").unbind("click");
			$("#btn_add_tf").click(function() {
				edit_question($("#dlg_essay").data("question-id"), TRUE_FALSE_QUESTION_TYPE);
			});
			break;
		case MULTIPLE_CHOICE_QUESTION_TYPE:
			$("#btn_add_mc").unbind("click");
			$("#btn_add_mc").click(function() {
				edit_question($("#dlg_essay").data("question-id"), MULTIPLE_CHOICE_QUESTION_TYPE);
			});
			break;
		case ESSAY_QUESTION_TYPE:
			$("#txt_eq_entry").val(html_special_chars_decode(question_text));

			$("#txt_essay_answer").data("answer-id", answers[0].id);
			$("#txt_essay_answer").val(answers[0].value);
			
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
	var question_weight = DEFAULT_QUESTION_WEIGHT;
	var validated       = true;
	var answers = [];

	switch(question_type) {
		case ESSAY_QUESTION_TYPE:
			question_text = $("#txt_eq_entry").val();
			answers[0] = {answer_id : $("#txt_essay_answer").data("answer-id"),
						  answer_text : $("#txt_essay_answer").val(),
						  is_correct : "Y"}
			break;
		default:
			validated = false;
			break;
	}

	if (jQuery.trim(question_text).length <= 0) {
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
			data: {
				question_id: question_id,
				question_type: question_type,
				question_text: question_text,
				question_weight: question_weight,
				answers: answers
			},
			success : function(){
				$("#" + question_id).find(".question_text").html(html_special_chars(question_text));
				$("#" + question_id).find(".answer").each(function(index){
					$(this).html(answers[index].answer_text);
				});
				$("#dlg_" + question_type.toLowerCase()).dialog("close");
			}
		});
	}
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

function clear_error_messages() {
	$("#err_empty_tf").hide();
	$("#err_empty_mc").hide();
	$("#err_empty_eq").hide();
}

function clear_question_fields() {
			$("#txt_mcq_entry").val('');
			$(".mc_answer").each(function(){
				$(this).val('');
				$(this).attr("placeholder", "");
			});
			$("#txt_tfq_entry").val('');
			$("#rb_answer_true").prop('checked', true);
			$("#txt_eq_entry").val('');
			$("#txt_essay_answer").val('');

}

// Change the time limit for a test.
function update_time_info() {
	var date_due    = $("#datepicker").datepicker( "getDate" );
	var date_active = $("#activeDatepicker").datepicker( "getDate" );
	var time_limit  = $("#txt_time_limit").val();
	
	$.ajax({
		url : "ajax/update_test_time_info.php",
		data : {
			test_id : test_id,
		    date_due : date_due.getTime() / 1000,
			date_active : date_active.getTime() / 1000,
			time_limit : time_limit
		}
	});
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

//***********************Events************************
$(document).ready(function(){
	var default_dialog = {
		autoOpen: false,
		modal: true,
		width: 500,
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
	
	// Set the Dialog boxes and transition effects
	$( "#dlg_tf" ).dialog(default_dialog);
	$( "#dlg_mc" ).dialog(default_dialog);
	$( "#dlg_mc" ).dialog( "option", "width", 600 );
	$( "#dlg_essay" ).dialog(default_dialog);	
	
	$("#txt_time_limit").on('input', function () {
		if ($(this).val().length > 4) {
			$(this).val($(this).val().slice(0,4));
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
	$('.reset').click(clear_error_messages);
	
	// Open a dialog box if a user clicks the open button.
	$( "#btn_open_TFDialog" ).click(function() {
		$("#btn_add_tf").unbind("click");
		$("#btn_add_tf").click(function() {
			add_question(TRUE_FALSE_QUESTION_TYPE, $("#txt_tfq_entry").val());
		});
		$( "#dlg_tf" ).dialog( "open" );
	});	
	$( "#btn_open_MCDialog" ).click(function() {
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
	
});