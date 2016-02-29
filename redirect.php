<!DOCTYPE HTML>
<!-- This page acts as a middle-man to process logon information and pass the
     Session information to the index page.
     The purpose for this page was to prevent the form from resubmitting when the back
     arrow is hit after a fresh login -->
<html>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<?php
			require_once('model/Session.php');
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
		?>
	</head>
</html>