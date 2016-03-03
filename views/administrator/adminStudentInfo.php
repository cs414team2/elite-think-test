<?php
require_once('model/Admin.php');
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_admin()) {
		echo'
			<section id="main" class="wrapper style1">
				<header class="major">
					<h2 id="courseName">Student Name (ID number) </h2>
					
					
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
								<tbody>
								</tbody>
							</table>					
							
							
							
							<div class="row uniform"display: inline; max-width: 50%; ">
								<h3style=" float:right; position: absolute; top: 25px; right: 25px;" >Add this student</h3>
								<div class="12u"style="  position: absolute; top: 25px; right: 25px;" >	
									<div class="select-wrapper">			
										<select name="class" id="classSelection" style="float:right">
											<option selected="selected" value="null">- Select a Class -</option>
										
										</select>
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