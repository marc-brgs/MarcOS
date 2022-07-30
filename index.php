<?php
$window_offset = 50;
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
		<script src='js/index.js?i={$time}'></script>";
		?>
	</head>
	<body>
		<div class="wallpaper">
			<span class="sign">MarcOS</span>
			<div class="grid">
				<?php
				drawIcon("01", "img/my_documents.png", "My Documents");
				drawIcon("02", "img/task_manager.png", "Task Manager");
				drawIcon("03", "img/my_pictures.png", "My Pictures");
				drawIcon("04", "img/sticpl_cpl.png", "Camera");
				drawIcon("05", "img/my_computer.png", "My Computer");
				drawIcon("06", "img/network_places.png", "My Network Places");
				drawIcon("09", "img/recycle_bin_empty.png", "Recycle Bin");
				?>
			</div>
			
			<?php
			drawWindow("01", "img/my_documents.png", "My Documents", "frames/Ice-Cream-Configurator");
			drawWindow("02", "img/task_manager.png", "Task Manager", "frames/Jeu-Juste-Prix-PHP");
			drawWindow("03", "img/my_pictures.png", "My Pictures", "frames/Site-Web-Vente-De-Fleurs-HTML-CSS");
			drawWindow("04", "img/sticpl_cpl.png", "Camera", "https://www.google.com/search?igu=1&q=marcos%20le%20crack");
			drawWindow("09", "img/recycle_bin_empty.png", "Recycle Bin", "");
			?>
			
			<footer class="taskbar">
				<div class="start-menu">
					<img src="img/windows_2000_logo.png"></img>
					<span>Start</span>
				</div>
				<div class="task-separator"></div>
				<div class="container">
					<ul class="tasks">
						<?php
						drawTask("01", "img/my_documents.png", "My Documents");
						drawTask("02", "img/task_manager.png", "Task Manager");
						drawTask("03", "img/my_pictures.png", "My Pictures");
						drawTask("04", "img/sticpl_cpl.png", "Camera");
						?>
					</ul>
				</div>
			</footer>
			
		</div>
	</body>
</html>

<?php
function drawIcon($pid, $img, $name) {
	echo "<div class='icon' pid='{$pid}'>
		<img src='{$img}'></img>
		<span>{$name}</span>
	</div>";
}

function drawWindow($pid, $img, $name, $frame) {
	global $window_offset;
	echo "<div class='window' style='display: none; top: {$window_offset}px; left: {$window_offset}px;' pid='{$pid}'>
				<div class='window-header'>
					<div class='window-title-container'>
						<img src='{$img}'></img>
						<span class='window-name'>{$name}</span>
					</div>
					<div class='window-btn-container'>
						<div class='window-btn minimize'></div>
						<div class='window-btn maximize'></div>
						<div class='window-btn close'></div>
					</div>
				</div>
				<div class='window-content'>
					<iframe src='{$frame}' style='width: 100%; height: 100%;'></iframe>
				</div>
			</div>";
	$window_offset += 50;
}

function drawTask($pid, $img, $name) {
	echo "<li class='task' pid='{$pid}'>
		<img src='{$img}'></img>
		<span>{$name}</span>
	</li>";
}
?>