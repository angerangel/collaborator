<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
#$user_ID it's the current user ID

#check if there is the POST
if(isset($_POST['submit'])){
	#$_POST contains:	
	#user[ID]	
	$ID_users = $_POST['user'];	
	#let's set all user admins to false
	$query = "UPDATE admins SET status='false' ";
	$db->query($query);	
	#let's get users list	
	$query = "SELECT ID FROM users " ;
	$users = $db->query($query);
	foreach ($users as $userid ) {	
		#now we set true only checked users
		if ( isset($ID_users[$userid['ID']])) {
			$query = "UPDATE admins SET status='true' WHERE ID=". $userid['ID'] ;
			$db->query($query);				
			} 
		}
	#since nobody can't admin himself, let' set true for the current admin:
	$query = "UPDATE admins SET status='true' WHERE ID=$user_ID" ;
	$db->query($query);	
	echo "<div align=center><b><font color=green>Admins changed!</font></b></div>";
	}

require_once('admin.php');

?>