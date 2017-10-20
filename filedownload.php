<?php
	
		$dir='./admin/'.(string)$_GET['probid'];
		$file_name = $_GET['file_name'];
		
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: application/octet-stream');	 
		header("Content-Disposition: attachment; filename=$file_name");
		readfile("$dir/$file_name");

?>