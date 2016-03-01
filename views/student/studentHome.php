<?php
require_once('model/Student.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		$student = new Student();
		echo '
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Student Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section style="text-align:center">
						<a class="show_hide" rel="#slidingDiv_1" >View Classes</a>
						<a class="show_hide" rel="#slidingDiv_2" >Take a Test</a><br />
					</section>
					
					
					<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<section id="viewClassesStudent">
					<div class="container1">

										<table class="alt">
											<thead>
												<tr>
													<th>Course ID</th>
													<th>Course Name</th>
												</tr>
											</thead>
											<tbody>';
												$student->print_classes($_SESSION['credentials']->get_user_id());
									  echo '</tbody>
										</table>								
					</div>
					
					</section>
					</div>
					
					<div id="slidingDiv_2" class="toggleDiv" style="display:none"> 	
					
					<section id="viewGradeStudent">
					<div class="container1">

										<table class="alt">
											<thead>
												<tr>
													<th>Test #</th>
													<th>Class #</th>
													<th>Class Name</th>
													<th>Date Due</th>
													<th>Time Limit</th>
												</tr>
											</thead>
											<tbody>';
												$student->print_tests($_SESSION['credentials']->get_user_id());
									echo   '</tbody>
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