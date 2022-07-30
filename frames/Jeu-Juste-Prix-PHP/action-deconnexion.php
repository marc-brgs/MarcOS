<?php
session_start();
if (isset($_POST['Deconnexion'])){
	$deco = $_POST['Deconnexion'];
	if(strcmp($deco,"Déconnexion")==0){
		session_destroy();
		unset($_SESSION["admin"]);
		unset($_SESSION["date"]);
		header('Location: formulaire.php');
	}
	else{
		header('Location: formulaire.php?error=Erreur de déconnexion');
	}
}
else{
		header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
}
?>