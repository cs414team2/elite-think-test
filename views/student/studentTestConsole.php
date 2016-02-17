<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		echo ' ';
	}
}
?>