<?php
include('model/Admin.php');
if (isset($_SESSION['credentials'], $_REQUEST["id"])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo '
		<script src="controllers/class_editor.js"></script>
		<script>
			var class_id = ' . $_REQUEST["id"] . ';
		</script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2 id="courseName">Place course Name here</h2>
			</header>
			
			<div class="container">
				<section id="content" style"max-height:600px;">
				<!-- Content -->
				<h4 style="display:inline-block;"> &#9699;&nbspAdd or Remove Students</h4>
				<button id="btn_update_enrollment" class="button special" style="display:inline-block; float: right;">&nbsp&nbspSave Changes&nbsp&nbsp</button>
				<br />
				
				<h4 style="display:inline-block; float: left; margin-top: 10px;">Instructor:&nbsp&nbsp&nbsp</h4>
				<select name="ddl_teachers" id="ddl_teachers" style="width: 240px; display:inline-block;">';
							$admin = new Admin();
							$admin->get_teachers($_REQUEST["id"]);
		  echo '</select>
				<br /><br />
				<div class="table-wrapper">
					<table style="text-align:center">
						<thead>
							<tr>
								<th style="text-align: center;">Enrolled</th>
								<th style="text-align: center;">ID</th>
								<th style="text-align: center;">Last Name</th>
								<th style="text-align: center;">First Name</th>
							</tr>
						</thead>
						<tbody id="tbl_students">';
							$admin = new Admin();
							$admin->get_students($_REQUEST["id"]);
				echo   '</tbody>
					</table>
				</div>		
			</div>
		</section>
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