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
	$userID = $_POST['userID'];	
	$password = $_POST['password'];	
	#let's modify user password
	$query = "UPDATE users SET password='$password' WHERE ID=$userID";
	$db->query($query);
	$query = "SELECT user FROM users WHERE ID=$userID";
	$row = $db->query($query)->fetch();	
	$username = $row[0];
	echo "<div align=center><b><font color=green>Changed password for $username</font></b></div>";	
	}
	
require_once('admin.php');

?>	