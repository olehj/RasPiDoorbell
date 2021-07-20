<?php
	$config = parse_ini_file("config.ini", true);
	$sound = parse_ini_file("current.ini", true);
	require_once("pages/functions.php");
	
	if($_POST["enter"] && $_POST["userlogin"]) {
		if($_POST["userlogin"] != $config["password"]["USER"]) {
			$login_err = "<p><span class=\"red\">Wrong password.</span></p>";
		}
		else {
			setcookie("login", $_POST["userlogin"], time()+$loginexpire);
			header("Location: /");
			exit;
		}
	}
	else if($_POST["enter"]) {
		$login_err = "<p><span class=\"red\">Enter the user password.</span></p>";
	}
	
	$sound_files = array_values(array_diff(scandir("sounds/"), array('..', '.')));
	for($i=0; $i < count($sound_files); ++$i) {
		$sound_options .= "<option value=\"" . $sound_files[$i] . "\" " . ( ($sound_files[$i] == str_replace("" . getcwd() . "/sounds/", "", readlink("current.wav"))) ? "selected" : null ) . ">" . pathinfo($sound_files[$i], PATHINFO_FILENAME) . "</option>";
	}
	
	$log_file = file($config["settings"]["LOGFILE"]);
	rsort($log_file);
	
	$lastlog = 5;
	
	for($i=0; $i < $lastlog; ++$i) {
		list($datetime, $status) = explode(";", $log_file[$i]);
		$log .= "[" . $datetime . "] " . $status . "<br />\n";
	}
	
	$page = $_GET["page"];
?>
<!DOCTYPE html>
<html lang="no">
<head>
	<title>Doorbell</title>
	<?php print( (doorbell_pid()) ? "<link rel=\"icon\" type=\"image/png\" href=\"/pages/icon_green.png\" />" : "<link rel=\"icon\" type=\"image/png\" href=\"/pages/icon_red.png\" />"); ?>
	<!--<link rel="icon" type="image/png" href="/pages/icon.png" />-->
	<style type="text/css">
		body {
			font : small "verdana", sans-serif;
			background: #3366AA;
			color: #CCCCCC;
		}
		p, ul, li {
			font : small "verdana", sans-serif;
		}
		h1 {
			font : bold medium "verdana", sans-serif;
			padding: 0 0 0 0;
		}
		hr {
			border : 1px solid #CCCCCC;
		}
		.red {
			color: #FF5050;
			font-weight: bold;
		}
		.green {
			color: #50FF50;
			font-weight: bold;
		}
		.menu, .menu:visited {
			font: bold large "tahoma", sans-serif;
			text-decoration: none;
			margin: 4px;
			padding: 2px 5px 2px 5px;
			background: #CCCCCC;
			color: #000000;
			border: 3px solid #000000;
			width: 200px;
			display: block;
		}
		.menu:active, .menu:hover {
			color: #CCCCCC;
			background: #000000;
			cursor: pointer;
		}
	</style>
</head>
<body>
<table style="width: 100%; margin-left: auto; margin-right: auto;">
		<tr>
			<td style="vertical-align: top;">
			<?php
				print("
					<h1>
						Doorbell (
							" . ( (doorbell_pid()) ? "<span class=\"green\">running</span>" : "<span class=\"red\">off</span>") . "
							" . ( ($config["schedule"]["ENABLED"] == "1" && $config["schedule"]["MUTED"] == "1") ? " | <span class=\"red\">muted by scheduler</span>" : null ) . "
							" . ( ($config["settings"]["SILENCED"] == "1") ? " | <span class=\"red\">muted by user</span>" : null ) . "
						)
					</h1>
				");
			?>
			</td>
			<td style="text-align: right; vertical-align: top;">
				<h1>
				<?php
					print(doorbell_uptime());
				?>
				</h1>
			</td>
		</tr>
	</table>
	<hr />
	<table style="width: 100%; margin-left: auto; margin-right: auto;">
		<tr>
			<td style="vertical-align: top;">
				<a href="/" class="menu">Theme Selection</a>
				<a href="/?page=sound" class="menu">Sound Options</a>
				<a href="/?page=upload" class="menu">Upload Sound</a>
				<a href="/?page=delete" class="menu">Delete Theme</a>
				<a href="/?page=schedule" class="menu">Schedule</a>
				<a href="/?page=settings" class="menu">System Settings</a>
				<a href="/?page=logs" class="menu">Logs</a>
			</td>
			<td style="vertical-align: top;">
				<table style="width: 800px; margin-left: auto; margin-right: auto;">
					<tr>
						<td>
							<?php
								if($_COOKIE["login"] != $config["password"]["USER"]) {
									print("
										$login_err
										<form action=\"/\" method=\"post\">
											<p>
												Enter user password to continue:<br />
												<input type=\"password\" name=\"userlogin\" placeholder=\"Password\"/>
												<input type=\"submit\" name=\"enter\" value=\"Login\" />
											</p>
										</form>
									");
								}
								else {
									if($page) { 
										include("pages/" . $page . ".inc.php");
									}
									else {
										include("pages/main.inc.php");
										print("
											<hr />
											<p>
												<b>Last $lastlog logs</b><br />
												$log
											</p>
										");
									}
								}
							?>
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 250px;">
			</td>
		</tr>
	</table>
</body>
</html>
