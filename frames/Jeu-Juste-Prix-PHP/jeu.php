<?php

session_start();

if(isset($_SESSION['user'])){
	
	$user = $_SESSION["user"];
	
	require_once("mesFonctions.php");
	initMenu();
	
	initStatut($user);

	echo "Découvrez le nombre situé entre 0 et 100 !<br/>";
	if(!isset($_POST['repjoueur'])){
		$nombre = rand(0,100);
		$i = 0;
		echo "<span style='color: #0000ff'>Vous avez 10 essais</span>";
	}
	else{
		if($_POST['repjoueur']>100 or $_POST['repjoueur']<0)
			$i = $_POST['coup'];
		else
			$i = $_POST['coup']+1;
		$nombre = $_POST['nombreatrouver'];
	}

	if ($i < 10){
		echo "<div id='cadre'>";
		echo "Jouer!";
		echo "<form method='post' action='jeu.php' style='margin: auto; padding-bottom: 15px; padding-top: 10px; width: 450px;'>
		<table>";
		echo "<tr><td style='padding-right: 50px; padding-left: 20px;'> Entrez un nombre : </td> <td> <input id='champs' style='width: 70px;' name='repjoueur' type='text'/> </td></tr>";

		echo"  
		  <tr><td> <input type='hidden' name='coup' value='$i'> </td></tr>
		  <tr><td> <input type='hidden' name='nombreatrouver' value='$nombre'> </td></tr>
		 </table>
		  <p style='margin: auto; text-align: center; font-size: 12px; color: #3030ea'>'Entrée' pour valider</p>
		  </form>
		 ";
		 echo "</div>";
	}
	
	 if (isset($_POST['repjoueur']) && $i <= 10){
		foreach($_POST as $k => $val){
			$$k=$val;
		}
		if($nombre == $repjoueur){
			
			$file = "fichiers_joueurs/$user.csv";
			
			if(!file_exists($file)){
				$fp = fopen($file,'w');
				$array = array("résultat","nombre de coups");
				fputcsv($fp,$array);
				fclose($fp);
			}
			
			$fp = fopen($file,'a');
			$array = array("gagné",$i);
			fputcsv($fp,$array);
			fclose($fp);
			
			header('Location: victoire.php?nb='.$nombre.'&coup='.$i);
			
		}
		elseif($repjoueur > 100 or $repjoueur<0){
            echo "<span style='color: #ff0000'>Le nombre à trouver est entre 0 et 100.</span></br>";
            echo "Votre dernière réponse : $repjoueur</br></br>";
            echo "Nombre de coups : $i / 10</br></br>";
        }
		elseif($i == 10){
			
			$file = "fichiers_joueurs/$user.csv";
			
			if(!file_exists($file)){
				$fp = fopen($file,'w');
				$array = array("résultat","nombre de coups");
				fputcsv($fp,$array);
				fclose($fp);
			}
			
			$fp = fopen($file,'a');
			$array = array("perdu",$i);
			fputcsv($fp,$array);
			fclose($fp);
			
			header('Location: defaite.php?nb='.$nombre);
		}
		elseif ($nombre > $repjoueur){
			echo "Le nombre à trouver est <span style='color: #3030ea'>plus grand</span>.</br>";
			echo "Votre dernière réponse : $repjoueur</br></br>";
			echo "Nombre de coups : $i / 10</br></br>";
		}
		elseif ($nombre < $repjoueur){
			echo "Le nombre à trouver est <span style='color: #3030ea'>plus petit</span>.</br>";
			echo "Votre dernière réponse : $repjoueur</br></br>";
			echo "Nombre de coups : $i / 10</br></br>";
		}
		
	}
	elseif($i == 10){
		echo "</br>Vous avez perdu...</br></br>";
		
		$file = "fichiers_joueurs/$user.csv";
		
		if(!file_exists($file)){
			$fp = fopen($file,'w');
			$array = array("résultat","nombre de coups");
			fputcsv($fp,$array);
			fclose($fp);
		}
		
		$fp = fopen($file,'a');
		$array = array("perdu",$i);
		fputcsv($fp,$array);
		fclose($fp);
		
		header('Location: defaite.php?nb='.$nombre);
	}
	
	echo "</div>";
	echo "<div id='bas'/>";
}
else{
	header('Location: formulaire.php?error=Vous n\'êtes pas connecté');
}

?>