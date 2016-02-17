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
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="js/showHide.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function(){


		   $('.show_hide').showHide({			 
				speed: 1000,  // speed you want the toggle to happen	
				easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
				changeText: 1, // if you dont want the button text to change, set this to 0
				showText: 'View',// the button text to show when a div is closed
				hideText: 'Close' // the button text to show when a div is open
							 
			}); 


		});
		</script>
		
		
		<noscript>
			<link rel="stylesheet" href="views/css/skel.css" />
			<link rel="stylesheet" href="views/css/style.css" />
			<link rel="stylesheet" href="views/css/style-xlarge.css" />
		</noscript>


		<?php require_once("model/Session.php"); ?>
		<?php
			function loadHomePage($access_level) {
				switch($access_level){
					case Session::ADMINISTRATOR:
						require_once('views/administrator/adminHome.php');
						break;
					case Session::STUDENT:
						require_once('views/student/studentHome.php');
						break;
					case Session::TEACHER:
						require_once('views/teacher/teacherHome.php');
						break;
				}
			}
		?>

	</head>
	
	<body class="landing">
				
		<!-- Checks to see if the user is logged in or not -->
		<?php
			session_start();
			
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case "admin_class_manager":
						require_once('views/administrator/adminClassesManager.php');
						break;
					case "admin_student_manager":
						require_once('views/administrator/adminStudentsManager.php');
						break;
					case "admin_teacher_manager":
						require_once('views/administrator/adminTeachersManager.php');
						break;
						
					case "login":					
						$session = new Session($_POST['username'], $_POST['password']);
						
						if ($session->is_authenticated()) {
							$_SESSION["credentials"] = $session;
							loadHomePage($_SESSION["credentials"]->get_access_level());
						}
						else {
							require_once('views/logon.php');
							echo "<script type='text/javascript'>
								$(document).ready(function(){
									$('#logon_fail_message').show(600);
								});
							  </script>";
						}
						break;
						
					case "logout": 
						unset($_SESSION["credentials"]);
						require_once('views/logon.php');
						break;
				}
			}
			elseif (isset($_SESSION["credentials"]))
			{
				if ($_SESSION["credentials"]->is_authenticated()) {
					loadHomePage($_SESSION["credentials"]->get_access_level());
				}
				else {
					// <!-- Loads the Log On page --> 
					require_once('views/logon.php');
				}
			}
			else {
				// <!-- Loads the Log On page --> 
				require_once('views/logon.php');
			}
		?>
		
		<!-- Includes the Header for the page -->
		<?php 
			require_once('header.php');
		?>	
		
		<!-- Includes the Footer for the page -->
		<?php 
			require_once('footer.php');
		?>

	</body>
</html>