<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		echo '<!-- Main -->
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Student Home</h2>
				<p>This page has some cool things.</p>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content">
						<a href="#" class="image fit"><img src="../images/pic07.jpg" alt="" /></a>
						<h3>Heading for the below feature</h3>
						<p>Put the different tables here.</p>
					</section>
							
			</div>
		</section>';
	}
}
?>