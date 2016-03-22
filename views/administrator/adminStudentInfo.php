<?php
require_once('model/Admin.php');
require_once('model/student.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="courseName">First Name Last Name (ID number) </h2>
					
					
				</header>
				<div class="container" >
						
					<!-- Content -->
						<section >
							<div>Current Classes</div>
							<table class="alt" id="content" style="display: inline; max-width: 50%; float:left;">
								<thead>
									<tr>
										<th>Course #</th>
										<th>Course Name</th>
										
									</tr>
								</thead>
								<tbody>';
								 $student = new student();
								 $student->print_classes($_REQUEST["id"]);
								echo '</tbody>
							</table>											
							
							<div class="row uniform" style="display: inline; max-width: 50%; ">
								
								<div class="12u"style="  position: absolute; top: 25px; right: 25px;" >	
									<div class="select-wrapper">
										<select name="class" id="classSelection" style="float:right">
											<option selected="selected" value="null">- Select a class -</option>
										
										</select>
										<br/> <br/> 
										<button class="big button special" style="float:right" onclick="confirm(Does this Work?)">Add Student</button>
									</div>
								</div>
							</div>						
						</section>
				</div>	
		</section>		
		
		
		
		';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>		