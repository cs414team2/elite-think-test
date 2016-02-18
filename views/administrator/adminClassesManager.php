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
						var course_name = $("#courseName").val();
						var course_number = $("#courseNumber").val();
						var teacher_id = $("#Teacher").val();
						var validated = true;
						
						if (jQuery.trim(course_name).length <= 0) {
							$("#add_course_name_err").show();
							validated = false;
						}
						if (jQuery.trim(course_number).length <= 0) {
							$("#add_course_number_err").show();
							validated = false;
						}
						
						if (validated) {
							$.ajax({
								url: "ajax/add_class.php",
								type: "POST",
								data: { course_name: course_name,
										course_number: course_number,
										teacher_id: teacher_id
									  }
							});
							
							$("#courseName").val(\'\');
							$("#courseNumber").val(\'\');
							$("#Teacher").val(\'\');
							
							location.href = "./?action=admin_class_manager";
						}
						
					});
					
					$("#courseName").keypress(function(){
						$("#add_course_name_err").hide();
					});
					$("#courseNumber").keypress(function(){
						$("#add_course_number_err").hide();
					});
				});
			</script>
			<section id="main" class="wrapper style1">
			<header class="major">
				<h2>Class Manager</h2>
			</header>
			<div class="container">
					
				<!-- Content -->
					<section id="content" >
						<h3>This is a list of Classes</h3>
						<div class="table-wrapper">
									<table>
										<thead>
											<tr>
												<th>Course Id</th>
												<th>Course Number</th>
												<th>Course Name</th>
												<th>Teacher Id</th>
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
					<section id="content" style="text-align:center">
						<h3 align="center">Add a Course</h3>
						<a href="#" class="show_hide" rel="#slidingDiv_2">Add a Course</a><br />
						<div id="slidingDiv_2" style="display:none">
							<form>
								Course name:<br />
								<input type="text" id="courseName" name="courseName" class="inputField">
								<p id="add_course_name_err" style="display:none; color: red;">
									Course name cannot be blank.
								</p>
								Course Number:<br />
								<input type="text" id="courseNumber" name="courseNumber" class="inputField">
								<p id="add_course_number_err" style="display:none; color: red;">
									Course number cannot be blank.
								</p>
								<br />
							  
								<div class="row uniform">
									<div class="12u">
										<div class="select-wrapper">
											<select name="Teacher" id="Teacher">
												<option selected="selected" value="null">- Select a Teacher -</option>';
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