//****************************************************************
//*               Constants and Global Variables :(              *
//****************************************************************


//****************************************************************
//*                        Functions                             *
//****************************************************************
			  
function load_class_statistics() {

	var data = google.visualization.arrayToDataTable([
	  ["Task", "Hours per Day"],
	  ["A\'s",     11],
	  ["B\'s",      2],
	  ["C\'s",      2],
	  ["D\'s",      2],
	  ["F\'s",      7]
	]);

	var options = {
	  title: "Letter Grade Averages",
	  width: 500,
	  height: 400,
	  backgroundColor: "transparent",
	  pieSliceTextStyle: {color: "black"},
	};

	var chart = new google.visualization.PieChart(document.getElementById("pie_letter_frequency"));

	chart.draw(data, options);
  }
			  
function load_something() {
  var data = google.visualization.arrayToDataTable([
	["Element", "Missed", { role: "style" } ],
	["#1",  8, "red"],
	["#2", 19, "yellow"],
	["#3", 21, "green"],
	["#4", 21, "blue"],
	["#5", 21, "purple"],
	["#7",  8, "red"],
	["#2", 19, "yellow"],
	["#8", 21, "green"],
	["#4", 21, "blue"],
	["#5", 21, "purple"],
	["#1",  8, "red"],
	["#2", 19, "yellow"],
	["#9", 21, "green"],
	["#4", 21, "blue"],
	["#5", 21, "purple"],
	["#1",  8, "red"],
	["#0", 19, "yellow"],
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
  var chart = new google.visualization.ColumnChart(document.getElementById("bar_something"));
  chart.draw(view, options);
}

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	
	// Load google charts.
	google.charts.load("current", {"packages":["corechart"]});
	google.charts.setOnLoadCallback(load_class_statistics);
	google.charts.setOnLoadCallback(load_something);
	
});