<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Home </h2>
				<p>Manage any of the following</p>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section style="text-align:center">
						<a href="./?action=admin_student_manager" class="button big">Create a test</a>
						<a class="button big">View Classes</a>
						<a href="./?action=admin_class_manager" class="button big">View Tests</a>
					</section>
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>