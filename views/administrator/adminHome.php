<!DOCTYPE HTML>
<html>
	<head>
		<title>Administration Home</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Elite Testing application" />
		<meta name="keywords" content="testing, login, student, teacher, administrator" />


	</head>
	<body>

		<?php 
			// Includes the Header for the page
			require_once('../header.php');
		?>

		<!-- Main -->
			<section id="main" class="wrapper style1">
				<header class="major">

					<h2>Administration Home</h2>
					<p>Manage any of the following</p>

				</header>
				<div class="container">
						
					<!-- Content -->
						<section style="text-align:center" id="content">
							<a href="#" class="image fit"><img src="images/pic07.jpg" alt="" /></a>
							<h3>Administration Home</h3>
							<p>Select what to edit</p>
						</section>
						
						<section style="text-align:center">
						<a href="#" class="button big">Students</a><br />
						<a href="#" class="button big">Teachers</a><br />
						<a href="#" class="button big">Classes</a><br />	

						</section>
				</div>
			</section>
			
		<?php 
			// Includes the Footer for the page
			require_once('../footer.php');
		?>

	</body>
</html>