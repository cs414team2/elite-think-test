<?php

if (isset($_SESSION['credentials'], $_REQUEST["class_id"])) {
	if ($_SESSION['credentials']->is_teacher()) {
		echo '
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script>
			var user_id = '. $_SESSION['credentials']->get_user_id() .
		';</script>
		<script src="controllers/class_viewer.js"></script>
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Course Overview </h2>
			</header>
			<div class="container" style="text-align:center">
					
				<!-- Content -->
				<h2> Students</h2>
				<ul>
					<li>Bob Johnson</li>
					<li>Bill Tedson</li>
					<li>Barney Philson</li>
					<li>Betty Randolfson</li>
				</ul>
				<div id="pie_letter_frequency" class="chart1" ></div>	
				<div id="bar_something" class="chart2"></div>
				<div><h2 style="color: black; text-shadow: 0em 0em 0em black;">Highest grade:   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Lowest grade: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Average grade:</h2></div>
				<div  style="color: black; text-shadow: 0em 0em 0em black;">
					 <h2 style="color: black; text-shadow: 0em 0em 0em black;">Number of A\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of B\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of C\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of D\'s: &nbsp&nbsp&nbsp&nbsp
					 Number of F\'s: &nbsp&nbsp&nbsp&nbsp</h2>
				</div>
			</div>
		</section>';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>