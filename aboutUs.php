<!DOCTYPE HTML>
<html>
	<head>
		<title>About Elite</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Elite Testing application" />
		<meta name="keywords" content="testing, login, student, teacher, administrator" />
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
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
			require_once('model/Session.php');
			if (!isset($SESSION)) {
				ini_set('session.gc_probability', 0);
				session_start();
			}
			require_once('header.php');
		?>

			<!-- Main -->
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>About Elite</h2>

				</header>
				<div class="container" align="center">
						
					<!-- Content -->
					<section id="content">
							<p>The Elite team is a Systems Design Team which develops high quality software. <br />
							   Our newest release EliteThink is an online testing center developed with both <br />
							   the student and the teacher in mind.</p>
					</section>
					
							<section id="content">
							<img src="images/andrewWhiting.jpg" class="circular" alt="Andrew"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<img src="images/danielSwan.jpg" alt="Daniel" class="circular" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<img src="images/jeremeScheffel.jpg" alt="Jereme" class="circular"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<img src="images/jesseDavis.jpg" alt="Jesse" class="circular"/>

							<div>
							<table style="text-align:center">
								<tr>
									<td>
										<h3>Andrew Whiting</h3>
										<h5>Project Manager</h5>
											 Home Town: Fayetteville, NC <br />
											   Major: Computer Information Systems<br />
											   Year: Senior <br />
											   Age: 22      <br />
											   Fun Fact:    <br />
									</td>		   
									<td>
										<h3>Daniel Swan</h3>
										<h5>Assistant Project Manager</h5>
											   Home Town: Washburn, MO <br />
											   Major: Computer Information Systems<br />
											   Year: Senior <br />
											   Age: <?php echo floor((time() - strtotime("Apr 18, 1989 08:00:00 CST")) / (60 * 60 * 24 * 365)); ?> <br />
											   Fun Fact:    <br />
									</td>
									<td>
									
										<h3>Jereme Scheffel</h3>
										<h5>Secretary</h5>
											   Home Town: Cincinatti, OH <br />
											   Major: Computer Information Systems<br />
											   Year: Senior <br />
											   Age: 22      <br />
											   Fun Fact: <a href="css/ie/aboutMe.html">Find out here</a><br />
									</td>
									<td>
									
										<h3>Jesse Davis</h3>
										<h5>Scheduler</h5>
											   Home Town: San Francisco, CA <br />
											   Major: Computer Information Systems<br />
											   Year: Senior <br />
											   Age: 21      <br />
											   Fun Fact:    Has been hit by a car-twice.<br />
									</td>
								</tr>	
							</table>	
							</div>
								
				</div>
			</section>
	</body>
</html>