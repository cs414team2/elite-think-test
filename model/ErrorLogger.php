<?php
class ErrorLogger {
	const LOG_FILE_PATH = '../../Team02/Logs/Log.dat';
	
	public function __construct($error) {
		$log_file = fopen(self::LOG_FILE_PATH, 'a');
		
		fwrite($log_file, "\r\n" . date("F j, Y, g:i a") . " - " . $error);
		fclose($log_file);
	}
}
?>