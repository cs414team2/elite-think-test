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
					<h2 id="courseName">Edit Class</h2>
				</header>
				<div class="container" style="text-align:center">
					<section id="content">
					<!-- Content -->
						<select name="ddl_teachers" id="ddl_teachers" margin-bottom: 8px;>';
								$admin = new Admin();
								$admin->get_teacher_ddl($_REQUEST["id"]);
				   echo '</select>
					
						<div class="table_wrapper">
							<table class="sortable table_wrapper">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th colspan="2">Student Name</th>
									</tr>
								</thead>
								<tbody id="tbl_students">';
									$admin = new Admin();
									$admin->get_students($_REQUEST["id"]);
						echo   '</tbody>
							</table>
							<button id="btn_update_enrollment" class="button special" >Save Changes</button>
						</div>
					</section>		
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