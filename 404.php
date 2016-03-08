<!DOCTYPE html>
<html>

<style>
	body {
			background-image:url(images/404background.jpg);
			background-attachment: fixed;
			background-size: cover;
			padding-top: 20px;
			text-shadow: 0em 0em 0.4em black;
		}
	img {
		-webkit-filter: drop-shadow(5px 5px 5px #222);
		filter: drop-shadow(5px 5px 5px #222);
	}
	a:hover{
		color: yellow;
	}
	h1, h2, a {
		-webkit-transition: all .5s;
		-moz-transition: all .5s;
	    transition: all .5s;
		color: white;
		
	}
</style>

<body>

	<div id="root_img" style="width:100%; height:100%">
		<div id="id_immagine" align="center" style="width: 100%; height: 100%;">
			<img src="images/flicker.gif" alt="404 Bulb" style="width: 20%; height: 20%">
			<h1>Well, this is awkward...</h1>
			<h2>You have a faulty bulb!</h2>
			<h1><a href="index.php">Return Home</a></h1>
		</div>
	</div>

</body>
</html>