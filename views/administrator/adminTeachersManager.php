<?php
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
						<h4>This is a list of Teachers</h4>
						<input type="checkbox" id="copy" name="copy">
						<label for="copy">Show Inactive Teachers</label>
						<div class="table-wrapper">
									<table class="sortable">
										<thead>
											<tr>
												<th>ID</th>
												<th>First</th>
												<th>Last</th>
												<th>Email</th>
												<th>Password</th>
											</tr>
										</thead>
										<tbody id="tbl_teachers">
											<tr>
												<td colspan="5" style="text-align: center;">
													<div class="loader">Loading...</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
					</section>
					</div>
					
				<div class="container">
					<section id="content" style="text-align:center; ">
						<button id="addButton" class="show_hide" rel="#slidingDiv_2">Add a Teacher</button><br />
							<div id="slidingDiv_2" style="display:none"> 	
								<form>
								  <b>First name: </b>
								  <input type="text" id="first_name" "name="first_name" class="input_field" maxlength="45" placeholder="Joe">
								  <p id="err_first_name" style="display:none; color: red;">
									First name cannot be blank.
								  </p>
								  
								  <b>Last name: </b>
								  <input type="text" id="last_name" name="last_name" class="input_field" maxlength="45" placeholder="Smith">
								  <p id="err_last_name" style="display:none; color: red;">
									Last name cannot be blank.
								  </p>
								  
								  <b>Password:</b>
								  <input type="password" id="password" name="password" class="input_field" maxlength="45" placeholder="Password">
								  <p id="err_password" style="display:none; color: red;">
									Password cannot be blank.
								  </p>
								  
								  <b>Email:</b>
								  <input type="text" id="email" name="email" class="input_field" maxlength="45" placeholder="joe.smith@gmail.com">
								  <p id="err_email" style="display:none; color: red;">
									Email cannot be blank.
								  </p>
								
								</form>
								<br />
								<button id="btn_add" class="button special big">Submit</button>
							</div>
					</section>
							
			</div>
		</section>';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>