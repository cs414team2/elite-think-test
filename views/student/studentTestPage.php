<?php
	include_once('model/Test.php');
	
if (isset($_SESSION['credentials'], $_REQUEST['test_id'])){
	$test = new Test();
	$test_id = $_REQUEST['test_id'];
	if ($_SESSION['credentials']->is_student() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_REQUEST['test_id'], $_SESSION['credentials']->get_access_level())) {
		echo '<section id="main" class="wrapper style1">
				<script src="controllers/test_taker.js"></script>
				<script>
					var test_id = ' . $_REQUEST['test_id'] . ';
				</script>
		
				<div class="testContainer">
					<div id="sidebar" style="text-align:center">
						
						<section style="text-align:center">
							<h2>Time Limit on test: </h2>
							<h1>Countdown Clock</h1>
								<div id="clockdiv">
								  <div>
									<div id="div_minutes">Minutes</div>
								  </div>
								  <div>
									<div id="div_seconds">Seconds</div>
								  </div>
								</div>
							<br /><br /><br />
							
								<button id="btn_start" class="show_hide button small fit">Start Test</button>
								
								<h4 style="color:white;">Put the progress here</h4>

								<button id="btn_complete" class="show_hide button small fit">Complete Test</button>		
						</section>	
					</div>
					
					<div class="studentTest" style="float:right;">
						<h2 style="padding:10px;">'; $test->get_class_name($test_id); echo ' - '; $test->get_test_number($test_id); echo '</h2>
						<section id="testView">
							<div id="my-form-builder" align="left">
								<div id="test_content">
									Test Loading...
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
			
	










