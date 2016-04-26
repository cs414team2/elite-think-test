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
						<div>
							<table style="text-align:center">
								<tr>
									<td><img src="images/andrewWhiting.jpg" class="circular" alt="Andrew"/></td>
									<td><img src="images/danielSwan.jpg" alt="Daniel" class="circular" /></td>
									<td><img src="images/jeremeScheffel.jpg" alt="Jereme" class="circular"/></td>
									<td><img src="images/jesseDavis.jpg" alt="Jesse" class="circular"/></td>
								</tr>
								<tr>
									<td><h3>Andrew Whiting</h3></td>
									<td><h3>Daniel Swan</h3></td>
									<td><h3>Jereme Scheffel</h3></td>
									<td><h3>Jesse Davis</h3></td>
								</tr>
								<tr>
									<td><h5>Project Manager /<br> Database Administrator</h5></td>
									<td><h5>Assistant Project Manager /<br> Architect</h5></td>
									<td><h5>Design Specialist</h5></td>
									<td><h5>Front End Developer</h5></td>
								</tr>
								<tr>
									<td> Home Town: Fayetteville, NC </td>
									<td> Home Town: Washburn, MO </td>
									<td> Home Town: Cincinatti, OH </td>
									<td> Home Town: San Francisco, CA </td>
								</tr>
								<tr>
									<td> Major: Computer Information Systems</td>
									<td> Major: Computer Information Systems</td>
									<td> Major: Computer Information Systems</td>
									<td> Major: Computer Information Systems</td>
								</tr>
								<tr>
									<td> Year: Senior </td>
									<td> Year: Senior </td>
									<td> Year: Senior </td>
									<td> Year: Senior </td>
								</tr>
								<tr>
									<td> Age: 22  </td>
									<td> Age: 27  </td>
									<td> Age: 22  </td>
									<td> Age: 21  </td>
								</tr>
								<tr>
									<td> Fun Fact: Sold &#36;50,000 worth<br> of kitchen supplies.</td>
									<td> Fun Fact: Prefers to be outdoors.</td>
									<td> Fun Fact: <a href="css/ie/aboutMe.html">Find out here</a></td>
									<td> Fun Fact: Has been hit by a car-twice.</td>
								</tr>	
							</table>	
						</div>
					</section>
			</div>
	</body>
</html>