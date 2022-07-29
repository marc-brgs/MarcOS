/**
  Creation : 29/07/2022
  Author : Marc BOURGEOIS
 */
window.onload = init;

function init() {
	const body = document.body;
	
	// Add listeners
	
	let wallpaper = document.getElementsByClassName("wallpaper")[0];
	wallpaper.addEventListener('click', event => {
		if(event.target.className !== "wallpaper" && event.target.className !== "grid") return; // from wallpaper
		deselectAll()});
	
	let icons = document.getElementsByClassName("icon");
	let l = icons.length;
	for(let i = 0; i < l; i++) {
		icons[i].addEventListener('click', event => {activeIcon(event.target)});
	}
	
	let tasks = document.getElementsByClassName("task");
	l = tasks.length;
	for(let i = 0; i < l; i++) {
		tasks[i].addEventListener('click', event => {activeTask(event.target)});
	}
	
}

function deselectAll() {	
	// Icons
	let icons = document.getElementsByClassName("icon");
	
	let l = icons.length;
	for(let i = 0; i < l; i++) {
		icons[i].removeAttribute("focused");
	}
	
	// Tasks
	let tasks = document.getElementsByClassName("task");
	
	l = tasks.length;
	for(let i = 0; i < l; i++) {
		tasks[i].removeAttribute("focused");
	}
}

function activeTask(task) {
	while(task.className !== "task") task = task.parentNode; // from child redirect to parent
	
	deselectAll();
	
	task.setAttribute("focused", "");
}

function activeIcon(icon) {
	while(icon.className !== "icon") icon = icon.parentNode; // from child redirect to parent
	
	deselectAll();
	
	icon.setAttribute("focused", "");
}