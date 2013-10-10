<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
#check if there is the POST
if(isset($_POST['submit'])){
	#we must update
	#users table
	#permissions table
	#$_POST contains:
	#username
	#password
	$username = $_POST['username'];	
	$password = $_POST['password'];	
	#let's modify user password
	$query = "UPDATE users SET password='$password' WHERE user='$user'";
	$db->query($query);
	}
	
require_once('admin.php');

?>	