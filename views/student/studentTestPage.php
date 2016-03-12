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
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				<script>
					$(function() {
						$( "#dialog" ).dialog({
						autoOpen: false,
						show: {
							effect: "blind",
							duration: 1000
						},
						hide: {
							effect: "explode",
							duration: 1000
						}
						});
				 
						$( "#testCompleteButton" ).click(function() {
							$( "#dialog" ).dialog( "open" );
						});
					});
				</script>
  
				<div class="testContainer">
					<div id="sidebar" style="text-align:center">
						
						<section style="text-align:center">
							<h2>Time Limit on test: </h2>
							<h1> This is the timer</h1>
							<br /><br /><br />
							
								<button class="show_hide button small fit">Start Test</button>
								
								<h4 style="color:white;">Put the progress here</h4>

								<button id="testCompleteButton" class="show_hide button small fit">Complete Test</button>		
						</section>	
					</div>
					
					<div class="studentTest" style="float:right;">
						<h2 style="padding:10px;">'; $test->get_class_name($test_id); echo ' - '; $test->get_test_number($test_id); echo '</h2>
						<section id="testView">
							<div id="test_content" align="left">
								<div class="my-form-builder">
									Test Loading...
								</div>
								<br />
							</div>
						</section>
					</div>
				</div>
			</section>
			
			<div id="dialog" title="Basic dialog" style="background-color:white;">
				<p>This is an animated dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the icon.</p>
			</div>';
	}
}
?>
			
	










