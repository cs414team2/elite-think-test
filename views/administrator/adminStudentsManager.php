<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		require_once('model/Table.php');
		echo '<!-- Main -->
			<script src="controllers/load_student.js"></script>
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
			</section>';
	}
}
?>