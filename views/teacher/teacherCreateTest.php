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
			<a href="http://www.jqueryscript.net/form/jQuery-Plugin-For-Online-Drag-Drop-Form-Builder.html" target="_blank">Form Builder Guide</a>
			<br />
			
			<a href="https://www.easytestmaker.com/Test/165A50DC9CAF43C29332D4E05AB9EB2F#" target="_blank">Doubtful? GoTo</a>
			<br />
			
			<a href="https://jqueryui.com/dialog/#default" target="_blank">JQuery Dialog Boxes</a>
			<br />
			
			<a href="http://botsko.net/Demos/formbuilder/" target="_blank">This Forms Site</a>
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
					<input type="submit" value="Submit (home for now)">
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









