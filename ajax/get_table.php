<?php
	// This ajax block takes a table name and prints the table.

	require_once("../model/Table.php");
	if(isset($_REQUEST["table"])) {
		$table = new Table();
		$table->print_table($_REQUEST["table"]);
	}
?>