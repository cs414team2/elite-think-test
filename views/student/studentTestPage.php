<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		echo ' ';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>