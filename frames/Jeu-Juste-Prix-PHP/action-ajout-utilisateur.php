<?php

$file="fichier.csv";

$liste_captcha = array(7,6,1,10,10,9,2,3,8);


if (isset($_POST['log'],$_POST['psw'])){
	
	foreach($_POST as $k => $v){
		$$k= $v;
	}
	
	if (file_exists($file)){
	
		$fp = fopen($file,'a+');
		$validation = true;
		
		while($resultat = fgetcsv($fp)){
			if($log == $resultat[0]){
				$validation = false;
				header('Location: formulaire-ajout.php?error=Nom d\'utilisateur déjà existant');
				break;
			}
		}
		
		session_start();
		$numero_question = $_SESSION['captcha']['numero_question'];
		$reponse_utilisateur = $_POST['captcha'];
		
		if($reponse_utilisateur != $liste_captcha[$numero_question]){
			$validation = false;
			header('Location: formulaire-ajout.php?error=Captcha incorrect');
		}
		
		if(strlen($log) > 14){
			header('Location: formulaire-ajout.php?error=La taille du login doit être inférieur à 15 caractères');
			$validation = false;
		}
		
		if(strlen($log) < 3){
			header('Location: formulaire-ajout.php?error=La taille du login doit être d\'au moins 3 caractères');
			$validation = false;
		}
		
		if(strlen($psw) < 2){
			header('Location: formulaire-ajout.php?error=La taille du password doit être d\'au moins 2 caractères');
			$validation = false;
		}
		
		if ($validation){
			$password = md5($psw); /// hash mot de passe
			$data = array($log,$password); /// tableau contenant le login et le password à rajouter dans le fichier csv
			
			fputcsv($fp,$data);
			fclose($fp);
			header('Location: formulaire.php?success=Utilisateur ajouté avec succés');
		}
	}
}
else {
	header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
}

?>