<?php
include('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo '
		<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="courseName">Edit Class</h2>
				</header>
				<div class="container" style="text-align:center">
						
					<!-- Content -->
						<section id="content">
							<table class="alt">
								<thead>
									<tr>
										<th>ID</th>
										<th>Student Name</th>	
									</tr>
								</thead>
								<tbody>';
									$admin = new Admin();
									$admin->get_students();
						echo   '</tbody>
							</table>
							<button class="button special" >Save Changes</button>
							
						</section>
						
				    </div>


		
		';
	}
}
else {
	header('Location: ./');
}
?>