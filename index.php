<?php
require('config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Logviewer</title>
	<link href="styles.css" rel="stylesheet" type="text/css" />
	<link href="bootstrap.css" rel="stylesheet" type="text/css" />
	<script src="jquery.js"></script>
	<script>
	//Listeners
	$(window).on('resize', function(){
		resizeBox();
	});
	
	function resizeBox() {
		var height = $(window).height();
		var controlSize = 150;
		//Get Remaining Screen Real Estate
		var logViewerSize = height - controlSize - 17;
		$("#logView").height(logViewerSize);
	}
		
	function init() {
		resizeBox();
	}
	
	function insertIntoLogView(text) {
		document.getElementById('logView').innerHTML=text;
	}
	
	function getLogs() {
		var length = document.getElementById('lines').value;
		var filterChat = $("#filterChat").is(":checked");
		var filterCommands = $("#filterCommands").is(":checked");
		var filterWorldEdit = $("#filterWorldEdit").is(":checked");
		var filterErrors = $("#filterErrors").is(":checked");
		var filterKickBans = $("#filterKickBans").is(":checked");
		var filterLoginLogout = $("#filterLoginLogout").is(":checked");
		$.post("<?php echo getLogs_FILENAME; ?>", {length: length, chat: filterChat, commands: filterCommands, worldedit: filterWorldEdit, errors: filterErrors, filterKickBans: filterKickBans, loginlogout: filterLoginLogout}).done(function(data) {
			insertIntoLogView(data);
			$(function () {
			  $('#logView').scrollTop(25000);
			});
		});

	}
	
	</script>
</head>
<body>
	<div id="control">
		<form name="control_filters" id="control_filters">
			<table class="table table-bordered">
				<tr>
				  <td width="33%"><label for="filterChat"><input type="checkbox" id="filterChat" value="chat" checked> Chat / Admin Chat</label></td>
				  <td width="33%"><label for="filterCommands"><input type="checkbox" id="filterCommands" value="commands" checked> Commands</label></td>	
				  <td width="33%"><label for="filterWorldEdit"><input type="checkbox" id="filterWorldEdit" value="worldEdit" checked> WorldEdit</label></td>
				</tr>
				<tr>
				  <td width="33%"><label for="filterErrors"><input type="checkbox" id="filterErrors" value="error" checked> Errors</label></td>
				  <td width="33%"><label for="filterKickBans"><input type="checkbox" id="filterKickBans" value="kickBans" checked> Kicks / Bans / Tempbans</label></td>
				  <td width="33%"><label for="filterLoginLogout"><input type="checkbox" id="filterLoginLogout" value="loginLogout" checked> Login / Logout</label></td>	
				</tr>
			</table>
			<p>Lines: <input type="text" id="lines" value="50" /> <button onclick="event.preventDefault(); getLogs();">Update Logs</button></p> 
		</form>
	</div>
	<div id="logView">

	</div>
</body>
<script>
init();
getLogs();
</script>
</html>