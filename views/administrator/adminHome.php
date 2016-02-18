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
						<a href="./?action=admin_student_manager" class="button big">Students</a><br />
						<a href="./?action=admin_teacher_manager" class="button big">Teachers</a><br />
						<a href="./?action=admin_class_manager" class="button big">Classes</a><br />
					</section>
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>