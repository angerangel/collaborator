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
	//starting table row
	$line = "<tr>";
	//filename
	$line .= "<td><form  action=download.php  method=post ><input type=hidden name=version value=".$row['version'] ."><input type=hidden name=filename value=\"". $row['filename']."\"> <input type=submit name=submit value=\"". $row['filename'] ."\" ></form></td>";
	//version
	$line .= "<td>" .$row['version']."</td>";
	//date
	$line .= "<td>". $row['date']."</td>";
	//last version updated from user
	$line .= "<td>".$row['lvuf']."</td>" ;
	//upload a new version buttom
	$line .= "<td><form enctype=\"multipart/form-data\" action=update.php  method=post ><input name=version type=hidden value=".$row['version'] ."><input type=hidden name=filename value=\"". $row['filename']."\"><input name=file type=file ><input type=submit name=submit value=UPDATE ></form></td>";
	//ending table row
	$line.= "</tr>";
	//write all
	echo $line;
	}
?>

</table>
<hr>
<h2>Add a file:</h2>
<form enctype="multipart/form-data" action=upload.php  method=post >
Send this file: <input name="file" type="file" > <br>
    <input type="submit" value="Send File" >
</form>

<hr>

<a href=admin.php >Administration </a>
</div>
