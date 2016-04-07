<!-- Header -->
			<header id="header" class="alt skel-layers-fixed">
				
				<?php
					require_once('model/Session.php');
					
					$link = array();
					
					// Display's the user's name in the header
					if (isset($_SESSION["credentials"]))
					{
						echo "<h1 style='text-shadow: none;'><img src='images/favicon.ico' alt'icon'>";
						
						if (date('H') < 12)
						{
							echo "Good morning, ";
						}
						else if(date('H') < 16)
						{
							echo "Good afternoon, ";
						}
						else if(date('H') < 24)
						{
							echo "Good evening, ";
						}
						else
							echo "Hello, ";
						
						echo $_SESSION["credentials"]->get_first_name()."</h1>";
						
						switch($_SESSION["credentials"]->get_access_level()) {
							case Session::ADMINISTRATOR:
								$link["./?action=admin_student_manager"] = "Manage Students";
								$link["./?action=admin_teacher_manager"] = "Manage Teachers";
								$link["./?action=admin_class_manager"]   = "Manage Classes";
								break;
							case Session::TEACHER:
								break;
							case Session::STUDENT:
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
								
								foreach ($link as $url => $name) {
									echo "\r\n<li>" .
										 "\r\n    <a href='" . $url . "'";
									echo              preg_match("/http/", $url) == 1 ? " target='_blank'" : "";
									echo          ">" . $name . "</a>" .
										 "\r\n</li>";
								}
							}
							echo '<li><a href="aboutUs.php">About Elite</a></li>';
							
							// Displays the Logout option in the header if logged in
							if (isset($_SESSION["credentials"]))
							{
								echo '<li><a href="./?action=logout">Logout<img src="images/logout.png" alt="logout" style="height: 20px; width: 25px; margin-top: 10px;"></a></li>';
							}
								
						?>
					</ul>
				</nav>
			</header> 
	