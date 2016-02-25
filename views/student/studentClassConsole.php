<?php
if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_student()) {
		// PUT HTML HERE!
		echo '

				<h3>This is a page</h3>
			




		';
	}
}
else {
	header('Location: ./');
}
?>