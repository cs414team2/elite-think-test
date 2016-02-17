<?php
require_once('model/Table.php');
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'<!-- Main -->
			<script>
				$(document).ready(function(){
					$(".inputField").keypress(function(e){
					  if(e.keyCode==13)
					  $("#btn_add").click();
					});
				
					$("#btn_add").click(function() {
						// ADD STUFF HERE!
					});
				});
			</script>
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
												<th>Course Id</th>
												<th>Course Number</th>
												<th>Course Name</th>
												
											</tr>
										</thead>
										<tbody>';
											$student_table = new Table();
											$student_table->get_table("class");
									echo '</tbody>
									</table>
								</div>
					</section>
					</div>
				<div class="container">
					<section id="content" style="text-align:center" class="wrapper style2">			
						<a href="#" class="show_hide" rel="#slidingDiv_2">Add a Course</a><br />
						<div id="slidingDiv_2" style="display:none">
							<form>
								Course name:<br />
								<input type="text" name="courseName" class="inputField">
								Course Number:<br />
								<input type="text" name="courseNumber" class="inputField"> <br />
							  
								<div class="row uniform">
									<div class="12u">
										<div class="select-wrapper">
											<select name="Teacher" id="Teacher" class="inputField">
												<option selected="selected" value="0">- Select a Teacher -</option>';
												$admin = new Admin();
												$admin->get_teachers();
									  echo '</select>
										</div>
									</div>
								</div>

							  
							  <br />
							  <button type="button" id="btn_add" class="button special big">Add Course</button>
							
							</form>
						</div>
					</section>
			</div>
		</section>';
	}
}
?>