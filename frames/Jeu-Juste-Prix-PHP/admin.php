<html>

	<head>
		<script language="javascript">
			function verif(i)
			{
				var numero = i;
				var nomForm = "supprimerUtilisateur" + numero;
				var nomUtilisateur = document.forms[nomForm]["nomUtilisateur"].value;
				return confirm('Voulez-vous supprimer l\'utilisateur ' + nomUtilisateur + ' ?');
			}
		</script>
	</head>
	
	<body>
		<?php 

		$file="fichier.csv";

		session_start();

		if(isset($_SESSION['user'])){
			if($_SESSION['user'] == "admin"){
				
				require_once("mesFonctions.php");
				
				initMenu();
			
				$user = $_SESSION["user"];
			
				initStatut($user);
			
			if(isset($_GET['success'])) {
				$code = $_GET['success'];
				echo "<p style='color: #0000ff;'> $code </p>";
			}
			if(isset($_GET['error'])) {
				$erreur = $_GET['error'];
				echo "<p style='color: #ff0000;'> $erreur </p>";
			}
			
			echo"<table id='cadre' cellpadding=5 cellspacing=3 style='width: 1000px;margin-left:auto;margin-right:auto;'>";
			if (file_exists($file)){
				
				$fp = fopen($file,'r');
				$resultat = fgetcsv($fp);
				
				echo"<tr>";
				for($i=0;$i<2;$i++){
					echo "<th>".$resultat[$i]."</th>";
				}
				echo "<th>Consulter le profil</th>";
				echo "<th>Modifier mot de passe</th>";
				echo "<th>Supprimer utilisateur</th>";
				echo"</tr>";
				
				$j = 1;
				while($resultat = fgetcsv($fp)){
					echo"<tr>";
					for($i=0;$i<2;$i++){
						if($i == 0)
							echo "<td><p style='font-size: 14px;'>".$resultat[$i]."</p></td>";
						else
							echo "<td><p style='font-size: 10px;'>".$resultat[$i]."</p></td>";
					}
					echo "<form method='post' action='profil.php#consult'>
					<td> <div id=boutons><input id='bouton' name='consulter' type='submit' value='Consulter'/><input type='hidden' name='autre_user' value='$resultat[0]'></div></td>
					</form>
					";
					echo "<form method='post' action='modifier-password.php'>
					<td> <div id='boutons'><input id='bouton' name='modifier' type='submit' value='modifier'/></div'></td>
					<input type='hidden' name='nomUtilisateur' value='$resultat[0]'>
					</form>
					";
					echo "<form name='supprimerUtilisateur$j' method='post' action='action-supprimer.php' onsubmit='return verif($j);'>
					<td> <div id='boutons'><input id='bouton' name='supprimer' type='submit' value='supprimer' /></div></td>
					<input type='hidden' name='nomUtilisateur' value='$resultat[0]'>
					<input type='hidden' name='numero' value='$j'>
					</form>
					";
					echo"</tr>";
					$j++;
				}
				fclose($fp);
			}
			echo"</table>";
			
			
			}
			else{
				header('Location: formulaire.php?error=Vous ne disposez pas des permissions neccesaires');
				
			}
			echo "</div>";
			echo "<div id='bas'/></body>";
		}
		else{
			header('Location: formulaire.php?error=Vous n\'êtes pas connecté');
}

		?>
	</body>
	
</html>