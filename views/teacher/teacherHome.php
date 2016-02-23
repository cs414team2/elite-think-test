<?php
include('model/Tests.php');
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		
		echo '
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section style="text-align:center">
						<a class="button big" href="./?action=teacher_create_test">Create a test</a>
						<a class="show_hide" rel="#slidingDiv_1" >View Classes</a>
						<a class="show_hide" rel="#slidingDiv_2" >View Tests</a><br />
					</section>
					
					
					<div id="slidingDiv_2" class="toggleDiv" style="display:none"> 	
					
					<section id="viewTest">
					<div class="container">
								<table class="alt" style="display: inline-block; max-width: 50%; float: left; ">
											<thead>
												<tr>
													<th>Test</th>
													<th>Class</th>
													<th>Due Date</th>
												</tr>
											</thead>
											<tbody>';
												$teacher_tests = new Tests("teacher");
												$teacher_tests->print_tests($_SESSION['credentials']->get_user_id(), true);
												
								     echo  '</tbody>
										</table>
										<table class="alt" style="display: inline-block; max-width: 50%;">
											<thead>
												<tr>
													<th>Name</th>
													<th>Description</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>';
												$teacher_tests = new Tests("teacher");
												$teacher_tests->print_tests($_SESSION['credentials']->get_user_id(), false);
									   echo'</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>100.00</td>
												</tr>
											</tfoot>
										</table>
										
					
					</div>
					
					</section>
					</div>
					
					
					<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
					<section id="viewClasses">
					<div class="container1">
								<table class="alt">
											<thead>
												<tr>
													<th>Class #</th>
													<th>Class Name</th>
												</tr>
											</thead>
											<tbody>';
												$teacher = new Teacher();
												$teacher->get_classes($_SESSION['credentials']->get_user_id());
									   echo'</tbody>
										</table>
										
					
					</div>
					
					</section>
					</div>
					
					
					
					
					
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>