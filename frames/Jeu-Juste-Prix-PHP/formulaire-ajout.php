<?php
	require_once("mesFonctions.php");
	
	initMenu();
	
			$liste_captcha = array("3 + 4 = ","5 + 1 = ","0 + 1 = ","2 + 8 = ","6 + 4 = ","2 + 7 = ","1 + 1 = ","2 + 1 = ","4 + 4 = ");

			session_start();
			
			if(isset($_SESSION['user'])){
				$user = $_SESSION['user'];
				initStatut($user);
			}
			$numero_question = array_rand($liste_captcha);
			$_SESSION['captcha']['numero_question'] = $numero_question;
			
			echo "<div id=cadre>";
			echo "Ajout utilisateur";
			echo "<form method='post' action='action-ajout-utilisateur.php' style='margin: auto; padding-top: 10px; width: 450px;'>
			<table cellpading='4'>
			<tr><td style='padding-right: 100px;'> Login : </td> <td> <input id='champs' name='log' type='text' maxlength='14'/> </td></tr>
			<tr><td> Password : </td> <td> <input id='champs' name='psw' type='password'/> </td></tr>
			<tr><td> $liste_captcha[$numero_question] </td> <td> <input id='champs' name='captcha' type='number'/> </td></tr>
			</table>
			<div id='boutons'><input id='bouton' name='ok' type='submit' value='Valider'/> <input id='bouton' name='res' type='reset' value='Annuler'/></div>
			
			</form>
			";
			echo "</div>";

			if(isset($_GET['error'])) {
				$erreur = $_GET['error'];
				echo "<p style='color: #ff0000;'> $erreur </p>";
			}

			echo "Déjà un compte? <a href='formulaire.php'>Se connecter</a>";
			echo "<hr/></div>";
		?>
		<div id="bas"/>
	</body>

</html>