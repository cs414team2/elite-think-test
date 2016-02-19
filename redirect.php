<!DOCTYPE HTML>
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
			}
			else {
				$_SESSION["logon_failed"] = true;
			}
			echo '<script type="text/javascript">
					$(document).ready(function(){
						window.location = "index.php";
					});
				 </script>';
		?>
	</head>
</html>