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
												<th>Course Number</th>
												<th>Course Name</th>
												
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
						
						<a href="#" class="show_hide" rel="#slidingDiv_2">Add a Course</a><br />
						<div id="slidingDiv_2">
						<form>
						  Course name:<br />
						  <input type="text" name="courseName">
						  Course Number:<br />
						  <input type="text" name="courseNumber">
						  
										<div class="row uniform">
											<div class="12u">
												<div class="select-wrapper">
													<select name="Teacher" id="Teacher">
														<option value="">- Teacher -</option>
													</select>
												</div>
											</div>
										</div>

						  
						  <br />
						  <button class="button special big">Add Course</button>
						
						</form>
						</div>
					</section>
							
			</div>
		</section>';
	}
}
?>