<?php
require_once('check.php');
//$db contains DB connection
//$username

if ($_FILES["file"]["error"] > 0) {
	//errors?
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	} else {
	//let's check if file already exists
	$query = "SELECT filename FROM files WHERE user='" . $_FILES["file"]["name"] . "' ;" ;	
	$result = $db->query($query);	
	if  ($result == false ) {
		//It''s OK
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Stored in: " . $_FILES["file"]["tmp_name"];	
		move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $_FILES["file"]["name"]); 
		//create a folder for older versions
		mkdir($_FILES["file"]["name"] . "_folder");
		//create entry in database
		$query = "INSERT INTO files (date,lvuf,history, filename,version) VALUES (date('now'), $username, '1,'  || date('now') || ', $username' , '" .   $_FILES["file"]["name"] . "', 1 )"  ;		
		$result = $db->query($query);	
		$query = "SELECT ID FROM files where filename='" . $_FILES["file"]["name"] "'" ;
		$row = $db->query($query)->fetch();
		$id_file = $row[0];
		$query = "SELECT ID FROM users WHERE user='" . $username . "' ;" ;
		$row = $db->query($query)->fetch();
		$user_ID = $row[0];
		$query = "INSERT INTO permissions (id_file,id_user) VALUES ( $id_file, $user_ID  )"    ;
		} else {
		//it already exists
		echo "WARNING! File already present<br>";		
		}
	}
	
	
  
?> 