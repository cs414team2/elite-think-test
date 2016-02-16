<?php
	require_once('model/Table.php');
?>
<script src="controllers/load_student.js"></script>
<!-- Main -->
<section id="main" class="wrapper style1">
	<header class="major">
		<h2>Student Manager</h2>
	</header>
	<div class="container">
			
		<!-- Content -->
			<section id="content" class="wrapper style1">
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
									<?php
										$student_table = new Table();
										$student_table->get_table("student");
									?>
								</tbody>
							</table>
						</div>
			</section>
			</div>
			<div class="container">
			
			<section id="content" style="text-align:center" class="wrapper style1">
				<h3 align="center">Add a student</h3>
				<form>
				  First name:<br>
				  <input type="text" name="firstname"><br>
				  Last name:<br>
				  <input type="text" name="lastname">
				  Password:<br>
				  <input type="text" name="password">
				  Email:<br>
				  <input type="text" name="emailAddress">
				  
				  <button class="button big">Add student</button>
				
				</form>
			</section>
					
	</div>
</section>
