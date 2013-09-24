<?php
require_once('check.php');
//$db contains DB connection
//$username
//
?>
<div align=center >
<h1>LIST OF FILES</h1>

<?PHP 
echo "User: " . $username ;
?> 

<table border=1 >
<tr><th>FILE</th><th>VERSION</th><th>DATE</th><th>FROM</th><th>Upload New Version</th></tr>

<?PHP 
$query = "SELECT ID FROM users WHERE user='" . $username . "' ;" ;
$row = $db->query($query)->fetch();
$user_ID = $row[0];
$query = "SELECT filename,version,date,lvuf FROM files WHERE ID IN ( SELECT ID_file FROM permissions WHERE ID_user=" . $user_ID . " ) ; ";
foreach ($db->query($query) as $row) { 
	echo "<tr><td>" . $row['filename'] . "</td><td>" .$row['version']."</td><td>". $row['date']."</td><td>".$row['lvuf']."</td><td>upload new version</td></tr>";
	}
?>

</table>
<h2>Add a file:</h2>
<form enctype="multipart/form-data" action=upload.php  method=post >
Send this file: <input name="file" type="file" >
    <input type="submit" value="Send File" >
</form>
</div>