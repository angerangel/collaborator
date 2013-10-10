<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
#check if there is the POST
if(isset($_POST['submit'])){
	#$_POST contains:
	#file_ID
	#user[ID]
	$ID_file = $_POST['file_ID'];	
	$ID_users = $_POST['user'];	
	#let's set all user permissions for file false
	$query = "UPDATE permissions SET perm='false' WHERE ID_file=".$ID_file ;
	$db->query($query);	
	#let's get users list	
	$query = "SELECT ID FROM users " ;
	$users = $db->query($query);
	foreach ($users as $userid ) {		
		#now we set true only checked users
		if ( isset($ID_users[$userid['ID']])) {
			$query = "UPDATE permissions SET perm='true' WHERE ID_user=". $userid['ID']." AND ID_file=".$ID_file ;
			$db->query($query);	
			} 
		}
	
	}

require_once('admin.php');

?>