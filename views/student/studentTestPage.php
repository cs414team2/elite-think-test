<?php
	include_once('model/Test.php');
	
if (isset($_SESSION['credentials'], $_REQUEST['test_id'])){
	$test_id = $_REQUEST['test_id'];
	$test    = new Test($test_id);
	
	if ($_SESSION['credentials']->is_student() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		echo '<section id="main" class="wrapper style1">
				<link rel="stylesheet" href="css/jquery-ui-1.11.4.custom/jquery-ui.css">
				<script src="controllers/test_taker.js"></script>
				<script>
					var test_id    = ' . $test_id . ';
					var student_id = ' . $_SESSION['credentials']->get_user_id() . ';
				</script>
				<div class="testContainer">
					<div id="sidebar" class="sidebar" style="text-align:center">
						
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
							
								
							<div style="color:white;">	
								<progress id="test_progress" max="100" value="0" style="color:white;"></progress>
								&nbsp&nbsp&nbsp<span id="percentage"></span>%<br />
								<span id="questionAnswered"></span>/<span id="total"></span>
								<br /><br />
							</div>	
								<button id="btn_complete" class="show_hide button small fit" disabled>Complete Test</button>		
						</section>	
					</div>
									
					<div class="studentTest" style="float:right;">
						<h2 style="padding:10px;">'. $test->get_class_name() . ' - Test '. $test->get_test_number() . '</h2>
						<section id="testView">
							<div id="test_content" style="display: none;">
								<div class="my-form-builder" align="left">
									<div class="loader">Loading...</div>
								</div>
								<br />
							</div>
							<div style="text-align:center">
								<img src="images/startbutton.png" class="clickable_img" title="Start This Test" id="btn_start"  style=" display:none;" disabled>
					        </div>
						</section>
					</div>
				</div>
			</section>
			
			<div id="pledgeDialog" class="dialog_box" title="Pledge" style="background-color:white;">
				<p>I have completed this test without any outside help or online assistance. I understand that disciplinary actions may occur if I communicate answers to others.</p>
				<input id="txt_pledge_signature" type="text" placeholder="Sign Here" />
				<p id="err_empty_signature" style="display: none; color: red;">
					Please enter your signature.
				</p>
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
			
	










