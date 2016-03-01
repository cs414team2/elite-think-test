<!DOCTYPE HTML>
<html>
	<head>
		<title>Elite Testing</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Elite Testing application" />
		<meta name="keywords" content="testing, login, student, teacher, administrator" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">

		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/jquery.scrollgress.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.slidertron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src="js/showHide.js" type="text/javascript"></script>
		
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
			$load_footer = true;
			
			session_start();
			
			if (isset($_REQUEST['action'])) {
				switch ($_REQUEST['action']) {
					case "admin_class_manager":
						require_once('views/administrator/adminClassesManager.php');
						break;
					case "admin_student_manager":
						require_once('views/administrator/adminStudentsManager.php');
						break;
					case "admin_teacher_manager":
						require_once('views/administrator/adminTeachersManager.php');
						break;
					case "admin_edit_class":
						require_once('views/administrator/adminEditClass.php');
						break;

					case "teacher_edit_test":
						require_once('views/teacher/teacherEditTest.php');
						$load_footer = false;
						break;
					case "teacher_grade_test":
						require_once('views/teacher/teacherGradeTest.php');
						break;
						
					case "student_class_console":
						require_once('views/student/studentClassConsole.php');
						break;	
					case "student_test_page":
						require_once('views/student/studentTestPage.php');
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
			if($load_footer)
				require_once('footer.php');
		?>

	</body>
</html>