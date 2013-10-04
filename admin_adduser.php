<?php
require_once('check.php');
//$db contains DB connection
//$username

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
	#let's see if user alredy exists:
	$query = "SELECT user FROM users WHERE user='$username'";
	$result = $db->query($query)->fetch();		
	$result = $result[0];
	if  ($result == "") {		
		#OK
		#let's add user
		$query = "INSERT INTO users (user,password) VALUES ('$username','$password')"  ;
		$db->query($query);
		#let's update permissions table		
		#let's get users file ist	
		$query = "SELECT ID FROM files " ;
		$files = $db->query($query);
		foreach ($files as $file) {
			$query = "INSERT INTO permissions (ID_files,perm,ID_user) VALUES (".$files['ID'].",'false','$user')"  ;
			}
		echo "USE: $username added!";
		} else {
		echo "<b><font color=red>ERROR: User already exists!</font></b>";
		}	
	}

require_once('admin.php');

?>