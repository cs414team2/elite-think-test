<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		require_once('model/Table.php');
		echo '<!-- Main -->
			<script src="controllers/new_student_form.js"></script>
			<script src="controllers/toggle_active.js"></script>
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Student Manager</h2>
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content">
							<h3>This is a list of students</h3>
							<input type="checkbox" id="copy" name="copy">
							<label for="copy">Show Inactive Students</label>
							<div class="table-wrapper">
								<table>
									<thead>
										<tr>
											<th>ID</th>
											<th>Password</th>
											<th>Name</th>
											<th>Last</th>
											<th>Email</th>
										</tr>
									</thead>
									<tbody id="tbl_students">
										<tr>
											<td colspan="5" style="text-align: center;">
												Students Loading...
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>
					</div>
					
					<div class="container">
						
						<section id="content" style="text-align:center">
							<button class="show_hide" rel="#slidingDiv_2">Add a Student</button><br />
								<div id="slidingDiv_2" style="display:none"> 					
									<form>
									<br/>
									  <b>First name:</b>
									  <input type="text" id="firstname" name="firstname" class="inputField" maxlength="45" placeholder="Joe">
									  <p id="add_first_err" style="display:none; color: red;">
										First name cannot be blank.
									  </p>
									  <b>Last name:</b>
									  <input type="text" id="lastname" name="lastname" class="inputField" maxlength="45" placeholder="Smith">
									  <p id="add_last_err" style="display:none; color: red;">
										Last name cannot be blank.
											</p>
									  <b>Password:</b>
									  <input type="password" id="password" name="password" class="inputField" maxlength="45" placeholder="Password">
									  <p id="add_password_err" style="display:none; color: red;">
										Password cannot be blank.
											</p>
									  <b>Email:</b>
									  <input id="emailAddress" name="emailAddress" class="inputField"
										type="text" maxlength="45" placeholder="joe.smith@gmail.com">
									  <p id="add_email_err" style="display:none; color: red;">
										Email cannot be blank.
									  </p>
									</form>
									 
									<button id="btn_add" name="add_student" class="button special big">Submit</button>
									
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