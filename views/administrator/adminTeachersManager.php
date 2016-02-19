<?php
require_once('model/Table.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Teacher Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content">
						<h3>This is a list of Teachers</h3>
						<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>First</th>
												<th>Last</th>
												<th>Email</th>
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
						<button class="show_hide" rel="#slidingDiv_2">Add a Teacher</button><br />
							<div id="slidingDiv_2" style="display:none"> 	
								<form>
								  <br />
								  <h4>Teacher name: </h4>
								  <input type="text" name="teacherName"><br>
								  <h4>Course(s) Taught:</h4>
								  <input type="text" name="courseNumber">
								  <br />
								  <button class="button special big">Add Teacher</button>
								
								</form>
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