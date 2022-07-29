<!DOCTYPE html>
<html>
	<head>
		<title>MarcOS</title>
		<meta charset="UTF-8">
		<?php
		$time = time();
		echo "
		<link rel='stylesheet' href='css/index.css?i={$time}'>
		<script src='js/index.js?i={$time}'></script>";
		?>
	</head>
	<body>
		<div class="wallpaper">
			<div class="grid">
				<div class="icon">
					<img src="img/my_documents.png"></img>
					<span>My Documents</span>
				</div>
				<div class="icon">
					<img src="img/my_computer.png"></img>
					<span>My Computer</span>
				</div>
				<div class="icon">
					<img src="img/network_places.png"></img>
					<span>My Network Places</span>
				</div>
				<div class="icon">
					<img src="img/recycle_bin_empty.png"></img>
					<span>Recycle Bin</span>
				</div>
			</div>
			<footer class="taskbar">
				<div class="start-menu">
					<img src="img/windows_2000_logo.png"></img>
					<span>Start</span>
				</div>
				<div class="task-separator"></div>
				<div class="container">
					<ul class="tasks">
						<li class="task">
							<img src="img/my_documents.png"></img>
							<span>My Documents</span>
						</li>
						<li class="task">
							<img src="img/task_manager.png"></img>
							<span>Task Manager</span>
						</li>
						<li class="task">
							<img src="img/my_pictures.png"></img>
							<span>Nudes</span>
						</li>
						<li class="task">
							<img src="img/sticpl_cpl.png"></img>
							<span>Pornhub</span>
						</li>
					</ul>
				</div>
			</footer>
			
		</div>
	</body>
</html>