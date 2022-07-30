<?php
function display($a){
	echo "<pre>";
	print_r($a);
	echo "</pre>";
}

function initMenu(){
	echo "
		<link rel='stylesheet' href='stylesheet.css' />
		<div style='width: 100%; height: 57px; background-color: #050727;'>
		<div id='navigation'>
			<ul>
				<li><a href='formulaire.php'>Accueil</a></li>
	
				<li><a href='jeu.php'>Jouer</a></li>
	
				<li><a href='profil.php'>Profil</a></li>
					
				<li><a href='admin.php'>Admin</a></li>
			</ul>
		</div><!-- #navigation --></div>
	";
	echo "<div id=global>";
	echo "<h1 style='font-size:48px'>Le Juste Prix</h1><hr/>";
}

function initStatut($user){
	echo "<table>
				<tr>
					<td><p style='text-align: left';>Bonjour <span style='color: #3030ea'>$user</span> !</p></td>
					<td style='padding-left: 600px'>
						<form method='post' action='action-deconnexion.php' style='padding-top: 15px;'>
						<div id='boutons'><input id='bouton' name='Deconnexion' type='submit' value='Déconnexion'/></div>
						</form>
					</td>
				</tr>
				</table>";
}

function clearFilePlayer($user){
	$file="fichiers_joueurs/$user.csv";
	
	if (file_exists($file)){
		$fp = fopen($file,"r");
		$i = 1;
		$data[0][0] = "résultat";
		$data[0][1] = "nombre de coups";
		while($resultat = fgetcsv($fp)){
			if( ($resultat[0] == "gagné" && $resultat[1] >= 1 && $resultat[1] <= 10) || ($resultat[0] == "perdu" && $resultat[1] == 10)){
				for($j = 0; $j < 2; $j++){
					$data[$i][$j] = $resultat[$j];
				}
				$i = $i + 1;
			}
		}
		fclose($fp);
		
		$fp = fopen($file,"w"); //réecriture du fichier joueur
		for($i = 0; $i < sizeof($data); $i++){
			fputcsv($fp,$data[$i]);
		}
		fclose($fp);
	}
}
?>