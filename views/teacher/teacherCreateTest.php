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
				<a class="button big" draggable="true">Essay</a><br />
				<a class="button big" draggable="true" >True/False</a> <br / >
				<a class="button big" draggable="true" >Multiple Choice</a><br />
			</div>



			
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









