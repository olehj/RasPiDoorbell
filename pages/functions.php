<?php
$login_password = $config["password"]["USER"];
$settings_password = $config["password"]["ADMIN"];
$loginexpire = 60*60*24; // 24 timer

if (!function_exists('write_ini_file')) {
    /**
     * Write an ini configuration file
     * 
     * @param string $file
     * @param array  $array
     * @return bool
     */
    function write_ini_file($file, $array = []) {
        // check first argument is string
        if (!is_string($file)) {
            throw new \InvalidArgumentException('Function argument 1 must be a string.');
        }

        // check second argument is array
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Function argument 2 must be an array.');
        }

        // process array
        $data = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $data[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    if (is_array($sval)) {
                        foreach ($sval as $_skey => $_sval) {
                            if (is_numeric($_skey)) {
                                $data[] = $skey.'[] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            } else {
                                $data[] = $skey.'['.$_skey.'] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            }
                        }
                    } else {
                        $data[] = $skey.' = '.(is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"'.$sval.'"'));
                    }
                }
            } else {
                $data[] = $key.' = '.(is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"'.$val.'"'));
            }
            // empty line
            $data[] = null;
        }

        // open file pointer, init flock options
        $fp = fopen($file, 'w');
        $retries = 0;
        $max_retries = 100;

        if (!$fp) {
            return false;
        }

        // loop until get lock, or reach max retries
        do {
            if ($retries > 0) {
                usleep(rand(1, 5000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

        // couldn't get the lock
        if ($retries == $max_retries) {
            return false;
        }

        // got lock, write data
        fwrite($fp, implode(PHP_EOL, $data).PHP_EOL);

        // release lock
        flock($fp, LOCK_UN);
        fclose($fp);

        return true;
    }
}

function between_current_time($start, $end) {
	$current_time = date("H:i");
	$date1 = DateTime::createFromFormat('H:i', $current_time);
	$date2 = DateTime::createFromFormat('H:i', $start);
	$date3 = DateTime::createFromFormat('H:i', $end);
	if ($date1 >= $date2 && $date1 <= $date3) {
		return true;
	}
	else {
		return false;
	}
}

function doorbell($mode, $config) {
	/*	Program modes:
		- start		start program
		- stop		stop program
		- restart	restart program
		- mute		mute program
		- unmute	unmute program
		- reboot	reboot device
		- poweroff	poweroff device
	*/
	switch($mode) {
		case "start":
			$config["settings"]["ENABLED"] = 1;
			write_ini_file("config.ini", $config);
			shell_exec("" . getcwd() . "/doorbell.sh >/dev/null 2>/dev/null &");
			break;
		case "stop":
			$config["settings"]["ENABLED"] = 0;
			write_ini_file("config.ini", $config);
			exec("killall -9 python doorbell.sh");
			break;
		case "restart":
			exec("killall -9 python doorbell.sh");
			sleep(1);
			shell_exec("" . getcwd() . "/doorbell.sh >/dev/null 2>/dev/null &");
			break;
		case "mute":
			exec("killall -9 python doorbell.sh");
			sleep(1);
			$config["schedule"]["MUTED"] = 1;
			write_ini_file("config.ini", $config);
			shell_exec("" . getcwd() . "/doorbell.sh >/dev/null 2>/dev/null &");
			break;
		case "unmute":
			exec("killall -9 python doorbell.sh");
			sleep(1);
			$config["schedule"]["MUTED"] = 0;
			write_ini_file("config.ini", $config);
			shell_exec("" . getcwd() . "/doorbell.sh >/dev/null 2>/dev/null &");
			break;
		case "reboot":
			exec("killall -9 python doorbell.sh");
			exec("sudo /sbin/reboot");
			break;
		case "poweroff":
			exec("killall -9 python doorbell.sh");
			exec("sudo /sbin/halt");
			break;
		default:
			break;
	}
}

function change_sound($sound) {
	unlink("" . getcwd() . "/current.wav");
	unlink("" . getcwd() . "/current.ini");
	exec("ln -s " . getcwd() . "/sounds/" . $sound . " " . getcwd() . "/current.wav");
	exec("ln -s " . getcwd() . "/sounds_config/" . $sound . ".ini " . getcwd() . "/current.ini");
}

function purge_logs() {
	unlink("" . getcwd() . "/" . $config["settings"]["LOGFILE"] . "");
}

function purge_sound($sound) {
	unlink("" . getcwd() . "/sounds/" . $sound . "");
	unlink("" . getcwd() . "/sounds_config/" . $sound . ".ini");
}

function doorbell_pid() {
	return shell_exec("pidof -x doorbell.sh");
}

function doorbell_uptime() {
	return shell_exec("uptime -p");
}
?>
