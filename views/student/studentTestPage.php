<?php
	include_once('model/Test.php');
	
if (isset($_SESSION['credentials'], $_REQUEST['test_id'])){
	$test = new Test();
	if ($_SESSION['credentials']->is_teacher() && $test->verify_teacher_test_access($_SESSION['credentials']->get_user_id(), $_REQUEST['test_id'], $_SESSION['credentials']->get_access_level())) {
		$test_id = $_REQUEST['test_id'];
		echo '<section id="main" class="wrapper style1">
				<script src="controllers/test_editor.js"></script>
				
				<header class="major">
					
				</header>
			
				<div class="testContainer">
					<div id="sidebar" style="text-align:center">
						
						<section style="text-align:center">
							<h2>Time Limit on test: </h2>
							<h1> This is the timer</h1>
							<br /><br /><br />
							
								<button class="show_hide button small fit">Start Test</button>
								
								<h4 style="color:white;">Put the progress here</h4>

								<button class="show_hide button small fit">Complete Test</button>
								
						</section>
				
						
						
						</div>

					<div class="studentTest" style="float:right;"> 
						<section id="testView">
							<div id="my-form-builder" align="left">
								<h4>Test Goes Here Yo!</h4>
									
									<div id="test_content">
									
									
									</div>
								<br />
								
							</div>
						</section>
					</div>
				</div>
			</section>';
	}
}
?>
			
	










