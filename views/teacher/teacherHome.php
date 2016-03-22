<?php
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		echo '
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
										<thead>
											<tr>
												<th>Class #</th>
												<th>Class Name</th>
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
					
					<div id="slidingDiv_2" class="toggleDiv" style="display:none; "> 	
						<section id="viewTest">
						<div class="container">
							<!-- View Tests > Left - New Tests -->
							<br />
							<table class="alt sortable" style="display: inline; max-width: 50%; ">
							<caption style="font-weight: bold; text-decoration: underline;">Active Tests</caption>
								<thead>
									<tr>
										<th>Test</th>
										<th>Class</th>
										<th>Due Date</th>
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