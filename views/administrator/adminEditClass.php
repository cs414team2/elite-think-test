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
				<!-- Content -->
				<section id="content">
					<div class="table-wrapper">
						<table class="sortable">
							<thead>
								<tr>
									<th>Enrolled</th>
									<th>ID</th>
									<th>Last Name</th>
									<th>First Name</th>
								</tr>
							</thead>
							<tbody id="tbl_students">';
								$admin = new Admin();
								$admin->get_students($_REQUEST["id"]);
					echo   '</tbody>
						</table>
					</div>
					<button id="btn_update_enrollment" class="button special" >Save Changes</button>
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