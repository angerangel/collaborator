<?php
require_once('check.php');
//$db contains DB connection
//$username

if (isset($_POST['submit'])) {
	$filename = $_POST['filename'];	
	//FILE_ID
	$query = "SELECT ID FROM files where filename='" . $filename . "'" ;
	$row = $db->query($query)->fetch();		
	$file_ID = $row[0];
	//USER_ID
	$query = "SELECT ID FROM users WHERE user='" . $username . "' ;" ;
	$row = $db->query($query)->fetch();
	$user_ID = $row[0];
	//version
	$version = $_POST['version'];
	//serach if user and file is alrwady in versiosns table
	$query = "SELECT * FROM versions WHERE file_ID=$file_ID  AND user_ID=$user_ID ";
	$result = $db->query($query)->fetch() ;
	$result = $result[0];	
	if  ($result == "" ) {
		//user is missing
		$query = "INSERT INTO versions (file_ID,user_ID,version) VALUES ( $file_ID , $user_ID , $version ) " ;
		$db->query($query) ;
		echo "aaaa";
		} else {
		//user is present in versions table
		$query = "UPDATE versions SET version = $version WHERE file_ID = $file_ID AND user_ID =  $user_ID  " ;
		$db->query($query) ;	
		}
	//DOWNLOAD FILE	
	$file =  "files/" . $filename ;	
	if (file_exists($file)) {		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);			
	} else {echo "ERROR, file not found";}
} 
require_once('listfiles.php');
?>
