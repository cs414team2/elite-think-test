<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		
		<link href="css/jquery.formbuilder.css" media="screen" rel="stylesheet" />
		
		<section id="main" class="wrapper style1">
			<header class="major">
				<h2> Test Creation</h2>
				<p>Create and Manage Tests</p>
			</header>
		
		<div class="testContainer">
			<div id="sidebar">
			
			</div>
			
			<div id="my-form-builder" class="content">
				<form>
					<script>
				$(function(){
					$("#my-form-builder").formbuilder({
						"save_url": "example-save.php",
						"load_url": "example-json.php",
						"useJson" : true
					});
					$(function() {
						$("#my-form-builder ul").sortable({ opacity: 0.6, cursor: "move"});
					});
				});
			</script>
					<br>
					<input type="submit" value="Submit">
				</form>
				
			</div>
		</div>
		
		
		</section>
		
			
	
		';
	}
}
else {
	header('Location: ./');
}
?>



';









