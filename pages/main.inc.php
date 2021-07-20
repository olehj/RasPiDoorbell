<?php
	if($_POST["doorbell_test"]) { shell_exec("python doorbell-preview.py"); }
	if($_POST["store"]) {
		$config["settings"]["SILENCED"] = ( $_POST["doorbell_silenced"] ? 1 : 0 );
		
		write_ini_file("config.ini", $config);
		
		change_sound(escapeshellarg($_POST["soundfile"]));
		doorbell("restart", $config);
		print("<meta http-equiv=\"refresh\" content=\"0;URL='/'\" />");
	}
?>
<form action="/" method="post">
	<h1>
		Theme Selection
	</h1>
	<p>
		<b>Select sound theme:</b><br />
		<select name="soundfile">
			<?php print($sound_options); ?>
		</select>
	</p>
	<p>
		The scheduler is <?php print( ($config["schedule"]["ENABLED"] == "1") ? "enabled" : "disabled." ) ?>
		<?php
			if($config["schedule"]["ENABLED"] == "1") {
				print(" and the doorbell is currently " . ( ($config["schedule"]["MUTED"] == "1") ? "muted" : "on" ) . ".");
			}
		?>
	<p>
	<p>
		<input type="checkbox" value="1" name="doorbell_silenced" <?php print( ($config["settings"]["SILENCED"] == "1") ? "checked" : null ) ?> /> Mute doorbell (overrides scheduler)
	</p>
	<p>
		<input type="submit" name="store" value="Store" /> <input type="submit" name="doorbell_test" value="Test doorbell" />
	</p>
</form>
