<?php
	$config = parse_ini_file("config.ini", true);
	require_once("pages/functions.php");
	sleep(1);
	
	if($config["schedule"]["ENABLED"]) {
		// Monday
		if(date("N") == 1) {
			if($config["schedule"]["MON"]) {
				if(between_current_time("00:00", ($config["schedule"]["SUN_MON"] ? $config["schedule"]["SUN_MON"] : "00:00")) || between_current_time(($config["schedule"]["MON_S"] ? $config["schedule"]["MON_S"] : "23:59"), ($config["schedule"]["MON_E"] ? $config["schedule"]["MON_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Tuesday
		if(date("N") == 2) {
			if($config["schedule"]["TUE"]) {
				if(between_current_time("00:00", ($config["schedule"]["MON_TUE"] ? $config["schedule"]["MON_TUE"] : "00:00")) || between_current_time(($config["schedule"]["MON_S"] ? $config["schedule"]["MON_S"] : "23:59"), ($config["schedule"]["MON_E"] ? $config["schedule"]["MON_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Wednesday
		if(date("N") == 3) {
			if($config["schedule"]["WED"]) {
				if(between_current_time("00:00", ($config["schedule"]["TUE_WED"] ? $config["schedule"]["TUE_WED"] : "00:00")) || between_current_time(($config["schedule"]["WED_S"] ? $config["schedule"]["WED_S"] : "23:59"), ($config["schedule"]["WED_E"] ? $config["schedule"]["WED_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Thursday
		if(date("N") == 4) {
			if($config["schedule"]["THU"]) {
				if(between_current_time("00:00", ($config["schedule"]["WED_THU"] ? $config["schedule"]["WED_THU"] : "00:00")) || between_current_time(($config["schedule"]["THU_S"] ? $config["schedule"]["THU_S"] : "23:59"), ($config["schedule"]["THU_E"] ? $config["schedule"]["THU_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Friday
		if(date("N") == 5) {
			if($config["schedule"]["FRI"]) {
				if(between_current_time("00:00", ($config["schedule"]["THU_FRI"] ? $config["schedule"]["THU_FRI"] : "00:00")) || between_current_time(($config["schedule"]["FRI_S"] ? $config["schedule"]["FRI_S"] : "23:59"), ($config["schedule"]["FRI_E"] ? $config["schedule"]["FRI_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Saturday
		if(date("N") == 6) {
			if($config["schedule"]["SAT"]) {
				if(between_current_time("00:00", ($config["schedule"]["FRI_SAT"] ? $config["schedule"]["FRI_SAT"] : "00:00")) || between_current_time(($config["schedule"]["SAT_S"] ? $config["schedule"]["SAT_S"] : "23:59"), ($config["schedule"]["SAT_E"] ? $config["schedule"]["SAT_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
		// Sunday
		if(date("N") == 7) {
			if($config["schedule"]["SUN"]) {
				if(between_current_time("00:00", ($config["schedule"]["SAT_SUN"] ? $config["schedule"]["SAT_SUN"] : "00:00")) || between_current_time(($config["schedule"]["SUN_S"] ? $config["schedule"]["SUN_S"] : "23:59"), ($config["schedule"]["SUN_E"] ? $config["schedule"]["SUN_E"] : "23:59"))) {
					doorbell("unmute", $config);
				}
				else {
					doorbell("mute", $config);
				}
			}
			else {
				doorbell("unmute", $config);
			}
		}
	}
?>
