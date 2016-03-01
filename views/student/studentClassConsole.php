<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		echo '

			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Elements</h2>
					<p>Faucibus neque adipiscing mi lorem semper blandit</p>
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content">
						
						</section>

			</section>
			




		';
	}
}
else {
	header('Location: ./');
}
?>