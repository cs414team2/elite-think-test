<?php
	require_once('model/Table.php');
?>
<!-- Main -->
<section id="main" class="wrapper style1">
	<header class="major">
		<h2>Student Manager</h2>
	</header>
	<div class="container">
			
		<!-- Content -->
			<section id="content" class="wrapper style1">
				<h3>This is a list of classes</h3>
				<div class="table-wrapper">
							<table>
								<thead>
									<tr>
										<th>Class ID</th>
										<th>Class Number</th>
										<th>Class Name</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$student_table = new Table();
										$student_table->get_table("class");
									?>
								</tbody>
							</table>
						</div>
			</section>
			</div>
		<div class="container">
			<section id="content" style="text-align:center" class="wrapper style1">
				<h3 align="center">Add a Course</h3>
				<form>
				  Course name:<br>
				  <input type="text" name="courseName"><br>
				  Course Number:<br>
				  <input type="text" name="courseNumber">
				  
				  <button class="button big">Add Course</button>
				
				</form>
			</section>
					
	</div>
</section>