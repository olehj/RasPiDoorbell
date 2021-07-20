<?php
$filesize = 102400000; // max allowed size in bytes

if($_POST["upload"] && $_FILES["file"]) {
	print("<b>Please wait while the file is uploading and processing...</b><br />");
	flush();
	$uploadedfile = $_FILES["file"]["tmp_name"];
	$uploadedfilename = trim($_FILES["file"]["name"]);
	$uploadedfilename_shell = escapeshellarg($uploadedfilename);
	copy($uploadedfile, "tmp/" . $uploadedfilename . "");
	if(file_exists("tmp/" . $uploadedfilename . "")) {
		if(filesize("tmp/" . $uploadedfilename . "") <= $filesize) {
			$newfilename = escapeshellarg(pathinfo($uploadedfilename, PATHINFO_FILENAME));
			print("6)" . $newfilename . "");
			exec("ffmpeg -i " . getcwd() . "/tmp/" . $uploadedfilename_shell . " " . getcwd() . "/sounds/" . $newfilename . ".wav");
			exec("touch " . getcwd() . "/sounds_config/" . $newfilename . ".wav.ini");
		}
		else {
			print("<span class=\"red\">The file is larger than " . floor($filesize/1000000) . "MB.</span><br />");
			$error = 1;
		}
	}
	else {
		print("<span class=\"red\">The file did not get uploaded.</span><br />");
		unlink("tmp/" . $uploadedfilename . "");
		$error = 1;
	}
	
	if(!$error) {
		change_sound($newfilename . ".wav");
		unlink("tmp/" . $uploadedfilename . "");
		doorbell("restart", $config);
		print("
			<meta http-equiv=\"refresh\" content=\"0;URL='/?page=sound'\" />
			<span class=\"green\">Upload successfully done, redirecting to <a href=\"/?page=sound\">Sound Options</a>. Please wait or click the link if nothing happens.</span><br />
		");
		flush();
	}
}
?>
<h1>Upload Sound</h1>
<form action="/?page=upload" method="post" enctype="multipart/form-data">
	<p>
		Select file to upload:
		<input type="file" name="file">
		<input type="submit" value="Upload Sound" name="upload">
	</p>
</form>
<p>
	Click "Upload Sound" once and wait until you get redirected.
</p>
