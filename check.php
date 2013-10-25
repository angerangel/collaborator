
<?php

if(isset($_COOKIE['Collaborator'])){
	$temp_arr = explode("::", $_COOKIE['Collaborator']) ;
	$username = $temp_arr[0];
	$password =  $temp_arr[1];
	$db = new PDO('sqlite:secret/db.sqlite');
	$query = "SELECT password FROM users WHERE user='" . $username . "' ; " ;	
	$row = $db->query($query)->fetch();
	if($password === $row[0]) {		
		setcookie("Collaborator", $username . "::" . $password , time()+60*60*8); //8 hours is enough			
		} else {
		//wrong authentication, we go to the login page:
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'index.php';
		header('Location: http://' . $host . $uri . "/" . $extra);
		exit;		
		}	
	} else { 
	//no authentication, we go to the login page:
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header('Location: http://' . $host . $uri . "/" . $extra);
	exit;		
	}
?>