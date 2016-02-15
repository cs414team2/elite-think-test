<!DOCTYPE HTML>
<html>
	<head>
		<title>Admin student manager</title>
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
					<h2>Student Manager</h2>
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content" class="wrapper style1">
							<h3>This is a list of students</h3>
							<div class="table-wrapper">
										<table>
											<thead>
												<tr>
													<th>First</th>
													<th>Last</th>
													<th>Email</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
									</div>
						</section>
						
						<section id="content" style="text-align:center" class="wrapper style1">
							<h3 align="center">Add a student</h3>
							<form>
							  First name:<br>
							  <input type="text" name="firstname"><br>
							  Last name:<br>
							  <input type="text" name="lastname">
							  Password:<br>
							  <input type="text" name="password">
							  Email:<br>
							  <input type="text" name="emailAddress">
							  
							  <button class="button big">Add student</button>
							
							</form>
						</section>
								
				</div>
			</section>
			
		<?php 
			// Includes the Footer for the page
			require_once('footer.php');
		?>

	</body>
</html>