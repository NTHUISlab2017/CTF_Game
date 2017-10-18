<?php
	if($_POST){

		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: application' ); 
		header("Content-Disposition: attachment; filename=造型.txt");
		readfile("admin/file/造型.txt");
	}

?>