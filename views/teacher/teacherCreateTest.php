<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2> Test Creation</h2>
				<p>Create and Manage Tests</p>
			</header>
		
		<div class="container">
			<div id="sidebar" style="display: inline-block; max-width: 50%; float: left; ">
				<a class="button big">Essay</a><br />
				<a class="button big" >True/False</a> <br / >
				<a class="button big" >Multiple Choice</a><br />
			</div>
			<form style="display: inline-block; max-width: 50%;">
				First name: <input type="text" name="fname"><br>
				Last name: <input type="text" name="lname"><br>
				<input type="submit" value="Submit">
			</form>
			
		</div>
		
		
		</section>
		
			
	
		';
	}
}
else {
	header('Location: ./');
}
?>



';









