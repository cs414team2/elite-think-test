<?php
include('model/Admin.php');
if (isset($_SESSION['credentials'], $_REQUEST["id"])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo '
		<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="courseName">Edit Class</h2>
				</header>
				<div class="container" style="text-align:center">
					<section id="content">	
					<!-- Content -->
						<div class="table_wrapper">
							<table class="sortable">
								<thead>
									<tr>
										<th>ID</th>
										<th>Student Name</th>	
									</tr>
								</thead>
								<tbody id="tbl_students">';
									$admin = new Admin();
									$admin->get_students($_REQUEST["id"]);
						echo   '</tbody>
							</table>
							<button class="button special" >Save Changes</button>
						
						
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