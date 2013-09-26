<?php  
#Check cookie
if(isset($_COOKIE['Collaborator'])){
	$temp_arr = explode("::", $_COOKIE['Collaborator']) ;
	$username = $temp_arr[0];
	$password =  $temp_arr[1];
	$db = new PDO('sqlite:db.sqlite');
	$query = "SELECT password FROM users WHERE user='" . $username . "' ; " ;	
	$row = $db->query($query)->fetch();
	if($password === $row[0]) {		
		setcookie("Collaborator", $username . "::" . $password , time()+60*60*8); //8 hours is enough
		//redirect
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'listfiles.php';
		header('Location: http://' . $host . $uri . "/" . $extra);
		exit;		
		}	
	}
#Check POST
if (isset($_POST['submit'])) {
	#proviamo a connetterci al db
	$db = new PDO('sqlite:db.sqlite');	
	$username = $_POST['username'];
	$password =  $_POST['password'];	
	$query = "SELECT password FROM users WHERE user='" . $username . "' ; " ;	
	$row = $db->query($query)->fetch();
	//print_r($row);	
	if($password === $row[0]) {		
		setcookie("Collaborator", $username . "::" . $password , time()+60*60*8); //8 hours is enough
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'listfiles.php';
		header('Location: http://' . $host . $uri . "/" . $extra);
		exit;				
		} else {
			echo "<div align=center ><h3><font color=red>ERROR: WRONG USERNAME OR PASSWORD</font></h3></div>";
			}
	} 


#chiudiamo il database
$db = null;
?>




<div align=center >
<h1>COLLABORATOR</h1>
<i>Your free and personal collaborator software.</i>
<form  action=index.php  method=post >
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" name="submit" value="submit">
</form>
</div>