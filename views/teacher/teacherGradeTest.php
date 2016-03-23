<?php
require_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		$test = new Test($_REQUEST['test_id']);
		
		echo ' 
			<div class="testContainer">
				<div id="sidebar" style="text-align:center">
					
					<section style="text-align:center">
						<h2>Select a Test to Grade </h2>
							<section id="studentTest" style="max-height:800px; padding:1em; min-height:450px; margin-left:2em; margin-right:2em; overflow-y:auto; background-color:lightgray; ">';
								$test->get_completed_tests();
					echo	'</section>

					</section>	
				</div>		
		
				<div class="studentTest" style="float:right;">
					<h2 style="padding:10px;">Test '. $test->get_test_number() . ' - ' . $test->get_class_name() . '</h2>
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