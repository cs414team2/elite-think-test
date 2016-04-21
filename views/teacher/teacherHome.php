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
					<button class="show_hide" rel="#slidingDiv_1" id="view_teacher_classes_tab">View Classes</button>
					<button class="show_hide" rel="#slidingDiv_2" id="view_teacher_tests_tab">View Tests</button>
					<button class="show_hide" rel="#slidingDiv_3" id="view_create_test_tab">Create Test</button><br />
				</section>
				
				<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<br />	
					<table class="alt sortable">
					<caption style="font-weight: bold; text-decoration: underline;">Current Classes</caption>
					<caption><i>Select to View Enrolled Students</i></caption>
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
					<button class="show_hide_inner" rel="#slidingDiv_4" id="view_graded_tests_button">Graded</button>
					<button class="show_hide_inner" rel="#slidingDiv_5" id="view_ungraded_tests_button">Ungraded</button>
					<button class="show_hide_inner" rel="#slidingDiv_6" id="view_drafts_tests_button">Drafts</button>
					<br />
					
					<div id="slidingDiv_4" class="toggleInnerDiv" style="display:none; ">
						<section style="text-align:center;">
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Graded Tests</caption>
								<thead>
									<tr class="clickable_row">
										<th>Class</th>
										<th>Test</th>
										<th>Due Date</th>
										<th>Complete</th>
										<th>Stats</th>
									</tr>
								</thead>
								<tbody id="tbl_graded_tests">
									<tr>
										<td colspan="5">
											Loading Tests...
										</td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					
					<div id="slidingDiv_5" class="toggleInnerDiv" style="display:none; ">
						<section style="text-align:center;">
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Active Tests</caption>
							<caption><i>Select to Grade Submitted Tests</i></caption>
								<thead>
									<tr class="clickable_row">
										<th>Class</th>
										<th>Test</th>
										<th>Due Date</th>
										<th>Complete</th>
										<th>Stats</th>
									</tr>
								</thead>
								<tbody id="tbl_ungraded_tests">
									<tr>
										<td colspan="5">
											Loading Tests...
										</td>
									</tr>
								</tbody>
							</table>
						</section>
					</div>
					
					<div id="slidingDiv_6" class="toggleInnerDiv" style="display:none; ">
						<section style="text-align:center;">
							<!-- View Tests > - Existing Tests -->
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Inactive Tests</caption>
							<caption><i>Select to Edit Saved Drafts</i></caption>
								<thead>
									<tr class="clickable_row">
										<th>Class</th>
										<th>Test</th>
										<th>Active Date</th>
									</tr>
								</thead>
								<tbody id="tbl_inactive_tests">
									<tr>
										<td colspan="5">
											Loading Tests...
										</td>
									</tr>
								</tbody>
							</table>
							<hr>
						</section>
					</div>	
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
				<div id="area_stats">
					<div id="pie_letter_frequency" class="chart1" ></div>	
					<div id="bar_missed_questions" class="chart2"></div>
					<br />
					<div style="width: 100%;">
						<span class="statsLarge" id="h_highest" >
						</span>
						<span class="statsLarge" id="h_lowest" >
						</span>
						<span class="statsLarge" id="h_avg">
						</span>
					</div>
					<div style="width : 100%;">
						<span class="statsSmall">
							Highest
						</span>
						<span class="statsSmall">
							Lowest
						</span>
						<span class="statsSmall">
							Average
						</span>
						<br />
					</div>
				</div>
				<div id="area_stats_loader" class="loader" style="display: none;">Loading...</div>
			</div>
			<div id="dlg_missed_questions" class="dialog_box" title="Missed Questions" style="text-align: center; background-image: url(images/texture.png);">	
				<div id="area_missed">
					<div id="bar_missed_questions2" class="chart3"></div>
				</div>
				<div id="area_missed_loader" class="loader" style="display: none;">Loading...</div>
			</div>

			<!-- Class Statistics div -->
			<div id="dlg_class_stats" class="dialog_box" title="Students" style="background-image: url(images/texture.png);">
				<table id="table_enrolled_students" class="alt sortable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Grade</th>
					</tr>
				</thead>
				<tbody id="tbl_enrolled_students" style="background-color:white;">
				</tbody>
				</table>
				<div id="area_class_loader" class="loader" style="display: none;">Loading...</div>
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