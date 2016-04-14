//*********************************************************************
//*                           Objects                                 *
//*********************************************************************
var color_iterator = { color : ["#3366cc", "green", "#e52d0b", "orange", "purple"],
							  next_color : 0,
                       next : function() { if (this.next_color >= this.color.length) { this.next_color = 0;} 
							                      return this.color[this.next_color++];
							                    }
                     }

//*********************************************************************
//		             				 Functions		             				 *
//*********************************************************************
// open the test edit page for a specific test
function open_edit_page(test_id) {
	window.location = "./?action=teacher_edit_test&test_id=" + test_id;
}

// Load all test and class lists
function load_tests_and_classes() {
	$("#tbl_classes").load("ajax/get_classes_for_teacher.php?user_id=" + user_id, function(){
		$(".editable_class").click(function(){
			$( "#dlg_class_stats" ).dialog( "open" );
		});
	});
	$("#tbl_active_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + true, function(){	
		$('.gradeable_test').click(function(event){
			event.preventDefault();
			window.location = "./?action=teacher_grade_test&test_id=" + $(this).parent().attr('id');
		});
		
		$( ".btn_open_stats_dialog" ).click(function() {
			var test_id = $(this).parent().parent().attr('id');
			google.charts.setOnLoadCallback(function() { load_test_statistics(test_id);});
		});
	});
	$("#tbl_inactive_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + false, function(){
		$('.editable_test').click(function(){
			open_edit_page($(this).parent().attr('id'));
		});
	});
	$.get("ajax/get_classes_ddl_for_teacher.php?user_id=" + user_id, function(list){
		$("#ddl_classes").append(list);
	});
}

// Add a new test
function create_test() {
	if ($("#ddl_classes").val() != "null") {
		$.ajax ({
			url: "ajax/add_test.php?class_id=" + $("#ddl_classes").val(),
			success: function(test_id){
				open_edit_page(test_id);
			}
		});
	}
}

// Print a pie chart with grade frequency, a bar graph with missed question frequency, and grade statistics.
function load_test_statistics(test_id) {
	var bar_chart = new google.visualization.ColumnChart(document.getElementById("bar_missed_questions"));
	var bar_data;
	var bar_options = {
		title: "Top Missed Questions",
		width: 600,
		height: 400,
		backgroundColor: "transparent",
		bar: {groupWidth: "95%"},
		legend: { position: "none" },
	};
	var bar_view;
	var grade_data;
	var grade_stats = [["Letter", "Number of students who achieved"]];
	var pie_chart = new google.visualization.PieChart(document.getElementById("pie_letter_frequency"));
	var pie_options = {
	  title: "Letter Grade Averages",
	  width: 500,
	  height: 400,
	  backgroundColor: "transparent",
	  pieSliceTextStyle: {color: "black"},
	};
	var question_stats = [["Question", "Missed", { role: "style" } ]];
	
	$.ajax({
		url: 'ajax/get_test_statistics.php',
		data : { test_id : test_id},
		success : function(data) {
			var statistics = document.createElement('div');
			statistics.innerHTML = data;
			
			$(statistics).find('.grade_count').each(function(index){
				grade_stats.push([$(this).attr('id') + "\'s" , parseInt($(this).text(), 10)]);
			});
			grade_data = new google.visualization.arrayToDataTable(grade_stats);
			pie_chart.draw(grade_data, pie_options);
		
			$(statistics).find('.missed_question_count').each(function(index){
				question_stats.push(["#" + $(this).attr('id'), parseInt($(this).text(), 10), color_iterator.next()]);
			});
			if ($(statistics).find('.missed_question_count').length == 0)
				question_stats.push(['', 0, color_iterator.next()]);
			bar_data = google.visualization.arrayToDataTable(question_stats);
			bar_view = new google.visualization.DataView(bar_data);
			bar_view.setColumns([0, 1,
				{ calc: "stringify",
					sourceColumn: 1,
					type: "string",
					role: "annotation" },
				2]);
			bar_chart.draw(bar_view, bar_options);
			
			$('#h_highest').html($(statistics).find('#highest_grade').html());
			$('#h_lowest').html($(statistics).find('#lowest_grade').html());
			$('#h_avg').html($(statistics).find('#average_grade').html());
			
			$( "#dlg_test_stats" ).dialog( "open" );
		}
	});	  
}

//******************************************************************
//		             				 Events		             				 *
//******************************************************************
$(document).ready(function() {
	google.charts.load("current", {"packages":["corechart"]});
	load_tests_and_classes();
	
	$("#btn_create_test").click(function(){
		create_test();
	})
	
	// Open a dialog box if a user clicks the open button.
	$( "#dlg_test_stats" ).dialog({
      autoOpen: false,
	  modal: true,
	  width: 1250,
	  height: 600,
      show: {
        effect: "highlight",
		duration: 500
      },
      hide: {
        effect: "puff",
		duration: 500
      }
    });
	
	// Open a dialog box if a user clicks the open button.
	$( "#dlg_class_stats" ).dialog({
      autoOpen: false,
	  modal: true,
	  width: 1250,
	  height: 600,
      show: {
        effect: "highlight",
		duration: 500
      },
      hide: {
        effect: "puff",
		duration: 500
      }
    });
 
});