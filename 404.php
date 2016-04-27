<!DOCTYPE html>
<html>
	<head>
		<title>Broken Bulb</title>
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
	<body class="404pageBody">
		<?php 
				// Includes the Header for the page
				require_once('model/Session.php');
				if (!isset($SESSION)) {
					ini_set('session.gc_probability', 0);
					session_start();
				}
				require_once('header.php');
		?>
			
		<div id="root_img" style="width:100%; height:100%" >
			<div id="id_immagine" align="center" style="width: 100%; height: 100%;">
				<img src="images/flicker.gif" alt="404 Bulb" class="404pageImg" style="width: 20%; height: 20%">
				<h1 class="404pageItem">Well, this is awkward...</h1>
				<h2 class="404pageItem">You have a faulty bulb!</h2>
				<h1 class="404pageItem"><a href="index.php">Return Home</a></h1>
			</div>
		</div>
	</body>
</html>