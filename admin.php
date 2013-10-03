<?php 
require_once('check.php');
//$db contains DB connection
//$username

//Create list of users
$query = "SELECT ID, user FROM users ORDER BY user" ;
$users = $db->query($query);
//Create list of files
$query = "SELECT ID, filename FROM files ORDER BY filename" ;
$files = $db->query($query);
//creta list of permissions
$query = "SELECT ID_files, ID_user FROM permissions " ;
$perms = $db->query($query);
echo "<div align=center><h1>Adminitration</h1>" ;

foreach ($files as $file) {
	echo "<h2>". $file['filename'] . "</h2>";
	echo "<form action=admin_perm.php method=post >";
	#set the "filename"
	echo "<input type=hidden name=file_ID value=\"" . $file['ID'] ."\" >";
	echo "<table border=1 ><tr><th>Username</th><th>Permission</th></tr>";
	#foreach has a bug, you can't nest it	
	$query = "SELECT ID, user FROM users ORDER BY user" ;
$users = $db->query($query);
	foreach ($users as $user) {		
		echo "<tr><td>" . $user['user']  . "</td>";
		echo "<td><input type=checkbox name=\"user['". $user['ID'] ."']\" ";
		#check if user as permission on this file and flag the check
		$query = "SELECT perm FROM permissions WHERE ID_user=" . $user['ID'] . " AND ID_file=" . $file['ID'] ;
		$row = $db->query($query)->fetch();	
		$result = $row[0];
		if ($result == "true") { echo " checked=checked ";	}
		echo " ></td></tr>";
		}
	echo "</table>";
	}
	
echo "</div >" ;
?>