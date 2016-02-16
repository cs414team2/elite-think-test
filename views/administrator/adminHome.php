<!DOCTYPE HTML>
<html>
	<head>
		<title>Administration Home</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Elite Testing application" />
		<meta name="keywords" content="testing, login, student, teacher, administrator" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/jquery.scrollgress.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.slidertron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>

	</head>
	<body>

		<?php 
			// Includes the Header for the page
			require_once('header.php');
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
						<a href="http://csweb/cs414/elitethink-test/Andrew/views/Administrator/adminStudentsManager.php" class="button big">Students</a><br />
						<a href="#" class="button big">Teachers</a><br />
						<a href="#" class="button big">Classes</a><br />	
						</section>
				</div>
			</section>
			
		<?php 
			// Includes the Footer for the page
			require_once('footer.php');
		?>

	</body>
</html>