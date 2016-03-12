<!-- Header -->
			<header id="header" class="alt skel-layers-fixed">
				
				<?php
					require_once('model/Session.php');
					
					$link = array(
						"http://color.adobe.com" => "Color Picker",
						"elements.html" => "Elements",
						"http://jqueryui.com/" => "jQuery Demos",
						"http://csmain/seproject/TimeMachine2/Student/Summary" => "Time Machine",
						"http://www.jslint.com/" => "JavaScript Validator"
					);
					
					// Display's the user's name in the header
					if (isset($_SESSION["credentials"]))
					{
						echo "<h1 style='text-shadow: none;'>Hello, ".$_SESSION["credentials"]->get_user_name()."</h1>";
						
						switch($_SESSION["credentials"]->get_access_level()) {
							case Session::ADMINISTRATOR:
								$link = array(
									"./?action=admin_student_manager" => "Manage Students",
									"./?action=admin_teacher_manager" => "Manage Teachers",
									"./?action=admin_class_manager" => "Manage Classes"
								);
								break;
							case Session::TEACHER:
								$link = array();
								break;
							case Session::STUDENT:
								$link = array();
								break;
						}
					}
					else
					{
						echo '<h1 style="text-shadow: none;"><a href="index.php">EliteThink</a></h1>';
					}
						
				?>
				<!-- Makes the logo appear on bottom left of every screen. Issue on Test Making page
				<img src="images/eliteicon.png" width="100" height="110" style="margin-top: 42%" alt="elite logo"/>
				-->
				
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<?php
						if (sizeof($link) > 0) {
							echo "
							<li>
								<a href='' class='icon fa-angle-down'>Helpful Links</a>
								<ul>";
							
							foreach ($link as $url => $name) {
								echo "\r\n<li>" .
									 "\r\n    <a href='" . $url . "'";
								echo              preg_match("/http/", $url) == 1 ? " target='_blank'" : "";
								echo          ">" . $name . "</a>" .
									 "\r\n</li>";
							}
							
							echo "
								</ul>
							</li>";
						}
						?>
						<li>
							<a href="https://www.google.com/drive/">Google Drive</a>
						</li>
						<?php
							// Displays the Logout option in the header if logged in
							if (isset($_SESSION["credentials"]))
							{
								echo '<li><a href="./?action=logout">Logout</a></li>';
							}
								
						?>
					</ul>
				</nav>
			</header> 
	