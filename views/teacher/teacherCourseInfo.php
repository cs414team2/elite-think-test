<?php
require_once('model/Teacher.php');
if (isset($_SESSION['credentials'], $_REQUEST["class_id"])) {
	if ($_SESSION['credentials']->is_teacher()) {
		echo '
			<script>
			var user_id = '. $_SESSION['credentials']->get_user_id() .
		';</script>
		<script src="controllers/teacher_console.js"></script>

		<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Course Overview </h2>
			</header>
			<div class="container">
					
				<!-- Content -->
				<h1>Class Letter Grades</h1>
				<div style="font-color: black; border-style:solid; border-style: solid; border-color:black; border-width: 0.25em;">A: 12 &nbsp&nbsp B: 14 &nbsp&nbsp C:15 &nbsp&nbsp D: 6 &nbsp&nbsp F: 2</div>
				<br /><br />
				<h1>Class Average</h1>
				<div style="border-style:solid; border-style: solid; border-color:black; border-width: 0.25em;">This is a div</div>
				<br /><br />
				<h1>Most missed Questions</h1>
				<div style="border-style:solid; border-style: solid; border-color:black; border-width: 0.25em;">This is a div</div>
				<br /><br />
				<div style="border-style:solid; border-style: solid; border-color:black; border-width: 0.25em;">This is a div</div>
				<br /><br />
				<div style="border-style:solid; border-style: solid; border-color:black; border-width: 0.25em;">This is a div</div>

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