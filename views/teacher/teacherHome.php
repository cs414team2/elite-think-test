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
						<a class="show_hide" rel="#slidingDiv_1" >View Classes</a>
						<a class="show_hide" rel="#slidingDiv_2" >View Tests</a>
						<a class="show_hide" rel="#slidingDiv_3" >Create Test</a><br />
					</section>
					
					
					<div id="slidingDiv_2" class="toggleDiv" style="display:none"> 	
						<section id="viewTest">
						<div class="container">
							<!-- View Tests > Left - New Tests -->
							<br />
							<table class="alt" style="display: inline-block; max-width: 50%; float: left; ">
							<caption style="font-weight: bold; text-decoration: underline;">Active Tests</caption>
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
							
							<!-- View Tests > Right - Existing Tests -->
							<table class="alt" style="display: inline-block; max-width: 50%;">
							<caption style="font-weight: bold; text-decoration: underline;">Inactive Tests</caption>
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
							</table>
							<hr>			
						</div>
						</section>
					</div>
					
					
					<div id="slidingDiv_1" class="toggleDiv" style="display:none"> 
						<section id="viewClasses">
						<div class="container1">
							<br />	
							<table class="alt">
							<caption style="font-weight: bold; text-decoration: underline;">Current Classes</caption>
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
							<hr>				
						
						</div>
						</section>
					</div>
					
					<div id="slidingDiv_3" class="toggleDiv" style="display:none">
						<br />
						<h4 style="text-align: center;">Select who this test is for...</h4>
						<select name="Class" id="Class">
							<option selected="selected" value="null">- Select a Class -</option>';
							$teacher = new Teacher();
							$teacher->get_classes_dropdown($_SESSION['credentials']->get_user_id());
						echo '</select>
						<br />
						<a class="button big" 	href="./?action=teacher_create_test">Create this test</a>\
						<hr>
					</div>
					
					
					
					
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>