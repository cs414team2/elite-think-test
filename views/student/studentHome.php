<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		echo '
		<script src="controllers/student_console.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script>var user_id = ' . $_SESSION['credentials']->get_user_id() . ';
		</script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Student Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
				<section>
					<button class="show_hide" rel="#slidingDiv_1" id="view_classes_tab" >View Classes</button>
					<button class="show_hide" rel="#slidingDiv_2" id="take_test_tab">Take a Test</button>
					<button class="show_hide" rel="#slidingDiv_3" id="view_tests_tab">View Tests</button>
					<br />
				</section>
				
				<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<section id="viewClassesStudent">
						<div class="container1">
							<br />
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Enrolled Classes</caption>
								<thead>
									<tr class="clickable_row">
										<th>Course ID</th>
										<th>Course Name</th>
										<th>Course Average</th>
									</tr>
								</thead>
								<tbody id="tbl_classes">
									<tr>
										<td colspan="2" style="text-align: center">
											Loading Classes...
										</td>
									</tr>
								</tbody>
							</table>								
						</div>
				
					</section>
				</div>
				
				<div id="slidingDiv_2" class="toggleDiv" style="display:none"> 	
					<section id="viewGradeStudent">
						<div class="container1">
							<br />
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Need To Complete</caption>
							<caption><i>Click a Test When You Are Ready</i></caption>
								<thead>
									<tr class="clickable_row">
										<th>Class #</th>
										<th>Class Name</th>
										<th>Test #</th>
										<th>Date Due</th>
										<th>Time Limit</th>
										<th>Test Status</th>
										<th># of Questions</th>
									</tr>
								</thead>
								<tbody id="tbl_tests">
									<tr>
										<td colspan="5" style="text-align: center">
											Loading Tests...
										</td>
									</tr>
								</tbody>
							</table>										

						</div>
					</section>
				</div>		
				<div id="slidingDiv_3" class="toggleDiv" style="display:none; text-align: center;"> 	
					<section id="viewTestStudent">
					<br />
					<button class="show_hide_inner" rel="#slidingDiv_4" id="view_graded_tests_tab">Graded</button>
					<button class="show_hide_inner" rel="#slidingDiv_5" id="view_ungraded_tests_tab">Ungraded</button>
					<br />
						<div id="slidingDiv_5" class="toggleInnerDiv" style="display:none; ">
							<section style="text-align:center;">
								<table class="alt sortable">
								<caption style="font-weight: bold; text-decoration: underline;">Ungraded Tests</caption>
								<caption><i>Tests pending Teacher response</i></caption>
									<thead>
										<tr class="clickable_row">
											<th>Class #</th>
											<th>Class</th>
											<th>Test</th>
										</tr>
									</thead>
									<tbody id="tbl_ungraded_tests">
										<tr>
											<td>
												Loading Tests...
											</td>
										</tr>
									</tbody>
								</table>
							</section>
						</div>
						<div id="slidingDiv_4" class="toggleInnerDiv" style="display:none;">
							<section style="text-align:center;">
								<table class="alt sortable">
								<caption style="font-weight: bold; text-decoration: underline;">Graded Tests</caption>
								<caption><i>Click a Test to view the missed questions</i></caption>
									<thead>
										<tr class="clickable_row">
											<th>Class #</th>
											<th>Class</th>
											<th>Test</th>
											<th>Grade</th>  
										</tr>
									</thead>
									<tbody id="tbl_graded_tests">
										<tr>
											<td colspan="4">
												Loading Tests...
											</td>
										</tr>
									</tbody>
								</table>
							</section>
						</div>
					</section>
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