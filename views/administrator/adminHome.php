<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo '<!-- Main -->
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Administration Home</h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section style="text-align:center">
						<a href="./?action=admin_student_manager" class="button big special">Students</a>
						<a href="./?action=admin_teacher_manager" class="button big special">Teachers</a>
						<a href="./?action=admin_class_manager" class="button big special">Classes</a>
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