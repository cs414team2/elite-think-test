//****************************************************************
//*               Constants and Global Variables :(              *
//****************************************************************
const MAX_TEST_SIZE = 3;

//****************************************************************
//*                        Functions                             *
//****************************************************************

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

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	number_questions();
});