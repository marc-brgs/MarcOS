<?php

?>

<!DOCTYPE html>
<html>
	<head>
		<title>MarcOS</title>
		<meta charset="UTF-8">
		<link rel="icon" type="image/png" href="img/windows_2000_logo.png">
		<?php
		$time = time();
		echo "
		<link rel='stylesheet' href='css/desktop.css?i={$time}'>
		<link rel='stylesheet' href='css/window.css?i={$time}'>
		<link rel='stylesheet' href='css/login.css?i={$time}'>";
		// <script src='js/index.js?i={$time}'></script>";
		?>
	</head>
	<body>
		<div class="background">
			<div class="window-like">
				<div class="window-header">
					<div class='window-title-container'>
						<span class="window-name">Log On to MarcOS</span>
					</div>
				</div>
				<div class='window-content'>
					<div style="display: flex; justify-content: center; align-items: center; height: 100px; font-size: 24px; font-weight: bold;">
						<img src="img\windows_2000_logo.png" style="width: 40px; margin-right: 10px;">MarcOS
					</div>
					<div style="display: flex; flex-direction: column; width: 520px; height: 120px; background-color: #d4d0c8; border-top: 6px solid #013755;">
						<form>
							<table>
								<tr><td>User name:</td><td><input type="text"></td></tr>
								<tr><td>Password:</td><td><input type="password"></td></tr>
							</table>
							<div style="display: flex; justify-content: right; gap: 5px; margin-right: 15px;">
								<button type="submit">OK</button>
								<button type="reset">Cancel</button>
								<button>Log as anonymous</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php

?>