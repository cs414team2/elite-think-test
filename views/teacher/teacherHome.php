<?php
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		echo '
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script>
			var user_id = '. $_SESSION['credentials']->get_user_id() .
		';</script>
		<script src="controllers/teacher_console.js"></script>

		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
				<section style="text-align:center">
					<a class="show_hide" rel="#slidingDiv_1" >View Classes</a>
					<a class="show_hide" rel="#slidingDiv_2" >View Tests</a>
					<a class="show_hide" rel="#slidingDiv_3" >Create Test</a><br />
				</section>
				
				<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<section id="viewClasses">
						<div class="container1">
							<br />	
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Current Classes</caption>	
							<caption><i>Select to View Class Information and Averages</i></caption>
								<thead>
									<tr>
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
					</section>
				</div>
				
				<div id="slidingDiv_2" class="toggleDiv" style="display:none; text-align: center;"> 	
					<section id="viewTest">
						<div class="container">
							<!-- View Tests > Left - New Tests -->
							<br />
							<table class="alt sortable" style="display: inline; max-width: 50%; ">
							<caption style="font-weight: bold; text-decoration: underline;">Active Tests</caption>
							<caption><i>Select to Grade Submitted Tests</i></caption>
								<thead>
									<tr>
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
							
							<a id="btn_open_stats_dialog" style="height: 2em; line-height: 0em; cursor: help;">Stats</a>
							
							<!-- View Tests > Right - Existing Tests -->
							<table class="alt sortable" style="display: inline; margin-left: 5%; max-width: 50%;">
							<caption style="font-weight: bold; text-decoration: underline;">Inactive Tests</caption>
							<caption><i>Select to Edit Saved Drafts</i></caption>
								<thead>
									<tr>
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
					</section>
				</div>
				
				<div id="slidingDiv_3" class="toggleDiv" style="display:none;">
					<br />
					<h4 style="text-align: center;">Please Select the Class...</h4>
					<select name="Class" id="ddl_classes" style="text-align: center;">
						<option selected="selected" value="null">- Classes -</option>
					</select>
					<br />
					<section style="text-align: center;">
						<button id="btn_create_test" class="button big">Create this test</button>
					</section>
				</div>	
			</div>
			
			<!-- Test Statistics div -->
			<div id="dlg_test_stats" title="Test Statistics" style="text-align: center;">	
				<h2>Hey smexy</h2>			
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