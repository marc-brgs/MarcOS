<?php

session_start();

if(isset($_POST['supprimer'])){
	if(isset($_SESSION['user'])){
		
		$user = $_SESSION["user"];

		if($user == "admin"){
			foreach($_POST as $k => $v){
				$$k= $v;
			}
			
			if($nomUtilisateur != "admin"){ /// Si l'utilisateur à supprimer n'est pas admin
				$file = "fichier.csv";
				$fp = fopen($file,"r");
				$i = 0;
				while($resultat = fgetcsv($fp)){
					if($resultat[0] != $nomUtilisateur){
						for($j = 0; $j < 2; $j++){
							$data[$i][$j] = $resultat[$j];
						}
						$i = $i + 1;
					}
				}
				fclose($fp);
				$fp = fopen($file,"w");
				for($i = 0; $i < sizeof($data); $i++){
					fputcsv($fp,$data[$i]);
				}
				fclose($fp);
				$file = "fichiers_joueurs/$nomUtilisateur.csv";
				if(file_exists($file)){
					unlink($file);
				}
				header('Location: admin.php?success=Utilisateur '.$nomUtilisateur.' supprimé avec succès');
			}
			else{
				header('Location: admin.php?error=Vous ne pouvez pas supprimer l\'utilisateur Admin');
			}
		}
		else{
			header('Location: formulaire.php?error=Vous ne disposez pas des permissions neccesaires');
		}
	}
}
else {
	header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
}

?>