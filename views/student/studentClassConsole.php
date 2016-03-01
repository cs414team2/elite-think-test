<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		echo '

			<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="courseName">Course Name </h2>
					<p> Course #</p>
					
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content">
							<div>Course Test Average</div>
							<table class="alt">
								<thead>
									<tr>
										<th>Test #</th>
										<th>Test Status</th>
										<th>Test Grade</th>
									</tr>
								</thead>
								
								
								<tbody>
										
								</tbody>
							</table>							
						</section>
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