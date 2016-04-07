<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		echo '
		<script src="controllers/student_console.js"></script>
		<script>var user_id = ' . $_SESSION['credentials']->get_user_id() . ';
		</script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Student Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
				<section style="text-align:center">
					<a class="show_hide" rel="#slidingDiv_1" >View Classes</a>
					<a class="show_hide" rel="#slidingDiv_2" >Take a Test</a>
					<a class="show_hide" rel="#slidingDiv_3" >View Tests</a><br />
				</section>
				
				<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<section id="viewClassesStudent">
						<div class="container1">
							<br />
							<table class="alt sortable">
							<caption style="font-weight: bold; text-decoration: underline;">Enrolled Classes</caption>
							<caption><i>Select a Class to View All Tests</i></caption>
								<thead>
									<tr>
										<th>Course ID</th>
										<th>Course Name</th>
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
							<caption><i>Select a Test When You Are Ready</i></caption>
								<thead>
									<tr>
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
						<div class="container1">
							<br />
							<table class="alt sortable" style="display: inline; max-width: 50%; ">
								<caption style="font-weight: bold; text-decoration: underline;">Ungraded Tests</caption>
									<thead>
										<tr>
											<th>Test</th>
											<th>Class</th>
										</tr>
									</thead>
									<tbody id="tbl_tests">
										<tr>
											<td>
												Loading Tests...
											</td>
										</tr>
									</tbody>
								</table>
								
								<!-- View Tests > Right - Existing Tests -->
								<table class="alt sortable" style="display: inline; margin-left: 5%; max-width: 50%;">
								<caption style="font-weight: bold; text-decoration: underline;">Graded Tests</caption>
									<thead>
										<tr>
											<th>Test</th>
											<th>Class #</th>
											<th>Class</th>
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