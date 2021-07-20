<?php
	if($_POST["store_schedule"]) {
		$config["schedule"]["ENABLED"] = ( $_POST["schedule_enabled"] ? 1 : 0 );
		$config["schedule"]["MUTED"] = ( $_POST["schedule_muted"] ? 1 : 0 );
		
		$config["schedule"]["MON"] = ( $_POST["schedule_enabled_mon"] ? 1 : 0 );
		$config["schedule"]["SUN_MON"] = ( $_POST["sun_mon"] ? $_POST["sun_mon"] : 0 );
		$config["schedule"]["MON_S"] = ( $_POST["mon_s"] ? $_POST["mon_s"] : 0 );
		$config["schedule"]["MON_E"] = ( $_POST["mon_e"] ? $_POST["mon_e"] : 0 );
		
		$config["schedule"]["TUE"] = ( $_POST["schedule_enabled_tue"] ? 1 : 0 );
		$config["schedule"]["MON_TUE"] = ( $_POST["mon_tue"] ? $_POST["mon_tue"] : 0 );
		$config["schedule"]["TUE_S"] = ( $_POST["tue_s"] ? $_POST["tue_s"] : 0 );
		$config["schedule"]["TUE_E"] = ( $_POST["tue_e"] ? $_POST["tue_e"] : 0 );
		
		$config["schedule"]["WED"] = ( $_POST["schedule_enabled_wed"] ? 1 : 0 );
		$config["schedule"]["TUE_WED"] = ( $_POST["tue_wed"] ? $_POST["tue_wed"] : 0 );
		$config["schedule"]["WED_S"] = ( $_POST["wed_s"] ? $_POST["wed_s"] : 0 );
		$config["schedule"]["WED_E"] = ( $_POST["wed_e"] ? $_POST["wed_e"] : 0 );
		
		$config["schedule"]["THU"] = ( $_POST["schedule_enabled_thu"] ? 1 : 0 );
		$config["schedule"]["WED_THU"] = ( $_POST["wed_thu"] ? $_POST["wed_thu"] : 0 );
		$config["schedule"]["THU_S"] = ( $_POST["thu_s"] ? $_POST["thu_s"] : 0 );
		$config["schedule"]["THU_E"] = ( $_POST["thu_e"] ? $_POST["thu_e"] : 0 );
		
		$config["schedule"]["FRI"] = ( $_POST["schedule_enabled_fri"] ? 1 : 0 );
		$config["schedule"]["THU_FRI"] = ( $_POST["thu_fri"] ? $_POST["thu_fri"] : 0 );
		$config["schedule"]["FRI_S"] = ( $_POST["fri_s"] ? $_POST["fri_s"] : 0 );
		$config["schedule"]["FRI_E"] = ( $_POST["fri_e"] ? $_POST["fri_e"] : 0 );
		
		$config["schedule"]["SAT"] = ( $_POST["schedule_enabled_sat"] ? 1 : 0 );
		$config["schedule"]["FRI_SAT"] = ( $_POST["fri_sat"] ? $_POST["fri_sat"] : 0 );
		$config["schedule"]["SAT_S"] = ( $_POST["sat_s"] ? $_POST["sat_s"] : 0 );
		$config["schedule"]["SAT_E"] = ( $_POST["sat_e"] ? $_POST["sat_e"] : 0 );
		
		$config["schedule"]["SUN"] = ( $_POST["schedule_enabled_sun"] ? 1 : 0 );
		$config["schedule"]["SAT_SUN"] = ( $_POST["sat_sun"] ? $_POST["sat_sun"] : 0 );
		$config["schedule"]["SUN_S"] = ( $_POST["sun_s"] ? $_POST["sun_s"] : 0 );
		$config["schedule"]["SUN_E"] = ( $_POST["sun_e"] ? $_POST["sun_e"] : 0 );
		
		if(write_ini_file("config.ini", $config)) {
			print("<span style=\"color: #00FF00\">New values stored (" . date("H:i:s") . ").</span><br />");
		}
		else {
			print("<span style=\"color: #FF0000\">Settings did not save.</span><br />");
		}
	}
?>
<h1>Schedule</h1>
<p>
	<b>Date and time now is <?php print(date("l, Y-m-d H:i")); ?></b>
