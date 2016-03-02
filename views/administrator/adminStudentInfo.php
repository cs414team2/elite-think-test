<?php
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'					<!-- Content -->
						<section id="content" class="wrapper style2">
							<h3>Summary student Information</h3>
							<div>
								<p>ID: </p>
								<p>Name: </p> <p>Last: </p>
								<p>Classification: </p>	<p>GPA: </p>
								<p>Email: </p>
					
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