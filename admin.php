<?php 
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');

//Create list of users
$query = "SELECT ID, user FROM users ORDER BY user" ;
$users = $db->query($query);
//Create list of files
$query = "SELECT ID, filename, version FROM files ORDER BY filename" ;
$files = $db->query($query);
//creta list of permissions
$query = "SELECT ID_files, ID_user FROM permissions " ;
$perms = $db->query($query); 
?>
<div align=center>
<h1>Administration</h1>
<a href=#files >Files</a> - <a href=#users >Users</a> - 
<a href=listfiles.php >Go back to file list</a>

<?php
echo "<hr><h2><a name=files>Files</a></h2>" ;
foreach ($files as $file) {
	echo "\n<h3>". $file['filename'] . "</h3>";
	#permissions
	echo "\n<h4>Permissions</h4>";
	echo "\n<form action=admin_perm.php method=post >";
	#set the "filename"
	echo "<input type=hidden name=file_ID value=\"" . $file['ID'] ."\" >";
	echo "\n<table border=1 ><tr><th>Username</th><th>Permission</th></tr>";
	#foreach has a bug, you can't nest it	
	$query = "SELECT ID, user FROM users ORDER BY user" ;
	$users = $db->query($query);
	foreach ($users as $user) {		
		echo "\n<tr><td>" . $user['user']  . "</td>";
		echo "<td><input type=checkbox name=\"user[". $user['ID'] ."]\" ";
		#check if user as permission on this file and flag the check
		$query = "SELECT perm FROM permissions WHERE ID_user=" . $user['ID'] . " AND ID_file=" . $file['ID'] ;
		$row = $db->query($query)->fetch();	
		$result = $row[0];
		if ($result == "true") { echo " checked=checked ";	}
		echo " ></td></tr>";
		}
	echo "\n</table>";
	echo "\n<input type=submit name=submit value=\"Set permissions\"></form>";
	#versions
	echo "\n<h4>Version</h4>";
	echo "\n<form action=admin_version.php method=post >";
	echo "\n<input type=hidden name=fileID value=".$file['ID']." >";
	echo "\n<select name=version >";
	for ($n = $file['version']; $n > 0; $n--) {
		echo "<option value=$n >$n</option>" ;
		}
	echo "\n<input type=submit name=submit value=\"Change current version\" ></form>";
	
	}
	
echo "<hr><h2><a name=users>Users</a></h2>" ;
echo "<h3>Add an user</h3>" ;
?>
<form action=admin_adduser.php method=post >
<table border=0 >
<tr><td>User name: </td><td><input type=text name=username></td></tr>
<tr><td>Password:</td><td> <input type=password name=password></td></tr>
</table>
<input type=submit name=submit value="Add user">
</form>
<h3>Modify user password</h3>
<form action=admin_moduser.php method=post >
<table border=0 >
<tr><td>User name: </td><td><input type=text name=username></td></tr>
<tr><td>Password: </td><td><input type=password name=password></td></tr>
</table>
<input type=submit name=submit value="Modify password">
</form>

<h3>Delete an user</h3>
<form action=admin_deluser.php method=post >
User name: <select name=username >

<?php 
$query = "SELECT user,ID FROM users ORDER BY user" ;
$users = $db->query($query);
foreach ($users as $user) {	
	echo "<option value=".$user['ID']." >".$user['user']."</option>";
	}
?>
</select>
<input type=submit name=submit value="Delete user">
</form>

<h3>Administrator</h3>

<form action=admin_admins.php method=post>
<table border=1>
<tr><th>User</th><th>Administrators</th></tr>
<?php
$query="SELECT users.id,users.user,admins.status FROM users, admins WHERE users.id=admins.id ORDER BY users.user ";
$users = $db->query($query);
foreach ($users as $user) {
	echo "\n<tr><td>".$user['user']."</td><td><input type=checkbox name=\"user[". $user['ID'] ."]\" ";
	if ($user['status'] == "true") { echo " checked=checked ";	}
	echo " ></td></tr>";
	}
?>
</table>
<input type=submit name=submit value="Change administrators">
</form>
</div>