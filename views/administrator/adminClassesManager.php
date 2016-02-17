<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Class Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content" class="wrapper style2">
						<h3>This is a list of Classes</h3>
						<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>First</th>
												<th>Last</th>
												<th>Email</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
					</section>
					</div>
				<div class="container">
					<section id="content" style="text-align:center" class="wrapper style2">
						<h3 align="center">Add a Course</h3>
						<form>
						  Course name:<br />
						  <input type="text" name="courseName">
						  Course Number:<br />
						  <input type="text" name="courseNumber">
						  
						  <br />
						  <button class="button special big">Add Course</button>
						
						</form>
					</section>
							
			</div>
		</section>';
	}
}
?>