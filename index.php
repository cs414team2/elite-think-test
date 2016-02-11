<!DOCTYPE HTML>
<html>
	<head>
		<title>Elite Testing</title>
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
			<link rel="stylesheet" href="views/css/skel.css" />
			<link rel="stylesheet" href="views/css/style.css" />
			<link rel="stylesheet" href="views/css/style-xlarge.css" />
		</noscript>

	</head>
	
	<body class="landing">
				
		<!-- Checks to see if the user is logged in or not -->
		<?php
			session_start();

			if(isset($_POST['senddata']))
			{			
				$_SESSION["username"] = $_POST['username'];
				$_SESSION["password"] = $_POST['password'];
				echo "your username is "       .$_SESSION["username"];
				echo "<br />your password is " .$_SESSION["password"];
			}
			else
			{
				
			}
			
			if (isset($_GET['action']))
			{
				switch ($_GET['action'])
				{
					case "logout": 
					// Remove all session variables
					session_unset(); 

					// Destroy the session 
					session_destroy();
				}
			}
		?>
		
		<?php 
			// Includes the Header for the page
			require_once('header.php');
		?>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<img src="images/elitelogo.png" width="200" height="230" alt="elite logo"/>
					<p>On-line Testing Application</p>
					<ul class="actions">
						<li><a href="#one" class="button big scrolly">Login</a></li>
					</ul>
				</div>
			</section>

		
			<section id="one" class="wrapper style1">
				<div class="container">
					<header class="major">
						<h2>Enter Your Information</h2>
						<form method="post" action="index.php">
							User name:<br>
							<input type="text" name="username" style='text-align:center'><br><br>
							Password:<br>
							<input type="password" name="password" style='text-align:center'>
							<br><br>
							<input name="senddata" type="submit" value="Login"><br><br>
						</form>
					</header>
				</div>
			</section>
			
		<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="container">
					<div class="row uniform">
						<div class="4u 6u(2) 12u$(3)">
							<section class="feature fa-briefcase">
								<h3>Management Features</h3>
								<p>Create, manage, and update exams to your liking. You are in full control of your abilities.</p>
							</section>
						</div>
						<div class="4u 6u$(2) 12u$(3)">
							<section class="feature fa-code">
								<h3>Strictly Online</h3>
								<p>No paperwork necessary. Log in, navigate to a test, and meet personal goals.</p>
							</section>
						</div>
						<div class="4u$ 6u(2) 12u$(3)">
							<section class="feature fa-save">
								<h3>Save Your Work</h3>
								<p>Your account is accessible on most devices. Log in from around the world!</p>
							</section>
						</div>
						<div class="4u 6u$(2) 12u$(3)">
							<section class="feature fa-desktop">
								<h3>On-line Instructions</h3>
								<p>Simple online services keep the style as simple as possible.</p>
							</section>
						</div>
						<div class="4u 6u(2) 12u$(3)">
							<section class="feature fa-camera-retro">
								<h3>Instant Updating</h3>
								<p>The Elite Team are constantly updating the website to meet the highest expectations for our users.</p>
							</section>
						</div>
						<div class="4u$ 6u$(2) 12u$(3)">
							<section class="feature fa-cog">
								<h3>Constant Feedback</h3>
								<p>See your scores and view your progress as you take an exam.</p>
							</section>
						</div>
					</div>
				</div>
			</section>
			
		<!-- CTA -->
			<section id="cta" class="wrapper style3">
				<h2>Are you ready to go?</h2>
				<ul class="actions">
					<li><a href="#one" class="button big">Get Started</a></li>
				</ul>
			</section>
			
		<?php 
			// Includes the Footer for the page
			require_once('footer.php');
		?>

	</body>
</html>