<?php
	include_once('model/Test.php');
	
if (isset($_SESSION['credentials'], $_REQUEST['test_id'])){
	$test_id = $_REQUEST['test_id'];
	$test    = new Test($test_id);
	
	if ($_SESSION['credentials']->is_student() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		echo '<section id="main" class="wrapper style1">
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				<script src="controllers/test_taker.js"></script>
				<script>
					var test_id    = ' . $test_id . ';
					var student_id = ' . $_SESSION['credentials']->get_user_id() . ';
				</script>
				<div class="testContainer">
					<div id="sidebar" style="text-align:center">
						
						<section style="text-align:center">
							<img id="testpageIconImage" src="images/eliteicon.png" width="100" height="110" alt="elite logo"/>
							<br /><br />
							<h2>Time Limit on test: </h2>
							<h1>Time Left</h1>
								<div id="clockdiv">
								  <div>
									<div id="div_minutes">--</div>
								  </div>
								  :
								  <div>
									<div id="div_seconds">--</div>
								  </div>
								</div>
							<br /><br /><br />
							
								
								
								<h4 style="color:white;">Put the progress here</h4>
								
								<button id="btn_complete" class="show_hide button small fit">Complete Test</button>		
						</section>	
					</div>
									
					<div class="studentTest" style="float:right;">
						<h2 style="padding:10px;">'; $test->get_class_name(); echo ' - '; $test->get_test_number(); echo '</h2>
						<section id="testView">
							<div id="test_content" style="display: none;">
								<div class="my-form-builder" align="left">
									<div class="loader">Loading...</div>
								</div>
								<br />
							</div>
							<div style="text-align:center">
								<button id="btn_start" class="show_hide button big  " style="height:200px;  width:400px; background-color:gray;">Start Test</button>
					        </div>
						</section>
					</div>
				</div>
			</section>
			
			<div id="pledgeDialog" title="Pledge" style="background-color:white;">
				<p>I have completed this test without any outside help or online assistance. I understand that disciplinary actions may occur if I communicate answers to others.</p>
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
			
	










