<?php
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {

		echo '
		<link rel="stylesheet" href="css/jquery-ui-1.11.4.custom/jquery-ui.css">
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="controllers/teacher_console.js"></script>
		<script>
			var user_id = '. $_SESSION['credentials']->get_user_id() .
		';</script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
				<section style="text-align:center">
					<a class="show_hide" rel="#slidingDiv_1" id="view_teacher_classes_tab">View Classes</a>
					<a class="show_hide" rel="#slidingDiv_2" id="view_teacher_tests_tab">View Tests</a>
					<a class="show_hide" rel="#slidingDiv_3" id="view_create_test_tab">Create Test</a><br />
				</section>
				
				<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<br />	
					<table class="alt sortable">
					<caption style="font-weight: bold; text-decoration: underline;">Current Classes</caption>
					<caption><i>Select to View Class Information and Averages</i></caption>
						<thead>
							<tr class="clickable_row">
								<th>Course #</th>
								<th>Course Name</th>
								<th># of Students</th>
								<th>Course Average</th>
							</tr>
						</thead>
						<tbody id="tbl_classes">
							<tr>
								<td>
									Loading Classes...
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
				</div>
				
				<div id="slidingDiv_2" class="toggleDiv" style="display:none; text-align: center;">
					<br />
					<table class="alt sortable" style="display: inline; max-width: 50%; ">
					<caption style="font-weight: bold; text-decoration: underline;">Active Tests</caption>
					<caption><i>Select to Grade Submitted Tests</i></caption>
						<thead>
							<tr class="clickable_row">
								<th>Test</th>
								<th>Class</th>
								<th>Due Date</th>
								<th>Complete</th>
								<th>Stats</th>
							</tr>
						</thead>
						<tbody id="tbl_active_tests">
							<tr>
								<td>
									Loading Tests...
								</td>
							</tr>
						</tbody>
					</table>
					
					<!-- View Tests > Right - Existing Tests -->
					<table class="alt sortable" style="display: inline; margin-left: 5%; max-width: 50%;">
					<caption style="font-weight: bold; text-decoration: underline;">Inactive Tests</caption>
					<caption><i>Select to Edit Saved Drafts</i></caption>
						<thead>
							<tr class="clickable_row">
								<th>Test</th>
								<th>Class</th>
								<th>Active Date</th>
							</tr>
						</thead>
						<tbody id="tbl_inactive_tests">
							<tr>
								<td>
									Loading Tests...
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
				</div>
				
				<div id="slidingDiv_3" class="toggleDiv" style="display:none;">
					<br />
					<h4 style="text-align: center;">Please Select the Class...</h4>
					<select name="Class" id="ddl_classes" style="text-align: center;">
						<option selected="selected" value="null">- Classes -</option>
					</select>
					<br />
					<section style="text-align: center;">
						<button id="btn_create_test" class="button special big">Create this test</button>
					</section>
				</div>	
			</div>
			
			<!-- Test Statistics div -->
			<div id="dlg_test_stats" class="dialog_box" title="Test Statistics" style="text-align: center; background-image: url(images/texture.png);">	
				<div id="pie_letter_frequency" class="chart1" ></div>	
				<div id="bar_missed_questions" class="chart2"></div>
				<br /><br />
				<div><h2 style="color: black; text-shadow: 0em 0em 0em black;">Highest grade:   <span id="h_highest" ></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Lowest grade: <span id="h_lowest" ></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Average grade: <span id="h_avg"></span></h2></div>
			</div>
			
			<!-- Class Statistics div -->
			<div id="dlg_class_stats" class="dialog_box" title="Class Statistics" style="text-align: center; background-image: url(images/texture.png);">	
				<div id="pie_letter_frequency" class="chart1" ></div>	
				<div id="bar_missed_questions" class="chart2"></div>
				<br /><br />
				<div><h2 style="color: black; text-shadow: 0em 0em 0em black;">Highest grade:   <span id="h_highest" ></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Lowest grade: <span id="h_lowest" ></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Average grade: <span id="h_avg"></span></h2></div>
				 
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