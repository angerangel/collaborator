<?php
#to use after check, so we have 
#$db contains DB connection
#$username
#let's check if user is an admin
$query = "SELECT id FROM users WHERE user='$username'";
$user_ID = $db->query($query)->fetch();
$user_ID = $user_ID[0];
$query = "SELECT status FROM admins WHERE id=$user_ID";
$status = $db->query($query)->fetch();
$status = $user_ID[0];

if  ($status === "false") {				
		//wrong authentication, we go to the login page:
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'listfiles.php';
		header('Location: http://' . $host . $uri . "/" . $extra);
		exit;		
		}	
?>		
