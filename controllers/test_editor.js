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
				clear_question_fields(question_type);
				// Commented out to avoid focus on adding question
				// $('html, body').animate({scrollTop: $("#" + question_type).height() }, 1);
			}
		});
	}

}

// Open a form to edit a question                                          ********* will setup a dialog thingy here***********
function open_question_editor(question) {
	var question_id   = question.id;
	var question_type = question.getAttribute('data-question-type');
	var question_text = $(question).find('.question_text').html();
	var answers = [];
	
	switch(question_type){
		case ESSAY_QUESTION_TYPE:
			/*alert($("#dlg_essay").data("question_id"));
			$("#dlg_essay").data("question_id", question_id);
			$("#txt_eq_entry").html(question_text);
			
			$("#dlg_essay").dialog("open");
			$("#btn_add_essay").unbind("click");
			$("#btn_add_essay").click(function() {
				
				
				
				edit_question(question_id, question_type, question_text);
			});*/;			break;
	}

}

function edit_question(question_id, question_type) {
	var question_text   = $("#txt_edit_question").val();
	var question_weight = DEFAULT_QUESTION_WEIGHT;
	var validated       = true;
	
	/*if (jQuery.trim(question_text).length <= 0) {
		$("#err_empty_question").show();
		validated = false;
	}/*
	
	/*$.ajax({
		url: 'ajax/edit_question.php',
		data: {
			question_id: question_id,
			question_type: question_type,
			question_text: question_text,
			question_weight: question_weight
			answers: answers
		}
	});*/
	alert("edit question");
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
			add_question(MULTIPLE_CHOICE_QUESTION_TYPE, $("#txt_mc_entry").val());
		});
		$( "#dlg_mc" ).dialog( "open" );
	});
	$( "#btn_open_EssayDialog" ).click(function() {
		$("#btn_add_essay").unbind("click");
		$("#btn_add_essay").click(function() {
			add_question(ESSAY_QUESTION_TYPE, $("#txt_eq_entry").val());
		});
		$( "#dlg_essay" ).dialog( "open" );
	});
	
});