</p>
<p>
	Checkbox enables the schedule the current day. If left empty, it will be running entire given day.<br/>
	Time boxes is on or off until reached time. The first box is mainly used for an extension for previous day for longer activities during eg. a weekend.
	For a regular day you might want to set it up between 08:00 and 22:00, delete the first box and use only the two last ones.
	For a weekend day maybe you want to run it from Saturday 10:00 to Sunday 02:00, then put 02:00 at the very first box for Sunday and the middle box at 10:00 for Saturday, leave the last box empty --:--.
</p>
<p>
	<b><span style="padding-left: 2px;"></span> -&gt; On until <span style="padding-left: 26px;"></span> -&gt; Off until <span style="padding-left: 24px;"></span> -&gt; On until</b>
</p>
<form action="/?page=schedule" method="post">
	<p>
		<input type="checkbox" value="1" name="schedule_enabled_mon" <?php print( ($config["schedule"]["MON"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="sun_mon" value="<?php print($config["schedule"]["SUN_MON"]); ?>" />
		<input type="time" step="300" name="mon_s" value="<?php print($config["schedule"]["MON_S"]); ?>" />
		<input type="time" step="300" name="mon_e" value="<?php print($config["schedule"]["MON_E"]); ?>" /> Monday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_tue" <?php print( ($config["schedule"]["TUE"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="mon_tue" value="<?php print($config["schedule"]["MON_TUE"]); ?>" />
		<input type="time" step="300" name="tue_s" value="<?php print($config["schedule"]["TUE_S"]); ?>" />
		<input type="time" step="300" name="tue_e" value="<?php print($config["schedule"]["TUE_E"]); ?>" /> Tuesday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_wed" <?php print( ($config["schedule"]["WED"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="tue_wed" value="<?php print($config["schedule"]["TUE_WED"]); ?>" />
		<input type="time" step="300" name="wed_s" value="<?php print($config["schedule"]["WED_S"]); ?>" />
		<input type="time" step="300" name="wed_e" value="<?php print($config["schedule"]["WED_E"]); ?>" /> Wednesday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_thu" <?php print( ($config["schedule"]["THU"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="wed_thu" value="<?php print($config["schedule"]["WED_THU"]); ?>" />
		<input type="time" step="300" name="thu_s" value="<?php print($config["schedule"]["THU_S"]); ?>" />
		<input type="time" step="300" name="thu_e" value="<?php print($config["schedule"]["THU_E"]); ?>" /> Thursday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_fri" <?php print( ($config["schedule"]["FRI"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="thu_fri" value="<?php print($config["schedule"]["THU_FRI"]); ?>" />
		<input type="time" step="300" name="fri_s" value="<?php print($config["schedule"]["FRI_S"]); ?>" />
		<input type="time" step="300" name="fri_e" value="<?php print($config["schedule"]["FRI_E"]); ?>" /> Friday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_sat" <?php print( ($config["schedule"]["SAT"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="fri_sat" value="<?php print($config["schedule"]["FRI_SAT"]); ?>" />
		<input type="time" step="300" name="sat_s" value="<?php print($config["schedule"]["SAT_S"]); ?>" />
		<input type="time" step="300" name="sat_e" value="<?php print($config["schedule"]["SAT_E"]); ?>" /> Saturday<br />
		
		<input type="checkbox" value="1" name="schedule_enabled_sun" <?php print( ($config["schedule"]["SUN"] == "1") ? "checked" : null ) ?> />
		<input type="time" step="300" name="sat_sun" value="<?php print($config["schedule"]["SAT_SUN"]); ?>" />
		<input type="time" step="300" name="sun_s" value="<?php print($config["schedule"]["SUN_S"]); ?>" />
		<input type="time" step="300" name="sun_e" value="<?php print($config["schedule"]["SUN_E"]); ?>" /> Sunday
	</p>
	<p>
		<input type="checkbox" value="1" name="schedule_enabled" <?php print( ($config["schedule"]["ENABLED"] == "1") ? "checked" : null ) ?> /> Enable Schedule
		<input type="hidden" value="<?php print( ($config["schedule"]["MUTED"] == "1") ? 1 : 0 ) ?>" name="schedule_muted" />
	</p>
	<p>
		<input type="submit" value="Store" name="store_schedule" />
	</p>
</form>
