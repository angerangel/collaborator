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
		#now we can remove user
		$query = "DELETE FROM users WHERE ID=$user_ID  ; ";		
		#now we must delete user from permissions table
		$query .= "DELETE FROM pemissions WHERE ID_user=$user_ID ;";
		#now we must delete user from admins table
		$query .= "DELETE FROM admins WHERE ID=$user_ID ; ";
		# now we execute the query
		$db->query($query) ;	
		}
	}

require_once('admin.php');

?>