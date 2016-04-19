<?php
require_once('model/Admin.php');
require_once('model/Student.php');
if (isset($_SESSION['credentials'], $_REQUEST['id'])) {
	if ($_SESSION['credentials']->is_admin()) {
		$student = new student();
		echo'
			<link rel="stylesheet" href="css/jquery-ui-1.11.4.custom/jquery-ui.css">
			<script src="controllers/edit_student_form.js"></script>
			
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="h_student_info">'; $student->get_student_info($_REQUEST["id"]); echo '</h2>
				</header>
				
				<div class="container" >
					<!-- Content -->
					<section>
						<section style="display: inline-block;">
							<select name="student" id="ddl_switch_student" style="display: inline-block;">';
								$admin = new Admin();
								$admin->get_students_ddl($_REQUEST["id"]);

					  echo '</select></section>
						<img src="images/edit_user.png" class="clickable_img clickable_img_square" title="Edit This Student" id="btn_open_edit_studnet_dialog"  style="display:inline-block; float: right;">
						<hr />
						<div id="area_student_info">
						<table class="alt" id="content">
						<caption style="font-weight: bold; text-decoration: underline;">Student Information</caption>
							<thead>
								<tr>
									<th>ID</th>
									<th>First</th>
									<th>Last</th>
									<th>Email</th>
									<th>Password</th>
								</tr>
							</thead>
							 <tbody id="tbl_student_info">';
								$student->get_full_student_info($_REQUEST["id"]);
					  echo '</tbody>
						</table>
						</div>
						<div id="area_loader" class="loader" style="display: none;">Loading...</div>
						<hr />
						<div id="area_enroll_class">
							<table id="table_classes" class="alt" id="content" style="display: inline; max-width: 50%;">
								<caption style="font-weight: bold; text-decoration: underline;">Enrolled Classes</caption>
								<thead>
									<tr>
										<th>Course #</th>
										<th>Course Name</th>
									</tr>
								</thead>
								<tbody id="tbl_classes">';
									$student->print_classes($_REQUEST["id"]);
						  echo '</tbody>
							</table>
							
							<section style="display: inline; max-width: 50%; float:right">
								<select name="class" id="ddl_select_class">';
									$student->print_classes_dropdown($_REQUEST["id"]);
						  echo	'</select>
								<br />
								<button id="btn_enroll" class="big button special" style="height: 2em; line-height: 0em; float:right">Enroll Student</button>
							</section>
						</div>
						<div id="area_enroll_loader" class="loader" style="display: none;">Loading...</div>
						<br />
					</section>
				</div>	
			</section>	

			<div id="dlg_edit_student_info" class="dialog_box" title="Edit Student Information" style="background-color:white; text-align: center;">	
				<form>
				  <b>First name: </b>
				  <input type="text" id="first_name" "name="first_name" class="input_field" maxlength="45" placeholder="Joe">
				  <p id="err_first_name" style="display:none; color: red;">
					First name cannot be blank.
				  </p>
				  
				  <b>Last name: </b>
				  <input type="text" id="last_name" name="last_name" class="input_field" maxlength="45" placeholder="Smith">
				  <p id="err_last_name" style="display:none; color: red;">
					Last name cannot be blank.
				  </p>
				  
				  <b>Password:</b>
				  <input type="password" id="password" name="password" class="input_field" maxlength="45" placeholder="Password">
				  <p id="err_password" style="display:none; color: red;">
					Password cannot be blank.
				  </p>
				  
				  <b>Email:</b>
				  <input type="text" id="email" name="email" class="input_field" maxlength="45" placeholder="joe.smith@gmail.com">
				  <p id="err_email" style="display:none; color: red;">
					Email cannot be blank.
				  </p>
				
				</form>
				<br />
				<button id="btn_save" class="button special big">Save Changes</button>			
			</div>
		';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>		