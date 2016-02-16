<!DOCTYPE HTML>
<html>
	<head>
		<title>Elite Testing</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Elite Testing application" />
		<meta name="keywords" content="testing, login, student, teacher, administrator" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
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
			<link rel="stylesheet" href="views/css/skel.css" />
			<link rel="stylesheet" href="views/css/style.css" />
			<link rel="stylesheet" href="views/css/style-xlarge.css" />
		</noscript>


		<?php require_once("model/Session.php"); ?>

	</head>
	
	<body class="landing">
		
		<?php 
			// Includes the Header for the page
			require_once('header.php');
		?>
				
		<!-- Checks to see if the user is logged in or not -->
		<?php
			session_start();
			
			if (isset($_GET['action']))
			{
				switch ($_GET['action'])
				{
					case "login":					
						$session = new Session($_POST['username'], $_POST['password']);
						
						if ($session->is_authenticated())
						{
							$_SESSION["credentials"] = $session;
						}
						else
						{
							echo "<script type='text/javascript'>
								$(document).ready(function(){
									$('#logon_fail_message').show(600);
								});
							  </script>";
						}
						break;
						
					case "logout": 
						unset($_SESSION["credentials"]);
						break;
				}
			}
			
			if (isset($_SESSION["credentials"]))
			{
				if ($_SESSION["credentials"]->is_authenticated())
				{
					switch($_SESSION["credentials"]->get_access_level())
					{
						case Session::ADMINISTRATOR:
							require_once('views/administrator/adminHome.php');
							/*echo '<script type="text/javascript">
								window.location = "views/administrator/adminHome.php";
								</script>';*/
							break;
					}
				}
				else
				{
					// <!-- Loads the Log On page --> 
					require_once('views/logon.php');
				}
			}
			else
			{
				// <!-- Loads the Log On page --> 
				require_once('views/logon.php');
			}
		?>
			
		<!-- Includes the Footer for the page -->
		<?php 
			require_once('footer.php');
		?>

	</body>
</html>