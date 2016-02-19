// JavaScript to delay button click focus on insert form
		document.getElementById("addButton").onclick = function() {
			setTimeout(function() {
				document.getElementById("courseName").focus();
			}, 1000);
		};