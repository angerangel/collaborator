
<?php  
$checkp = false ; 

#proviamo a connetterci al db
$db = new PDO('sqlite:db.sqlite');	


/*   
foreach($result as $row) {
      echo "Id: " . $row['user'] . "\n";
      echo "Title: " . $row['password'] . "\n";      
      echo "<br>";
    }   
*/


if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password =  $_POST['password'];	
	$query = "SELECT password FROM users WHERE user='" . $username . "' ; " ;	
	$row = $db->query($query)->fetch();
	print_r($row);
	
	if($password === $row[0]) {
		echo "entrato";
		#poi se funziona
		#setcookie("Testcookie", "Ciao belli!" , time()+3600);
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