<?php
require_once('check.php');
//$db contains DB connection
//$username
require_once('check_adm.php');
# $user_ID

#we must update 
#files table
#versions table
#permissions table



if(isset($_POST['submit'])){
	$ID_file = $_POST['ID_file'];
	$query = "SELECT filename FROM files WHERE id=$ID_file";
	$row = $db->query($query)->fetch();	
	$filename = $row[0];
	$query = "DELETE FROM files WHERE ID=$ID_file  ; ";	
	$db->query($query) ;	
	$query = "DELETE FROM versions WHERE file_ID=$ID_file  ; ";	
	$db->query($query) ;	
	$query = "DELETE FROM permissions WHERE ID_file=$ID_file  ; ";	
	$db->query($query) ;	
	echo "<div align=center><b><font color=green>File $filename deleted!</font></b></div>";
	}
	

require_once('admin.php');
?>