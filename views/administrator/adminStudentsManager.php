<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		require_once('model/Table.php');
		echo '<!-- Main -->
			<script src="controllers/load_student.js"></script>
			<script src="controllers/new_student_form.js"></script>
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Student Manager</h2>
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content">
							<h3>This is a list of students</h3>
							<input type="checkbox" id="copy" name="copy">
							<label for="copy">Show Inactive Classes</label>
							<script type="text/javascript">
								$(document).ready(function(){
									$(".N").hide();
									$("#copy").change(function() {
										if(this.checked) {
											$(".N").show();
										}
										else
											$(".N").hide();
									});
								});
							</script>
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
									<tbody >
										<!-- Load all students -->
										';

									$student_table = new Table();
									$student_table->print_table("student");

		echo '						</tbody>
								</table>
							</div>
						</section>
					</div>
					
					<div class="container">
						
						<section id="content" style="text-align:center">
							<h3 align="center">Add a student</h3>
							
							<button class="show_hide" rel="#slidingDiv_2">Add a Student</button><br />
								<div id="slidingDiv_2" style="display:none"> 					
									<form>
									  First name:<br/>
									  <input type="text" id="firstname" name="firstname" class="inputField">
									  <p id="add_first_err" style="display:none; color: red;">
										First name cannot be blank.
									  </p>
									  Last name:<br/>
									  <input type="text" id="lastname" name="lastname" class="inputField">
									  <p id="add_last_err" style="display:none; color: red;">
										Last name cannot be blank.
											</p>
									  Password:<br/>
									  <input type="password" id="password" name="password" class="inputField">
									  <p id="add_password_err" style="display:none; color: red;">
										Password cannot be blank.
											</p>
									  Email:<br/>
									  <input type="text" id="emailAddress" name="emailAddress" class="inputField">
									  <p id="add_email_err" style="display:none; color: red;">
										Email cannot be blank.
									  </p>
									</form>
									 
									<br />
									<button id="btn_add" name="add_student" class="button special big">Add student</button>
									
								</div>
						</section>
								
					</div>
			</section>';
	}
}
?>