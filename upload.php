<?php
require_once('check.php');
//$db contains DB connection
//$username

if ($_FILES["file"]["error"] > 0) {
	//errors?
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	} else {
	//let's check if file already exists
	$query = "SELECT filename FROM files WHERE filename='" . $_FILES["file"]["name"] . "' " ;		
	$result = $db->query($query)->fetch();		
	$result = $result[0];
	if  ($result == "") {	

		##UPLOADING
		//It''s OK, let's copy file
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Stored in: " . $_FILES["file"]["tmp_name"];	
		move_uploaded_file($_FILES["file"]["tmp_name"], "files/" . $_FILES["file"]["name"]); 
		//create a folder for older versions
		mkdir("files/" . $_FILES["file"]["name"] . "_folder");
		##END UPLOADING
		
		##MODIFY FILES table
		//create entry in database
		$query = "INSERT INTO files (date,lvuf,history, filename,version) VALUES (date('now'), '$username', '1, '  || date('now') || ', $username' , '" .   $_FILES["file"]["name"] . "', 1 )"  ;		
		$result = $db->query($query);			
		##END MODIFY FILES table
		
		##MODIFY PERMISSIONS table
		#retrieve file ID from databse
		$query = "SELECT ID FROM files where filename='" . $_FILES["file"]["name"] . "'" ;
		$row = $db->query($query)->fetch();		
		$id_file = $row[0];		
		#get users list id
		$query = "SELECT ID FROM users " ;
		$users = $db->query($query);
		#add all users with this file in permissions table		
		foreach ($users as $user) {
			$query = "INSERT INTO permissions (ID_file,ID_user,perm) VALUES ( $id_file, ".$user['ID'].", 'false'  ) ; "    ;
			$db->query($query);
			}				
		//change uploader user permission
		$query = "SELECT ID FROM users WHERE user='" . $username . "' ;" ;
		$row = $db->query($query)->fetch();
		$user_ID = $row[0];		
		$query = "UPDATE permissions SET perm = 'true' WHERE ID_file=$id_file AND ID_user=$user_ID  " ;
		$result = $db->query($query);
		##END MODIFY PERMISSIONS table
		
		##MODIFY VERSIONS table
		#set all users version to 0
		#get users list id
		$query = "SELECT ID FROM users " ;
		$users = $db->query($query);
		foreach ($users as $user) {
			$query = "INSERT INTO versions (file_ID,user_ID, version) VALUES ( $id_file, ".$user['ID'].", 0  ) "    ;
			$db->query($query);
			}
		# set	uploader user version to 1
		$query =  "UPDATE versions SET  version=1  WHERE file_ID=$id_file AND user_ID=$user_ID "    ;
		$db->query($query);

		##END OF VERSIONS table
		
		} else {
		//it already exists
		echo "<div align=center=<b><font color=red >WARNING! File already present</font></div>";		
		}
	}
	
require_once('listfiles.php');	
  
?> 