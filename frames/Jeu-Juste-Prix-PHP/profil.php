<?php 
	require_once("mesFonctions.php");
	//error_reporting(E_ERROR | E_PARSE);
	
	initMenu();
			
	session_start();
	
	//Si connecté à un compte
	if(isset($_SESSION['user'])){
		$user = $_SESSION["user"];
		if (isset($_POST)){	
			foreach($_POST as $k => $val){
				$$k=$val;
			}
			
			initStatut($user);
			
			echo "<h3>Votre profil</h3>";
			
			@clearFilePlayer($user);
			$file="fichiers_joueurs/$user.csv";
			
			//Si le joueur a déjà fini des parties
			if (file_exists($file)){
				echo"<table id='cadre' border=0 cellpadding=5 cellspacing=3>";
				$fp = fopen($file,'r');
				$resultat = fgetcsv($fp);
					
				echo"<tr>";
				for($i=0;$i<2;$i++){
					echo "<th>".$resultat[$i]."</th>";
				}
				$partiesjouees = 0;
				$partiesgagnees = 0;
				$totalcoups = 0;
				
				while($resultat = fgetcsv($fp)){
					echo"<tr>";
					for($i=0;$i<2;$i++){
						echo "<td>".$resultat[$i]."</td>";
					}
					echo"</tr>";
					if($resultat[0] == "gagné"){
						$partiesgagnees ++;
					}
					$partiesjouees ++;
					$totalcoups += $resultat[1];
				}
				
				fclose($fp);
				echo "</table>";
				$winrate = ($partiesgagnees/$partiesjouees)*100;
				$winrate = number_format($winrate,2,",",""); //params: val,nb après la virgule,separateur decimales,separateur milliers
				$moyenne = $totalcoups/$partiesjouees;
				$moyenne = number_format($moyenne,2,",",""); //params: val,nb après la virgule,separateur decimales,separateur milliers
				echo "<span style='margin-right: 15px;'>Parties jouées : $partiesjouees</span> - <span style='margin-left: 15px;'>Ratio G/P : $winrate %</span><br/>";
				echo "<span style='margin-right: 15px;'>Total coups : $totalcoups</span> - <span style='margin-left: 15px;'>Moyenne coups : $moyenne</span>";
			}
			//Si le joueur n'a pas fini de parties
			else{
				echo "Vous n'avez pas terminé de partie.";
			}
			
			//balisage pour une meilleure vu après l'appui d'un bouton de profil
			echo "<a id='consult'/><hr style='margin-top:50px;margin-bottom:30px;'/>";
		}
		
		
	}
	
	//Visible par tous (connecté ou non)
		echo "<h3>Tout les profils</h3>";
		$file="fichier.csv";
		if (file_exists($file)){
			$fp = fopen($file,'r');
			$resultat = fgetcsv($fp);
					
			$j = 1;
			echo "<div id='boutons' width='200px;' align='center'>";
			echo "<table>";
			while($resultat = fgetcsv($fp)){
				if($j%5 == 1){
					echo "<br/>";
				}
					
				echo "<form method='post' action='profil.php#consult'>
					<input id='bouton' style='margin-top:0px;margin-left:6px;' name='autre_user' type='submit' value='$resultat[0]'/>
					</form>";
				$j++;
			}
			echo "</div>";
			fclose($fp);
			echo"</table>";
		}
	
	//Visible par tous si bouton d'un autre profil appuyé
		if(isset($_POST["autre_user"])){
			$autre_user = $_POST["autre_user"];
			@clearFilePlayer($autre_user);
			$file="fichiers_joueurs/$autre_user.csv";
			
			//Si l'autre profil a déjà fini des parties
			if (file_exists($file)){
				echo"<table id='cadre' border=0 cellpadding=5 cellspacing=3>";
				echo "<p style='margin-top:40px;'>Profil de $autre_user</p>";
					
				$fp = fopen($file,'r');
				$resultat = fgetcsv($fp);
						
				echo"<tr>";
				for($i=0;$i<2;$i++){
					echo "<th>".$resultat[$i]."</th>";
				}
					
				$partiesjouees = 0;
				$partiesgagnees = 0;
				$totalcoups = 0;
				
				while($resultat = fgetcsv($fp)){
					echo"<tr>";
					for($i=0;$i<2;$i++){
						echo "<td>".$resultat[$i]."</td>";
					}
					echo"</tr>";
					if($resultat[0] == "gagné"){
						$partiesgagnees ++;
					}
					$partiesjouees ++;
					$totalcoups += $resultat[1];
				}
				
				echo "</table>";
				fclose($fp);
				$winrate = ($partiesgagnees/$partiesjouees)*100;
				$winrate = number_format($winrate,2,",",""); //params: val,nb après la virgule,separateur decimales,separateur milliers
				$moyenne = $totalcoups/$partiesjouees;
				$moyenne = number_format($moyenne,2,",",""); //params: val,nb après la virgule,separateur decimales,separateur milliers
				echo "<span style='margin-right: 15px;'>Parties jouées : $partiesjouees</span> - <span style='margin-left: 15px;'>Ratio G/P : $winrate %</span><br/>";
				echo "<span style='margin-right: 15px;'>Total coups : $totalcoups</span> - <span style='margin-left: 15px;'>Moyenne coups : $moyenne</span>";
			}
			//Si il n'a pas fini de parties
			else{
				echo "<p style='margin-top:40px;'>$autre_user n'a pas terminé de partie.</p>";
			}
		}
			
	echo "</div>";
	echo "</div>";
	echo "<div id='bas'/>";

?>