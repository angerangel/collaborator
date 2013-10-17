<?php
	unset($_COOKIE['Collaborator']);
	setcookie("Collaborator", "" , time()-3600);
	require_once('index.php');
?>