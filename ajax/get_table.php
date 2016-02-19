<?php
	require_once("../model/Table.php");
	if(isset($_REQUEST["table"])) {
		$table = new Table();
		$table->get_table($_REQUEST["table"]);
	}
?>