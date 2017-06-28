<?php
session_start();
$dsn='mysql:dbname=ctf;host=localhost';
$user='ctf';
$password='ctf';
try{
	$db=new PDO($dsn,$user,$password);
	$db->exec("set names utf8");
}
catch(PDOException $e){
	die($e->getMessage());
}
?>
