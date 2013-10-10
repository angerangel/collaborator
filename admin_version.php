<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
#$user_ID it's the current user ID

if(isset($_POST['submit'])){
	#we have from PST data:
	$ID_file = $_POST['fileID'];
	$version = $_POST['version'];
	#get file name
	$query = "SELECT filename FROM files WHERE ID=$ID_file";
	$filename = $db->query($query)->fetch();	
	$filename = $filename[0];
	#change current file
	copy("files/".$filename."_folder/".$version.$filename , "files/$filename");
	#now we change current version:
	$query = "UPDATE files SET version=$version, lvuf='$username' WHERE ID=$ID_file ";	
	$db->query($query);
	
	
	}

require_once('admin.php');

?>	