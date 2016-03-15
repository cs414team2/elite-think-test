<?php
	include_once('model/Test.php');
	
if (isset($_SESSION['credentials'], $_REQUEST['test_id'])){
	$test_id = $_REQUEST['test_id'];
	$test    = new Test($test_id);
	
	if ($_SESSION['credentials']->is_student() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		echo '<section id="main" class="wrapper style1">
				<script src="controllers/test_taker.js"></script>
				<script>
					var test_id    = ' . $test_id . ';
					var student_id = ' . $_SESSION['credentials']->get_user_id() . ';
				</script>
				
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				<script>
					$(function() {
						$( "#pledgeDialog" ).dialog({
						autoOpen: false,
						modal: true,
						width: 500,
						buttons: {
						"Sign Pledge": function() {
						  complete_test();
						},
						Cancel: function() {
						  $( this ).dialog( "close" );
						}	
						show: {
							effect: "size",
							duration: 500
						},
						hide: {
							effect: "size",
							duration: 500
						}
						});
				 
						$( "#btn2_complete" ).click(function() {
							$( "#pledgeDialog" ).dialog( "open" );
						});

					});
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
								<button id="btn2_complete" class="show_hide button small fit">Complete Test</button>		
						</section>	
					</div>
					
					<div class="studentTest" style="float:right;">
						<h2 style="padding:10px;">'; $test->get_class_name(); echo ' - '; $test->get_test_number(); echo '</h2>
						<section id="testView">
							<div id="test_content">
								<div class="my-form-builder" align="left">
									Test Loading...
								</div>
								<br />
							</div>
						</section>
					</div>
				</div>
			</section>
			
			<div id="pledgeDialog" title="Pledge" style="background-color:white;">
				<p>Dude</p>
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
			
	










