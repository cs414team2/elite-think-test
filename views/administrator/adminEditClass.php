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
				<div class="container" style="text-align:center">
					<section id="content" style"max-height:600px; text-align:center"">
					<!-- Content -->
					<h2> Add or Delete Students</h2>
						<div class="table-wrapper">
							
							<table class="sortable" >
								<thead>
								</thead>
								<tbody id="tbl_students">';
									$admin = new Admin();
									$admin->get_students($_REQUEST["id"]);
						echo   '</tbody>
							</table>
					</section>	
							<hr />
							<h2> Change Course Instructor</h2>
							<select name="ddl_teachers" id="ddl_teachers" margin-bottom: 8px;>';
								$admin = new Admin();
								$admin->get_teacher_ddl($_REQUEST["id"]);
						echo '</select>
							<br />
							<button id="btn_update_enrollment" class="button special" >Save Changes</button>
						</div>
					<	
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