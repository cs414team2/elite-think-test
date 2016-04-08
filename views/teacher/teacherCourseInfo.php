<?php
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'], $_REQUEST["class_id"])) {
	if ($_SESSION['credentials']->is_teacher()) {
		echo '
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script>
			var user_id = '. $_SESSION['credentials']->get_user_id() .
		';</script>
		<script src="controllers/teacher_console.js"></script>
		 <script type="text/javascript">
			  google.charts.load("current", {"packages":["corechart"]});
			  google.charts.setOnLoadCallback(drawChart);
			  function drawChart() {

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

				var chart = new google.visualization.PieChart(document.getElementById("piechart"));

				chart.draw(data, options);
			  }
		</script>
		<script type="text/javascript">
			google.charts.setOnLoadCallback(drawChart1);
			function drawChart1() {
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
		</script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Course Overview </h2>
			</header>
			<div class="container" style="text-align:center">
					
				<!-- Content -->
			
				<div id="piechart" class="chart1" ></div>	
				<div id="columnchart_values" class="chart2"></div>
				<div><h2 style="color: black; text-shadow: 0em 0em 0em black;">Highest grade:   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Lowest grade: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Average grade:</h2></div>
				<div  style="color: black; text-shadow: 0em 0em 0em black;">
					 <h2 style="color: black; text-shadow: 0em 0em 0em black;">Number of A\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of B\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of C\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of D\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of F\'s: &nbsp&nbsp&nbsp&nbsp</h2>
				</div>
			</div>
		</section>';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>