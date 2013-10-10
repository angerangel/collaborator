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
	#admins table
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
		#let's get new user ID
		$query = "SELECT ID FROM from users WHERE user='$username' " ;
		$result = $db->query($query)->fetch();		
		$ID_user = $result[0];
		#let's update permissions table		
		#let's get file ist	
		$query = "SELECT ID FROM files " ;
		$files = $db->query($query);
		foreach ($files as $file) {
			$query = "INSERT INTO permissions (ID_files,perm,ID_user) VALUES (".$file['ID'].",'false',$ID_user)"  ;
			$db->query($query);
			}
		#let's update admin table
		$query = "INSERT INTO admins (ID,status) VALUES ($ID_user,'false')"  ;
		$db->query($query);
		echo "USER: $username added!";
		} else {
		echo "<b><font color=red>ERROR: User already exists!</font></b>";
		}	
	}

require_once('admin.php');

?>