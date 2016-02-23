<?php
require_once('model/Teacher.php');

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
				
				<p>Class:</p>
					<select name="Teacher" id="Teacher">
												<option selected="selected" value="null">- Select a Teacher -</option>';
												$teacher = new Teacher();
												$teacher->get_classes_dropdown();
									  echo '</select>

				
				<p>Test Name:</p>
					<input type="value" name="testName">
				
				<p>Time Limit on test: </p>
					<input type="number" name="timeLimit">
					
				<button id="create-user">Create new user</button>
					
			</div>

			
			<div id="my-form-builder" class="content">
				<div id="users-contain" class="ui-widget">
					<h1>Existing Users:</h1>
					<table id="users" class="ui-widget ui-widget-content">
						<thead>
							<tr class="ui-widget-header ">
								<th>Name</th>
								<th>Email</th>
								<th>Password</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>John Doe</td>
								<td>john.doe@example.com</td>
								<td>johndoe1</td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>
			
			<div id="dialog-form" title="Create new Question">
				<p class="validateTips">All form fields are required.</p>
				 
				<form>
					<fieldset>
						<label for="name">Name</label>
						<input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
						<label for="email">Email</label>
						<input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
				 
						<!-- Allow form submission with keyboard without duplicating the dialog button -->
						<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
					</fieldset>
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









