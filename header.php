<!-- Header -->
			<header id="header" class="alt skel-layers-fixed">
				
				<?php
					// Display's the user's name in the header
					if (isset($_SESSION["credentials"]))
					{
						echo "<h1 style='text-shadow: none;'>Hello, ".$_SESSION["credentials"]->get_user_name()."</h1>";
					}
					else
					{
						echo '<h1 style="text-shadow: none;"><a href="index.php">Elite Team</a></h1>';
					}
						
				?>
				<!-- Makes the logo appear on bottom left of every screen. Issue on Test Making page
				<img src="images/eliteicon.png" width="100" height="110" style="margin-top: 42%" alt="elite logo"/>
				-->
				
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li>
							<a href="" class="icon fa-angle-down">Helpful Links</a>
							<ul>
								<li>
									<a href="http://color.adobe.com">Color Picker</a>
								</li>
								<li>
									<a href="elements.html">Elements</a>
								</li>
								<li>
									<a href="http://jqueryui.com/">jQuery Demos</a>
								</li>
								<li>
									<a href="http://csmain/seproject/TimeMachine2/Student/Summary">Time Machine</a>
								</li>
								<li>
									<a href="http://www.jslint.com/">JavaScript Validator</a>
								</li>								
							</ul>
						</li>
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
	