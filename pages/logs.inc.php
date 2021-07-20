<?php
	$log = "";
	
	if($_POST["purge_logs"] && $_POST["password"] == $settings_password) {
		purge_logs();
		print("<span class=\"green\">Logs purged.</span>");
	}
	else if($_POST["purge_logs"]) {
		print("<span class=\"red\">Wrong password.</span><br />");
	}
	
	$log_file = file($config["settings"]["LOGFILE"]);
	//rsort($log_file);
	
	for($i=0; $i < count($log_file); ++$i) {
		list($datetime, $status) = explode(";", $log_file[$i]);
		$log .= "[" . $datetime . "] " . $status . "<br />\n";
	}
?>
<h1>
	Logs
</h1>
<hr />
<form action="/?page=logs" method="post">
	<p>
		<b>Enter administrative password (not user password):</b><br />
		<input type="password" name="password" placeholder="Admin Password" required><input type="submit" name="purge_logs" value="Purge logs" />
	</p>
</form>
<hr />
<p>
	<?php print($log); ?>
</p>
