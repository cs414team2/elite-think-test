<?php
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<script src="controllers/new_class_form.js"></script>
			<script src="controllers/toggle_active.js"></script>
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Class Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content" >
						<h4>This is a list of all Classes</h4>
						<input type="checkbox" id="copy" name="copy">
						<label for="copy">Show Inactive Classes</label>
						<div class="table-wrapper">
							<table class="sortable">
								<thead>
									<tr>
										<th>Course Id</th>
										<th>Course Number</th>
										<th>Course Name</th>
										<th>Teacher Id</th>
									</tr>
								</thead>
								<tbody id="tbl_classes">
									<tr>
										<td colspan="4" style="text-align: center;">
											<div class="loader">Loading...</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					</div>
				<div class="container">
					<section id="content" style="text-align:center">
						<a id="addButton" class="show_hide" rel="#slidingDiv_2">Add a Course</a><br />
						<div id="slidingDiv_2" style="display:none">
							<form>
								<b>Course name:</b>
								<input type="text" id="courseName" name="courseName" class="inputField" maxlength="45" placeholder=".NET Programming">
								<p id="add_course_name_err" style="display:none; color: red;">
									Course name cannot be blank.
								</p>
								<br />
								<b>Course Number:</b>
								<input type="text" id="courseNumber" name="courseNumber" class="inputField" maxlength="9" placeholder="CS 364">
								<p id="add_course_number_err" style="display:none; color: red;">
									Course number cannot be blank.
								</p>
								<br />
							  
								<div class="row uniform">
									<div class="12u">
										<div class="select-wrapper">
											<select name="ddl_teachers" id="ddl_teachers">
												<option selected="selected" value="null">- Select a Teacher -</option>';
												$admin = new Admin();
												$admin->get_teachers();
									  echo '</select>
										</div>
									</div>
								</div>
								<br />
								<button type="button" id="btn_add" class="button special big">Submit</button>
								<br />
							</form>
						</div>
					</section>
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