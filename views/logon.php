<?php
if(isset($_SESSION["logon_failed"])) {
	if($_SESSION["logon_failed"] == true) {
		$_SESSION["logon_failed"] = false;
		echo "<script type='text/javascript'>
			 $(document).ready(function(){
				 $('#logon_fail_message').show(600);
			 });
			 </script>";
	}
}	
?>

<section id="one" name="one" class="wrapper style1">
	<div class="container">
		<header class="major">
			<img src="images/eliteicon.png" width="20%" height="25%" alt="elite logo"/>
			<h3>EliteThink</h3>
			<form method="post" action="redirect.php">
				<h3>User name:</h3>
				<input id="usernameEntry" type="text" name="username" maxlength="45" autofocus>
				<br><h3>Password:</h3>
				<input type="password" name="password" maxlength="45">
				<br />
				<input class="button special big" name="senddata" type="submit" value="Login">
				<input type="hidden" name="action" value="login" />
				<br />
				<br />
				<p id="logon_fail_message" style="display:none; color: red;">Incorrect username or password.</p>
				<br />
				<br />
				<br />
				<br />
			</form>
		</header>
	</div>
</section>

<!-- Two -->
<section id="two" class="wrapper style2">
	<div class="container">
		<div class="row uniform">
			<div class="4u 6u(2) 12u$(3)">
				<section class="feature fa-briefcase">
					<h4>Management Features</h4>
					<p>Create, manage, and update exams to your liking. You are in full control of your abilities.</p>
				</section>
			</div>
			<div class="4u 6u$(2) 12u$(3)">
				<section class="feature fa-code">
					<h4>Strictly Online</h4>
					<p>No paperwork necessary. Log in, navigate to a test, and meet personal goals.</p>
				</section>
			</div>
			<div class="4u$ 6u(2) 12u$(3)">
				<section class="feature fa-save">
					<h4>Save Your Work</h4>
					<p>Your account is accessible on most devices and browsers. Log in at any time!</p>
				</section>
			</div>
			<div class="4u 6u$(2) 12u$(3)">
				<section class="feature fa-desktop">
					<h4>On-line Instructions</h4>
					<p>Simple online services keep the style as simple and usable as possible.</p>
				</section>
			</div>
			<div class="4u 6u(2) 12u$(3)">
				<section class="feature fa-camera-retro">
					<h4>Instant Updating</h4>
					<p>The Elite Team are constantly updating the website to meet the highest expectations for our users.</p>
				</section>
			</div>
			<div class="4u$ 6u$(2) 12u$(3)">
				<section class="feature fa-cog">
					<h4>Constant Feedback</h4>
					<p>See your scores and view your progress as you take an exam.</p>
				</section>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section id="cta" class="wrapper style3">
	<h2>Are you ready to go?</h2>
	<ul class="actions">
		<li><a id="loginButton" href="#one" class="button big scrolly">Get Started</a></li>
	</ul>
</section>

<script>
// JavaScript to delay button click focus on insert form
document.getElementById('loginButton').onclick = function() {
	
	setTimeout(function() {
		document.getElementById('usernameEntry').focus();
	    }, 1000);
};
</script>