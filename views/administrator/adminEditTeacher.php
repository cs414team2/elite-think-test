<?php
include('model/Admin.php');
include('model/Teacher.php');
if (isset($_SESSION['credentials'], $_REQUEST["id"])) {
	if ($_SESSION['credentials']->is_admin()) {
		$teacher = new Teacher();
		echo '
			<link rel="stylesheet" href="css/jquery-ui-1.11.4.custom/jquery-ui.css">
			<script src="controllers/edit_teacher_form.js"></script>
			
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="h_teacher_info">'; $teacher->get_teacher_info($_REQUEST["id"]); echo '</h2>
				</header>
				
				<div class="container" >	
					<!-- Content -->
					<section>
						<section style="display: inline-block;">
							<select name="teacher" id="ddl_switch_teacher" style="display: inline-block;">';
								$admin = new Admin();
								$admin->get_teachers_ddl_for_teacher($_REQUEST["id"]);
					  echo '</select>
							<br />
							</section>
						<img src="images/edit_user.png" class="clickable_img clickable_img_square" title="Edit This Teacher" id="btn_open_edit_teacher_dialog" style="display:inline-block; float: right;">
						<hr />
						<div id="area_teacher_info">
						<table class="alt" id="content">
						<caption style="font-weight: bold; text-decoration: underline;">Teacher Information</caption>
							<thead>
								<tr>
									<th>ID</th>
									<th>First</th>
									<th>Last</th>
									<th>Email</th>
									<th>Password</th>
								</tr>
							</thead>
							<tbody>
							<tbody id="tbl_teacher_info">';
								$teacher->get_full_teacher_info($_REQUEST["id"]);
					  echo '</tbody>
						</table>
						</div>
						<div id="area_loader" class="loader" style="display: none;">Loading...</div>
						<hr />
						<table class="alt" id="content">
							<caption style="font-weight: bold; text-decoration: underline;">Assigned Classes</caption>
							<thead>
								<tr>
									<th>Course #</th>
									<th>Course Name</th>
									<th># of Students</th>
									<th>Class Average</th>
								</tr>
							</thead>
							<tbody id="tbl_classes">';
								$teacher->print_classes($_REQUEST["id"]);
					  echo '</tbody>
						</table>
					</section>
				</div>	
			</section>	

			<div id="dlg_edit_teacher_info" class="dialog_box" title="Edit Teacher Information" style="background-color:white; text-align: center;">	
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