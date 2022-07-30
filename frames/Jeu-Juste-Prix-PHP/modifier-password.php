<html>

	<head>
		<script language="javascript">
			function verif()
			{
				var nomUtilisateur = document.forms["modifierMotDePasse"]["nomUtilisateur"].value;
				return confirm('Voulez-vous modifier le mot de passe de l\'utilisateur ' + nomUtilisateur + ' ?');
			}
		</script>
	</head>
	
	<body>
		<?php

		session_start();
		if(isset($_POST['modifier']) or isset($_POST['psw'])){
			if(isset($_SESSION['user'])){
				
				$user = $_SESSION["user"];

				if($user == "admin"){
					foreach($_POST as $k => $v){
						$$k= $v;
					}
					$utilisateurCible = $nomUtilisateur;
					
					require_once("mesFonctions.php");
					
					initMenu();
				
					initStatut($user);
						
				echo "<div id=cadre>";
				echo "Modification de $utilisateurCible";
				echo "
					 <form style='margin: auto; padding-top: 10px; padding-left: 20px; width: 500px;' name='modifierMotDePasse' method='post' action='modifier-password.php' onsubmit='return verif();'>
					 <table>
					 <tr><td style='padding-right: 30px;'> Nouveau mdp : </td> <td> <input id='champs' name='psw' type='password'/> </td></tr>
					 <tr><td> Confirmer mdp : </td> <td> <input id='champs' name='confirmPsw' type='password'/> </td></tr>
					 <input type='hidden' name='nomUtilisateur' value='$utilisateurCible'>
					 </table>
					 <div id='boutons'><input id='bouton' name='ok' type='submit' value='Valider'/> <input id='bouton' name='res' type='reset' value='Annuler' onclick='history.back()'/></div>
					 </form></div>";
						  
					if(isset($_POST['psw'],$_POST['confirmPsw'])){
						if($psw == $confirmPsw){
							$file = "fichier.csv";
							$fp = fopen($file,"r");
							$i = 0;
							while($resultat = fgetcsv($fp)){
								if($resultat[0] == $utilisateurCible){
									$password = md5($psw);
									$data[$i][0] = $resultat[0];
									$data[$i][1] = $password;
									$i = $i + 1;
								}
								else {
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
							header('Location: admin.php?success=Mot de passe de '.$utilisateurCible.' modifié avec succés');
						}
						else{
							header('Location: admin.php?error=Echec de la modification : les mots de passe ne correspondent pas');
						}
					}
				}
				else{
					header('Location: formulaire.php?error=Vous ne disposez pas des permissions neccesaires');
				}
				echo "</div>";
				echo "<div id='bas'/></body>";
			}
		}
		else {
			header('Location: formulaire.php?error=Impossible d\'accèder à cette page');
		}

		?>
	</body>
	
</html>