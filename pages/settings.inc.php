<?php
	if($_POST["store_settings"] && $_POST["password"] == $settings_password) {
		$config["settings"]["ENABLED"] = ( $_POST["doorbell_enabled"] ? 1 : 0 );
		$config["settings"]["LOGGING"] = ( $_POST["logging_enabled"] ? 1 : 0 );
		$config["button"]["BUTTON_PIN"] = $_POST["button_pin"];
		$config["button"]["BUTTON_BOUNCE"] = $_POST["button_bounce"];
		
		if(write_ini_file("config.ini", $config)) {
			doorbell("restart", $config);
			print("
				<span class=\"green\">New values stored (" . date("H:i:s") . "). Refreshing page, please wait...</span>
				<meta http-equiv=\"refresh\" content=\"3\" />
			");
		}
		else {
			print("<span class=\"red\">Settings did not save.</span><br />");
		}
	}
	else if($_POST["reboot"] && $_POST["password"] == $settings_password) {
		print("<span class=\"red\">System is rebooting, please wait...</span><br />");
		flush();
		sleep(1);
		doorbell("reboot", "NOW");
		print("<meta http-equiv=\"refresh\" content=\"60\" />");
		sleep(3);
		die();
	}
	else if($_POST["poweroff"] && $_POST["password"] == $settings_password) {
		print("<span class=\"red\">System is powering off.</span><br />");
		flush();
		sleep(1);
		doorbell("poweroff", "NOW");
		sleep(3);
		die();
	}
	else if(($_POST["store_settings"] || $_POST["reboot"] || $_POST["poweroff"]) && $_POST["password"] != $settings_password) {
		print("<span class=\"red\">Wrong password.</span><br />");
	}
?>
<form method="post">
	<h1>
		System Settings
	</h1>
	<p>
		<b>Doorbell program:</b><br />
		<input type="checkbox" value="1" name="doorbell_enabled" <?php print( ($config["settings"]["ENABLED"] == "1") ? "checked" : null ) ?> /> Enable doorbell program
	</p>
	<p>
		<b>Logging:</b><br />
		<input type="checkbox" value="1" name="logging_enabled" <?php print( ($config["settings"]["LOGGING"] == "1") ? "checked" : null ) ?> /> Enable logging
	</p>
	<p>
		<b>Doorbell pin on the RaspberryPi (GPIO.BCM):</b><br />
		<input type="number" required min="3" max="40" name="button_pin" value="<?php print($config["button"]["BUTTON_PIN"]) ?>" style="width: 50px;" />
	</p>
	<p>
		<b>Bounce time for the button in seconds (increase if false triggers happen, but keep as low as possible):</b><br />
		<input type="number" required min="0" max="1" name="button_bounce" value="<?php print($config["button"]["BUTTON_BOUNCE"]) ?>" step=".01" style="width: 50px;" />
	</p>
	<p>
		<b>Enter administrative password (not user password):</b><br />
		<input type="password" name="password" placeholder="Admin Password" required>
		<input type="submit" name="store_settings" value="Save values" />
		<input type="submit" name="reboot" value="Reboot" /><input type="submit" name="poweroff" value="Power Off" />
	</p>
</form>
