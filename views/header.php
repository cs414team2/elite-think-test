<!-- Header -->
			<header id="header" class="alt skel-layers-fixed">
				
				<?php
					// Display's the user's name in the header
					if (isset($_SESSION["credentials"]))
					{
						echo "<h1>Hello ".$_SESSION["credentials"]->get_user_name()."</h1>";
					}
					else
					{
						echo '<h1><a href="../index.php">Elite Team</a></h1>';
					}
						
				?>
				
				<nav id="nav">
					<ul>
						<li><a href="../index.php">Home</a></li>
						<li>
							<a href="" class="icon fa-angle-down">Helpful Links</a>
							<ul>
								<li>
									<a href="bob.php">Old Page</a>
								</li>
								<li>
									<a href="outline.php">Page Outline</a>
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
							// Display's the Logout option in the header if logged in
							if (isset($_SESSION["credentials"]))
							{
								echo '<li><a href="../index.php?action=logout">Logout</a></li>';
							}
								
						?>
					</ul>
				</nav>
			</header> 
	