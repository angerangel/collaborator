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
	#admin table
	#versions table
	#$_POST contains:
	#user ID	
	$user_ID = $_POST['username'];	
	#a user can't delete himself
	#so we check if user try to delete himself
	$query = "SELECT user FROM users WHERE ID=$user_ID";
	$row = $db->query($query)->fetch();		
	$user_del = $row[0];
	if ($user_del === $user ) {
		echo "<b><font color=red>YOU CAN'T DELETE YOURSELF!</font></b>";
		} else {		
		#USERS table
		$query = "DELETE FROM users WHERE ID=$user_ID  ; ";	
		$db->query($query) ;	
		
		#PERMISSIONS table
		$query = "DELETE FROM permissions WHERE ID_user=$user_ID ;";
		$db->query($query) ;	
		
		#ADMINS table
		$query = "DELETE FROM admins WHERE ID=$user_ID ; ";
		$db->query($query) ;			
		
		#VERSIONS table
		$query = "DELETE FROM versions WHERE user_ID=$user_ID ; ";
		$db->query($query) ;
		
		#
		echo "<div align=center><b><font color=green>User $user_del deleted!</font></b></div>";	
		}	
	}

require_once('admin.php');

?>