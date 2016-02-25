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
				
				
				<p>Time Limit on test: </p>
					<input type="number" name="timeLimit">	
			</div>
			<div id="my-form-builder" class="content">
				<form class="questions">
					<h4>Multiple Choice</h4>
					<label for="mcqEntry">Question Entry</label><br />
					<input id="mcqEntry" type="text" name="mcqEntry" class="questionStyle"><br />
					<label for="mcAnswer1">1)</label>
					<input id="mcAnswer1" type="text" name="mcAnswer1" class="questionStyle"><br />
					<label for="mcAnswer2">2)</label>
					<input id="mcAnswer2" type="text" name="mcAnswer2" class="questionStyle"><br />
					<label for="mcAnswer3">3)</label>
					<input id="mcAnswer3" type="text" name="mcAnswer3" class="questionStyle"><br />
					<label for="mcAnswer4">4)</label>
					<input id="mcAnswer4" type="text" name="mcAnswer4" class="questionStyle"><br />
					<button type="button">Submit Question</button>
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









