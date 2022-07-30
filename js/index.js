/**
  Creation : 29/07/2022
  Author : Marc BOURGEOIS
 */
 
window.onload = init;

function init() {
	console.log("MarcOS successfully loaded");
	
	// First set
	const windows = document.getElementsByClassName("window");
	for(let wdw of windows) {
		wdw.style.width = window.innerWidth*(1/2) + "px";
		wdw.style.height = window.innerHeight*(2/3) + "px";
		wdw.addEventListener('click', event => {awakeWindow(event.target)});
	}
	
	// Add listeners
	
	// Correctly handle iframes when dragging or resizing window
	const body = document.body;
	body.addEventListener('mousedown', () => {
		let iframes = document.getElementsByTagName("IFRAME");
		for(let iframe of iframes) {
			iframe.style.pointerEvents = "none";
		}
		});
	body.addEventListener('mouseup', () => {
		let iframes = document.getElementsByTagName("IFRAME");
		for(let iframe of iframes) {
			iframe.style.pointerEvents = "auto";
		}
		});
		
	// Iframe awake window (not working)
	let iframes = document.getElementsByTagName("IFRAME");
	for(let iframe of iframes) {
		// iframe.contentWindow.document.body.addEventListener('mousedown', (event, iframe) => {
			// awakeWindow(iframe);
		// });
	}
	
	// Click on desktop
	let wallpaper = document.getElementsByClassName("wallpaper")[0];
	wallpaper.addEventListener('click', event => {clickOnWallpaper(event.target)});
	
	// Click on icon
	const icons = document.getElementsByClassName("icon");
	for(let icon of icons) {
		icon.addEventListener('click', event => {clickOnIcon(event.target)});
	}
	
	// Click on task in taskbar
	let tasks = document.getElementsByClassName("task");
	for(let task of tasks) {
		task.addEventListener('click', event => {clickOnTask(event.target)});
	}
	
	// Draggable and onclick windows
	for(let wdw of windows) {
		dragWindow(wdw);
		wdw.addEventListener('click', event => {awakeWindow(event.target)});
	}
	
	// Window buttons
	const btnMinimize = document.getElementsByClassName("window-btn minimize");
	for(let btn of btnMinimize) {
		btn.addEventListener('click', event => {windowBtnMinimize(event)});
	}
	const btnMaximize = document.getElementsByClassName("window-btn maximize");
	for(let btn of btnMaximize) {
		btn.addEventListener('click', event => {windowBtnMaximize(event)});
	}
	const btnClose = document.getElementsByClassName("window-btn close");
	for(let btn of btnClose) {
		btn.addEventListener('click', event => {windowBtnClose(event)});
	}
	
}

function deselectAll() {
	// Icons
	let icons = document.getElementsByClassName("icon");
	for(let icon of icons) {
		icon.removeAttribute("focused");
	}
	
	// Tasks
	let tasks = document.getElementsByClassName("task");
	for(let task of tasks) {
		task.removeAttribute("focused");
	}
	
	// Windows
	let windows = document.getElementsByClassName("window");
	for(let wdw of windows) {
		wdw.setAttribute('idle', '');
	}
}

function clickOnWallpaper(target) {
	if(target.className !== "wallpaper" && target.className !== "grid") return; // from wallpaper
	
	deselectAll();
}

function clickOnTask(task) {
	while(task.className !== "task") task = task.parentNode; // from child redirect to parent
	
	const pid = task.getAttribute("pid");
	let pid_wdw = null;
	
	const windows = document.getElementsByClassName("window");
	for(let wdw of windows) {
		if(wdw.getAttribute("pid") === pid) {
			pid_wdw = wdw;
			break;
		}
	}
	
	if(!pid_wdw) return;
	
	// Reduce window if already focused
	if(task.getAttribute("focused") !== null) {
		deselectAll();
		pid_wdw.style.display = "none";
		pid_wdw.setAttribute('idle', '');
		return;
	}
	
	// Focus window
	deselectAll();
	
	task.setAttribute("focused", "");
	focusWindow(pid_wdw);
}

