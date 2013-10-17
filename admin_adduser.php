<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
# $user_ID

#check if there is the POST
if(isset($_POST['submit'])){
	#we must update
	#users table
	#permissions table
	#admins table
	#versions table
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
		
		##USERS table
		$query = "INSERT INTO users (user,password) VALUES ('$username','$password')"  ;
		$db->query($query);
		##END USERS table
		
		##PERMISSION table
		#let's get new user ID
		$query = "SELECT ID FROM users WHERE user='$username' " ;
		$result = $db->query($query)->fetch();		
		$ID_user = $result[0];
		#let's update permissions table		
		#let's get file ist	
		$query = "SELECT ID FROM files " ;
		$files = $db->query($query);
		foreach ($files as $file) {
			$query = "INSERT INTO permissions (ID_file,perm,ID_user) VALUES (".$file['ID'].",'false',$ID_user) ;"  ;
			$db->query($query);			
			}
		##END PERMISSION table
		
		##ADMIN table
		#let's update admin table
		$query = "INSERT INTO admins (ID,status) VALUES ($ID_user,'false')"  ;
		$db->query($query);
		##END ADMIN table
		
		
		##VERSION table
		$query = "SELECT ID FROM files " ;
		$files = $db->query($query);
		foreach ($files as $file) {
			$query = "INSERT INTO versions (file_ID,user_ID,version) VALUES (".$file['ID'].",$ID_user,0)"  ;
			$db->query($query);
			}
		##END VERSION table
		
		
		echo "<div align=center><b><font color=green>USER: $username added!</font></b></div>";
		} else {
		echo "<b><font color=red>ERROR: User already exists!</font></b></div>";
		}	
	}

require_once('admin.php');

?>