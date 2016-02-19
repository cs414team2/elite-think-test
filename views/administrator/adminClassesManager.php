<?php
require_once('model/Table.php');
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<script src="controllers/load_classes.js"></script>
			<script src-"controllers/new_class_form.js"></script>
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Class Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content" >
						<h3>This is a list of Classes</h3>
						<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Course Id</th>
												<th>Course Number</th>
												<th>Course Name</th>
												<th>Teacher Id</th>
											</tr>
										</thead>
										<tbody>';
											$student_table = new Table();
											$student_table->get_table("class");
									echo '</tbody>
									</table>
								</div>
					</section>
					</div>
				<div class="container">
					<section id="content" style="text-align:center">
						<h3 align="center">Add a Course</h3>
						<a id="addButton" class="show_hide" rel="#slidingDiv_2">Add a Course</a><br />
						<div id="slidingDiv_2" style="display:none">
							<form>
								<br />
								<h4>Course name:</h4>
								<input type="text" id="courseName" name="courseName" class="inputField">
								<p id="add_course_name_err" style="display:none; color: red;">
									Course name cannot be blank.
								</p>
								<br />
								<h4>Course Number:</h4>
								<input type="text" id="courseNumber" name="courseNumber" class="inputField">
								<p id="add_course_number_err" style="display:none; color: red;">
									Course number cannot be blank.
								</p>
								<br />
							  
								<div class="row uniform">
									<div class="12u">
										<div class="select-wrapper">
											<select name="Teacher" id="Teacher">
												<option selected="selected" value="null">- Select a Teacher -</option>';
												$admin = new Admin();
												$admin->get_teachers();
									  echo '</select>
										</div>
									</div>
								</div>

							  
							  <br />
							  <button type="button" id="btn_add" class="button special big">Add Course</button>
							
							</form>
						</div>
					</section>
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>