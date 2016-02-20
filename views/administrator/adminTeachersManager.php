<?php
require_once('model/Table.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<script src="controllers/toggle_active.js"></script>
			<script src="controllers/new_teacher_form.js"></script>
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content">
						<h3>This is a list of Teachers</h3>
						<input type="checkbox" id="copy" name="copy">
						<label for="copy">Show Inactive Teachers</label>
						<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>ID</th>
												<th>Password</th>
												<th>Email</th>
												<th>First</th>
												<th>Last</th>
											</tr>
										</thead>
										<tbody>';
											$teacher_table = new Table();
											$teacher_table->print_table("teacher");
								  echo '</tbody>
									</table>
								</div>
					</section>
					</div>
					
				<div class="container">
					<section id="content" style="text-align:center">
						<h3 align="center">Add a Teacher</h3>
						<button id="addButton" class="show_hide" rel="#slidingDiv_2">Add a Teacher</button><br />
							<div id="slidingDiv_2" style="display:none"> 	
								<form>
								  <br />
								  <h4>First name: </h4>
								  <input type="text" id="first_name" "name="first_name" class="input_field" maxlength="45">
								  <p id="err_first_name" style="display:none; color: red;">
									First name cannot be blank.
								  </p>
								  
								  <br />
								  <h4>Last name: </h4>
								  <input type="text" id="last_name" name="last_name" class="input_field" maxlength="45">
								  <p id="err_last_name" style="display:none; color: red;">
									Last name cannot be blank.
								  </p>
								  
								  <br />
								  <h4>Password:</h4>
								  <input type="text" id="password" name="password" class="input_field" maxlength="45">
								  <p id="err_password" style="display:none; color: red;">
									Password cannot be blank.
								  </p>
								  
								  <br />
								  <h4>Email:</h4>
								  <input type="text" id="email" name="email" class="input_field" maxlength="45">
								  <p id="err_email" style="display:none; color: red;">
									Email cannot be blank.
								  </p>
								  
								  <br />
								
								</form>
								<button id="btn_add" class="button special big">Add Teacher</button>
							</div>
					</section>
							
			</div>
		</section>';
	}
}
else {
	header('Location: ./');
}
?>