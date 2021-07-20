<?php
	if($_POST["delete"] && $_POST["delete_check"]) {
		purge_sound($_POST["del_soundfile"]);
		
		print("<span class=\"green\">Theme \"" . $_POST["del_soundfile"] . "\" deleted (" . date("H:i:s") . ").</span>");
	}
	else if($_POST["delete"]) {
		print("<span class=\"red\">Click the checkbox before deleting a theme.</span>");
	}
	
	$del_sound_files = array_values(array_diff(scandir("sounds/"), array('..', '.')));
	for($i=0; $i < count($del_sound_files); ++$i) {
		$del_sound_options .= "<option value=\"" . $del_sound_files[$i] . "\" " . ( ($del_sound_files[$i] == str_replace("" . getcwd() . "/sounds/", "", readlink("current.wav"))) ? "disabled" : null ) . ">" . pathinfo($del_sound_files[$i], PATHINFO_FILENAME) . "</option>";
	}
?>
<h1>Delete Theme</h1>
<form action="/?page=delete" method="post">
	<p>
		<b>Select sound theme to delete:</b><br />
		<select name="del_soundfile">
			<?php print($del_sound_options); ?>
		</select>
	</p>
	<p>
		<input type="checkbox" value="1" name="delete_check" /> Check the box and click <input type="submit" name="delete" value="Delete" />
	</p>
</form>
