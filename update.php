<?php 
require_once('check.php');
//$db contains DB connection
//$username

//What I got from POST data:
//$_POST['version']
//$_POST['filename']


if ($_FILES["file"]["error"] > 0) {
	//errors?
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	} else {
	//first of all let's see if user has the downloaded the last version before updating it
	$version = $_POST['version'];
	$filename = $_POST['filename'];	
	//file ID
	$query = "SELECT ID FROM files where filename='" . $filename . "'" ;	
	$row = $db->query($query)->fetch();		
	$file_ID = $row[0];	
	//USER_ID
	$query = "SELECT ID FROM users WHERE user='" . $username . "' ;" ;
	$row = $db->query($query)->fetch();
	$user_ID = $row[0];
	//user version
	$query = "SELECT version FROM versions WHERE file_ID=$file_ID AND user_ID=$user_ID";
	$row = $db->query($query)->fetch();		
	$user_vers = $row[0];
	
	if ($user_vers >= ( $version - 1) ) {
		//retrieve history
		$query = "SELECT history FROM files WHERE ID=$file_ID ";		
		$row = $db->query($query)->fetch();	
		$history = $row[0];
		$history .=  "\n" . ($version + 1) . ", " .  date("Y-M-D") . ", ". $user ;
		//update file version
		$query = "UPDATE files SET version = $version + 1 , lvuf = '$username' , date=date('now')   WHERE ID = $file_ID   " ;		
		$db->query($query);
		//copy old file to backup folder
		rename("files/$filename","files/".$filename."_folder/".$version.$filename);
		//It''s OK
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Stored in: " . $_FILES["file"]["tmp_name"];	
		move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $filename); 
		//let'supdate user version
		$query =  "UPDATE versions SET  file_ID =  $file_ID ,user_ID = $user_ID , version=  $version + 1   WHERE file_ID= $file_ID AND user_ID = $user_ID "    ;
		$result = $db->query($query);
		} else {
		//user version is too old
		echo "<div align=center><font color=red><h3>YOUR VERSION IS TOO OLD, DOWNLOAD THE LAST VERSION BEFORE UPDATING A NEW ONE!</h3></font></div>";
		}
	}
		
require_once('listfiles.php');			
?>


