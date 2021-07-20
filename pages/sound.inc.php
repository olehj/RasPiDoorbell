<?php
	if($_POST["doorbell_test"]) { shell_exec("python doorbell-preview.py"); }
	if($_POST["store_sound"]) {
		$sound["sound"]["SOUND_TIME"] = $_POST["sound_time"];
		$sound["sound"]["FADEOUT_TIME"] = $_POST["fadeout_time"];
		$sound["sound"]["SOUND_VOLUME"] = $_POST["sound_volume"];
		
		if(write_ini_file("current.ini", $sound)) {
			doorbell("restart", $config);
			print("<span class=\"green\">New values stored (" . date("H:i:s") . ").</span>");
		}
		else {
			print("<span class=\"red\">Settings did not save.</span><br />");
		}
	}
	
	if(!filesize(readlink("current.ini"))) {
		$sound["sound"]["SOUND_TIME"] = 10;
		$sound["sound"]["FADEOUT_TIME"] = 5000;
		$sound["sound"]["SOUND_VOLUME"] = 1;
		
		write_ini_file("current.ini", $sound);
	}
?>
<form method="post">
	<h1>
		Sound options for "<?php print(pathinfo(str_replace("" . getcwd() . "/sounds/", "", readlink("current.wav")), PATHINFO_FILENAME)); ?>"
	</h1>
	<p>
		<b>Play time in seconds (before fade-out starts):</b><br />
		<input type="number" required min="1" max="600" name="sound_time" value="<?php print(isset($sound["sound"]["SOUND_TIME"]) ? $sound["sound"]["SOUND_TIME"] : 10) ?>" style="width: 50px;" />
	</p>
	<p>
		<b>Fade-out time in microseconds:</b><br />
		<input type="number" min="0" max="60000" name="fadeout_time" value="<?php print(isset($sound["sound"]["FADEOUT_TIME"]) ? $sound["sound"]["FADEOUT_TIME"] : 5000) ?>" style="width: 50px;" />
	</p>
	<p>
		<b>Sound volume:</b><br />
		<input type="range" min="0" max="1" name="sound_volume" value="<?php print(isset($sound["sound"]["SOUND_VOLUME"]) ? $sound["sound"]["SOUND_VOLUME"] : 1) ?>" step=".05" style="width: 100px;" />
	</p>
	<p>
		<input type="submit" name="store_sound" value="Store" /> <input type="submit" name="doorbell_test" value="Test doorbell" /> (testing <i>stored</i> values only)
	</p>
</form>
