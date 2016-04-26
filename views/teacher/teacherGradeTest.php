<?php
require_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		$test = new Test($_REQUEST['test_id']);
		
		echo '
			<script src="controllers/test_grader.js"></script>
			<script>
				var test_id = '. $_REQUEST['test_id'] . ';
			</script>
			<div class="testContainer">
				<div id="sidebar" class="sidebar" style="text-align:center;">
					<section style="text-align:center">
						<h2>Select a student&apos;s test to grade </h2>
							<section id="studentTest" style="max-height:375px; padding:1em; min-height:300px; margin-left:2em; margin-right:2em; overflow-y:auto; background-color:lightgray; ">';
								$test->print_finished_ungraded_students();
					echo	'</section>
					</section>
					<button class="alt fit button special" style="width: 85%; margin: 0.5em auto;" id="btn_finalize_grade">Finalize Grade</button>
					
					<section id="test_guide" style="padding:1em; min-height:50px;  margin:1em; margin-left:2em; margin-right:2em; background-color:lightgray; ">
					<h1> Grading Symbols </h1>
					<ul style="list-style-type: none; text-align: left;">
						<li><span style="color:orange;">&#8656;</span> - Student gave no answer</li>
						<li><span style="color:#47CC7A;">&#10003;</span> - Student gave correct answer</li>
						<li><span style="color:#CC1C11;">&#10006;</span> - student gave wrong answer </li>
					</ul>

					</section>
						
				</div>		
		
				<div class="studentTest" style="float:right;">
					<h2 style="padding:10px;"><span id="grade_curr_stud_name"></span> Test '. $test->get_test_number() . ' - ' . $test->get_class_name() . '</h2>
					<section id="gradeView">
						<div id="grade_content" align="left" ';
						if (isset($_REQUEST['student_id'])){
							echo '>';
							require_once('model/StudentTest.php');
							$student_test = new StudentTest($_REQUEST['test_id'], $_REQUEST['student_id']);
							$student_test->print_test(Test::TEACHER);
						}
						else {
							echo 'style="display: none;">
							<div class="my-form-builder">
								<div class="loader">Loading...</div>
							</div>';
						}
						
					echo '
						</div>
						<div id="area_grade_loader" style="display:none;" class="my-form-builder">
							<div   class="loader">Loading...</div>
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