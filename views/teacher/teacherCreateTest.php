<?php
require_once('model/Teacher.php');

if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		
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
				
				<p>Class:</p>
					<select name="Class" id="Class">
												<option selected="selected" value="null">- Select a Class -</option>';
												$teacher = new Teacher();
												$teacher->get_classes_dropdown($_SESSION['credentials']->get_user_id());
									  echo '</select>

				
				<p>Test Name:</p>
					<input type="value" name="testName">
				
				<p>Time Limit on test: </p>
					<input type="number" name="timeLimit">
					
				
					
			</div>

			
			
			<div id="my-form-builder" class="content">
				
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









