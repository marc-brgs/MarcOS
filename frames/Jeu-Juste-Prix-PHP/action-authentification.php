<?php

session_start();

$file="fichier.csv";

if(isset($_SESSION['user'])){
	header('Location: formulaire.php?error=Déconnectez vous pour vous connecter');
}
else if (isset($_POST['log'],$_POST['psw'])){
	
	foreach($_POST as $k => $val){
		$$k=$val;
    }
	
	if (file_exists($file)){
	
		$fp = fopen($file,'r');
		$connexion = false;
		while($resultat = fgetcsv($fp)){
			
			$password = md5($psw); /// hash du mot de passe pour le comparer au mot de passe hashé stocké dans le fichier csv
			
			if($log == $resultat[0] and $password == $resultat[1]){
				$connexion = true;
				$_SESSION["user"]=$log;
				$_SESSION["date"]=$time;
				if($log == "admin"){
					header('Location: admin.php');
					break;
				}
				else{
					header('Location: jeu.php');
					break;
				}
			}
			else if(feof($fp)){
				echo "fin de fichier";
				header('Location: formulaire.php?error=Combinaison login/password incorrecte');
			}
		}
		
		fclose($fp);
		if(!$connexion){
			header('Location: formulaire.php?error=Combinaison login/password incorrecte');
		}
	}
	else{
		echo "fichier existe pas";
		header('Location: formulaire.php?error=Fichier introuvable!');
	}
}
else{
	header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
}
?>