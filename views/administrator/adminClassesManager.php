<?php
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
			
			<script src="controllers/new_class_form.js"></script>
			<script src="controllers/toggle_active.js"></script>
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Class Manager</h2>
				</header>
				<div class="container">
					<!-- Content -->
					<section id="content" >
						<h4 style="display:inline-block;">&#9699;&nbspSelect a Class to Add Students</h4>
						<button id="btn_open_courseDialog" class="show_hide" style="display:inline-block; float: right;">Add a Course</button>
						<br /><br />
						<input type="checkbox" id="copy" name="copy">
						<label for="copy">Show Inactive Classes</label>
						<div class="table-wrapper">
							<table class="sortable">
								<thead>
									<tr>
										<th>Course Id</th>
										<th>Course Number</th>
										<th>Course Name</th>
										<th>Teacher</th>
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
		
				<div id="dlg_course" class="dialog_box" title="Add a Course" style="background-color:white; text-align: center;">
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