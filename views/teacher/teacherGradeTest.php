<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo ' 
			<div class="testContainer">
				<div id="sidebar" style="text-align:center">
					
					<section style="text-align:center">
						<h2>Select a Test to Grade </h2>
							<section id="studentTest" style="max-height:800px; padding:1em; min-height:450px; margin-left:2em; margin-right:2em; overflow-y:auto; background-color:lightgray; ">
								<div class="gradeTestDiv"> 
									<h1>Jesse Davis <button class="alt button special reset gradeTestButton" >Grade</button><h1>
								</div>
					</section>

					</section>	
				</div>		
		
				<div class="studentTest" style="float:right;">
					<h2 style="padding:10px;">Test 2 NU 405 Nursing Seminar</h2>
					<section id="gradeView">
						<div id="grade_content" style="display: none;">
							<div class="my-form-builder" align="left">
								<div class="loader">Loading...</div>
							</div>
							<br />
						</div>
					</section>
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