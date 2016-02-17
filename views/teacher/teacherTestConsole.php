<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo ' ';
	}
}
?>