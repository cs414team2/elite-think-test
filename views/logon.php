<!-- Banner -->
<section id="banner">
	<div class="inner">
		<img src="images/elitelogo.png" width="200" height="230" alt="elite logo"/>
		<p>On-line Testing Application</p>
		<ul class="actions">
			<li><a id="loginButton" href="#one" class="button big scrolly">Login</a></li>
		</ul>
	</div>
</section>

<script>
// JavaScript to delay button click focus on insert form
document.getElementById('loginButton').onclick = function() {
	
	setTimeout(function() {
		document.getElementById('usernameEntry').focus();
	    }, 1000);
};
</script>

<section id="one" name="one" class="wrapper style1">
	<div class="container">
		<header class="major">
			<h2>Enter Your Information</h2>
			<form method="post" action="index.php#one">
				<h4>User name:</h4>
				<input id="usernameEntry" type="text" name="username">
				<br><h4>Password:</h4>
				<input type="password" name="password">
				<br />
				<input class="button special big" name="senddata" type="submit" value="Login">
				<input type="hidden" name="action" value="login" />
				<br />
				<br />
				<p id="logon_fail_message" style="display:none; color: red;">Incorrect username or password.</p>
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
					<h3>Management Features</h3>
					<p>Create, manage, and update exams to your liking. You are in full control of your abilities.</p>
				</section>
			</div>
			<div class="4u 6u$(2) 12u$(3)">
				<section class="feature fa-code">
					<h3>Strictly Online</h3>
					<p>No paperwork necessary. Log in, navigate to a test, and meet personal goals.</p>
				</section>
			</div>
			<div class="4u$ 6u(2) 12u$(3)">
				<section class="feature fa-save">
					<h3>Save Your Work</h3>
					<p>Your account is accessible on most devices. Log in from around the world!</p>
				</section>
			</div>
			<div class="4u 6u$(2) 12u$(3)">
				<section class="feature fa-desktop">
					<h3>On-line Instructions</h3>
					<p>Simple online services keep the style as simple as possible.</p>
				</section>
			</div>
			<div class="4u 6u(2) 12u$(3)">
				<section class="feature fa-camera-retro">
					<h3>Instant Updating</h3>
					<p>The Elite Team are constantly updating the website to meet the highest expectations for our users.</p>
				</section>
			</div>
			<div class="4u$ 6u$(2) 12u$(3)">
				<section class="feature fa-cog">
					<h3>Constant Feedback</h3>
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
		<li><a href="#one" class="button big">Get Started</a></li>
	</ul>
</section>