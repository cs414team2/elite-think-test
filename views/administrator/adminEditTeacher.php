<?php
include('model/Admin.php');
if (isset($_SESSION['credentials'], $_REQUEST["id"])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo '
		<script src="controllers/class_editor.js"></script>
		<script>
			var class_id = ' . $_REQUEST["id"] . ';
		</script>
		<section id="main" class="wrapper style1">

				<header class="major">
					<h2 id="courseName">Place course Name here</h2>
				</header>
				<div class="container" style="text-align:center">
					<form>
					  <b>First name: </b>
					  <input type="text" id="first_name" "name="first_name" class="input_field" maxlength="45" placeholder="Joe">
					  <p id="err_first_name" style="display:none; color: red;">
						First name cannot be blank.
					  </p>
					  
					  <b>Last name: </b>
					  <input type="text" id="last_name" name="last_name" class="input_field" maxlength="45" placeholder="Smith">
					  <p id="err_last_name" style="display:none; color: red;">
						Last name cannot be blank.
					  </p>
					  
					  <b>Password:</b>
					  <input type="password" id="password" name="password" class="input_field" maxlength="45" placeholder="Password">
					  <p id="err_password" style="display:none; color: red;">
						Password cannot be blank.
					  </p>
					  
					  <b>Email:</b>
					  <input type="text" id="email" name="email" class="input_field" maxlength="45" placeholder="joe.smith@gmail.com">
					  <p id="err_email" style="display:none; color: red;">
						Email cannot be blank.
					  </p>
					
					</form>		
				
				</div>
		';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>