function focusWindow(wdw) {
	// Idle all other windows
	let windows = document.getElementsByClassName("window");
	for(let w of windows) {
		w.setAttribute('idle', '');
		w.style.zIndex = 10;
	}
	wdw.removeAttribute('idle');
	wdw.style.zIndex = 11;
	
	// Active task
	const pid = wdw.getAttribute("pid");
	let tasks = document.getElementsByClassName("task");
	for(let task of tasks) {
		task.removeAttribute("focused");
		if(task.getAttribute("pid") === pid) {
			task.setAttribute("focused", "");
		}
	}
	
	// Show and set to foreground
	wdw.style.display = null;
}

function clickOnIcon(icon) {
	while(icon.className !== "icon") icon = icon.parentNode; // from child redirect to parent
	
	// Double click
	if(icon.getAttribute("focused") !== null) {
		doubleClickOnIcon(icon);
		return;
	}
	deselectAll();
	
	icon.setAttribute("focused", "");
}

function doubleClickOnIcon(icon) {
	const pid = icon.getAttribute("pid");
	
	let tasks = document.getElementsByClassName("task");
	for(let task of tasks) {
		if(task.getAttribute("pid") === pid) {
			task.style.display = null;
			task.setAttribute("focused", "");
			break;
		}
	}
	
	let windows = document.getElementsByClassName("window");
	for(let wdw of windows) {
		if(wdw.getAttribute("pid") === pid) {
			focusWindow(wdw);
			break;
		}
	}
}

function awakeWindow(wdw) {
	while(wdw.className !== "window") wdw = wdw.parentNode; // from child redirect to parent
	focusWindow(wdw);
}

function dragWindow(wdw) {
	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	
	if (wdw.getElementsByClassName("window-header")) {
		wdw.getElementsByClassName("window-header")[0].onmousedown = dragMouseDown;
	} else {
		wdw.onmousedown = dragMouseDown;
	}

	function dragMouseDown(e) {
		// Cancel if btn click
		if(e.target.classList.contains("window-btn")) return;
		
		// Focus wdw
		let wdw = e.target;
		while(wdw.className !== "window") wdw = wdw.parentNode;
		focusWindow(wdw);
		
		e = e || window.event;
		e.preventDefault();
		
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
    
		document.onmousemove = elementDrag;
	}

	function elementDrag(e) {
		e = e || window.event;
		e.preventDefault();
    
		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;
		
		wdw.style.top = (wdw.offsetTop - pos2) + "px";
		wdw.style.left = (wdw.offsetLeft - pos1) + "px";
	}

	function closeDragElement() {
		document.onmouseup = null;
		document.onmousemove = null;
		
		// Anti window hididng
		if(wdw.getBoundingClientRect().top < 0)
			wdw.style.top = "0px";
		else if(wdw.getBoundingClientRect().top > window.innerHeight-40) {
			wdw.style.top = window.innerHeight-50 + "px";
		}
		if(wdw.getBoundingClientRect().left > window.innerWidth-20)
			wdw.style.left = window.innerWidth-50 + "px";
		else if(wdw.getBoundingClientRect().right < 200)
			wdw.style.left = wdw.getBoundingClientRect().left+(200-wdw.getBoundingClientRect().right) + "px";
	}
}

function windowBtnMinimize(e) {
	e.stopPropagation();
	
	// Recover window
	let target = e.target;
	while(target.className !== "window") target = target.parentNode;
	
	deselectAll();
	target.style.display = "none";
	target.setAttribute('idle', '');
}

function windowBtnMaximize(e) {
	e.stopPropagation();
	
	// Recover window
	let target = e.target;
	while(target.className !== "window") target = target.parentNode;
	
	if(target.getAttribute("maximized") !== null)
		target.removeAttribute("maximized");
	else
		target.setAttribute("maximized", "");
}

function windowBtnClose(e) {
	e.stopPropagation();
	
	// Recover window
	let target = e.target;
	while(target.className !== "window") target = target.parentNode;
	
	const pid = target.getAttribute("pid");
	
	deselectAll();
	target.style.display = "none";
	target.setAttribute('idle', '');
	target.removeAttribute("maximized");
	
	let tasks = document.getElementsByClassName("task");
	for(let task of tasks) {
		if(task.getAttribute("pid") === pid) {
			task.style.display = "none";
			break;
		}
	}
}