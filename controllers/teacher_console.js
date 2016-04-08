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
			window.location = "./?action=teacher_course_info&class_id=" + $(this).attr('id');
		});
	});
	$("#tbl_active_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + true, function(){	
		$('.gradeable_test').click(function(event){
			event.preventDefault();
			window.location = "./?action=teacher_grade_test&test_id=" + $(this).parent().attr('id');
		});
		
		$( ".btn_open_stats_dialog" ).click(function() {
			var test_id = $(this).parent().parent().attr('id');
			draw_grade_pie(test_id);
			draw_question_graph(test_id);
			$( "#dlg_test_stats" ).dialog( "open" );
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

// Draw a pie chart with the number of students who received each grade.
function draw_grade_pie(test_id) {
	var grade_stats = [["Letter", "Number of students who achieved"]];
	var pie_chart = new google.visualization.PieChart(document.getElementById("piechart"));
	var grade_data;
	var options = {
	  title: "Letter Grade Averages",
	  width: 500,
	  height: 400,
	  backgroundColor: "transparent",
	  pieSliceTextStyle: {color: "black"},
	};
	
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
			pie_chart.draw(grade_data, options);
		}
	});	  
}

// Draw a bar graph with the number of questions missed the most times.
function draw_question_graph(test_id) {
  var data = google.visualization.arrayToDataTable([
	["Element", "Missed", { role: "style" } ],
	["#1",  8, "red"],
	["#2", 19, "yellow"],
	["#3", 21, "green"],
	["#4", 21, "blue"],
	["#5", 21, "purple"]
  ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
					{ calc: "stringify",
					 sourceColumn: 1,
					 type: "string",
					 role: "annotation" },
					2]);

  var options = {
	title: "Top Missed Questions",
	width: 600,
	height: 400,
	 backgroundColor: "transparent",
	bar: {groupWidth: "95%"},
	legend: { position: "none" },
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
  chart.draw(view, options);
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
 
});