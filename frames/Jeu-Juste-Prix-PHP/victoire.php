<?php

session_start();

if(isset($_SESSION['user'])){
	if(isset($_GET['coup'], $_GET['nb'])){
		
		$user = $_SESSION["user"];
		
		require_once("mesFonctions.php");
					
		initMenu();
				
		initStatut($user);
		
		$coup = $_GET["coup"];
		$nombre = $_GET["nb"];
		echo "</br><p style='font-size: 30px;'>Vous avez gagné en $coup coups!</p>";
		echo "<p>Le nombre était $nombre</p></br>";
		echo "<p style='color:#0000ff;'>Votre profil a été mis à jour</p></br>";
		echo "
				<table style='margin:auto;'>
					<td><form method='post' action='profil.php'>
							<div id=boutons> <input id='bouton' style='margin-left:6px;' type='submit' value='Mon profil'/><input name='user' type='hidden' value='$user'/></div>
						</form>
					</td>
						
					<td><form method='post' action='jeu.php'>
							<div id=boutons><input id='bouton' name='retour' type='submit' value='Rejouer'/></div>
						</form>
					</td>
				</table>
				";
		
		
		echo "</div>";
		echo "<div id='bas'/></body>";
	}
	else{
		header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
	}
}
else{
	header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
}

?>