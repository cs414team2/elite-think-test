<?php
	if(!(isset($_POST['username'], $_POST['password']))){
		header('Location: index.php');
		die();
	}
?>

<!DOCTYPE HTML>
<!-- This page acts as a middle-man to process logon information and pass the
     Session information to the index page.
     The purpose for this page was to prevent the form from resubmitting when the back
     arrow is hit after a fresh login -->
<html>
	<head>
	<script src="js/jquery-1.12.3.js" type="text/javascript"></script>
		<?php
		if(isset($_POST['username'], $_POST['password'])){
 			require_once('model/Session.php');
			ini_set('session.gc_probability', 0);
			session_start();
			$session = new Session($_POST['username'], $_POST['password']);
								
			if ($session->is_authenticated()) {
				$_SESSION["credentials"] = $session;
				$_SESSION["logon_failed"] = false;
				
				echo '<script type="text/javascript">
						$(document).ready(function(){
							window.location = "index.php";
						});
				      </script>';
			}
			else {
				$_SESSION["logon_failed"] = true;
				
				echo '<script type="text/javascript">
						$(document).ready(function(){
							window.location = "index.php?#one";
						});
				      </script>';
			}
		}
		else {
			echo '<script type="text/javascript">
						$(document).ready(function(){
							window.location = "index.php?#one";
						});
				      </script>';
		}
		?>
	</head>
</html>