<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		require_once('model/Table.php');
		echo '<!-- Main -->
			<script src="controllers/load_student.js"></script>
			<script>
				$(document).ready(function(){
					$(#add_student).click(function() {
						var password = $("#password").val();
						var firstname = $("#firstname").val();
						var lastname = $("#lastname").val();
						var email = $("#emailAddress").val();
					
						$.ajax({
							url: "ajax/add_student.php",
							type: "POST",
							data: { password: password,
									firstname: firstname,
									lastname: lastname,
									email: email
								  },
							contentType: application/x-www-form-urlencoded
						});
						
						$("#password").val(\'\');
						$("#firstname").val(\'\');
						$("#lastname").val(\'\');
						$("#emailAddress").val(\'\');
					})
				});
			</script>
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2>Student Manager</h2>
				</header>
				<div class="container">
						
					<!-- Content -->
						<section id="content" class="wrapper style2">
							<h3>This is a list of students</h3>
							<div class="table-wrapper">
								<table>
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Last</th>
											<th>Email</th>
										</tr>
									</thead>
									<tbody>
										<!-- Load all students -->
										';

									$student_table = new Table();
									$student_table->get_table("student");

		echo '						</tbody>
								</table>
							</div>
						</section>
					</div>
					
					<div class="container">
						
						<section id="content" style="text-align:center" class="wrapper style2">
							<h3 align="center">Add a student</h3>
							
							<button class="show_hide" rel="#slidingDiv_2">Add a Student</button><br />
								<div class="add" id="slidingDiv_2" style="display:none"> 					
									<form>
									  First name:<br>
									  <input type="text" name="firstname">
									  Last name:<br>
									  <input type="text" name="lastname">
									  Password:<br>
									  <input type="text" name="password">
									  Email:<br>
									  <input type="text" name="emailAddress">
									 
									  
									  <br />
									  <button class="button special big">Add student</button>
									
									</form>
								</div>
						</section>
								
					</div>
			</section>';
	}
}
?>