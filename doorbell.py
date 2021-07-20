# coding=utf-8

import os, time, logging, datetime
os.environ['PYGAME_HIDE_SUPPORT_PROMPT'] = '1'
import pygame
import RPi.GPIO as GPIO
import ConfigParser

config = ConfigParser.ConfigParser()

def ConfigSectionMap(section):
    dict1 = {}
    options = config.options(section)
    for option in options:
        try:
            dict1[option] = config.get(section, option)
            if dict1[option] == -1:
                DebugPrint("skip: %s" % option)
        except:
            print("exception on %s!" % option)
            dict1[option] = None
    return dict1

config.read('config.ini')

# Set doorbell state:
doorbell_enabled = int(ConfigSectionMap("settings")['enabled'])

# Set doorbell silence state:
doorbell_silenced = int(ConfigSectionMap("settings")['silenced'])

# Set logging variable:
logging_enabled = int(ConfigSectionMap("settings")['logging'])

# Set input GPIO for button:
button_pin = int(ConfigSectionMap("button")['button_pin'])

# Set the bouncetime for the switch, default 0.1s
button_bounce = float(ConfigSectionMap("button")['button_bounce'])

# Init logging if enabled:
if logging_enabled:
	logfile = ConfigSectionMap("settings")['logfile'].strip('"')
	logging.basicConfig(filename=logfile,level=logging.DEBUG,format='%(asctime)s;%(message)s', datefmt='%Y-%m-%d %H:%M:%S')

doorbell_schedule_mute = int(ConfigSectionMap("schedule")['muted'])

config.read('current.ini')

# Set the time to play the file unti it starts to fade out, seconds:
sound_time = int(ConfigSectionMap("sound")['sound_time'])

# Fade-out time, microseconds
fadeout_time = int(ConfigSectionMap("sound")['fadeout_time'])

# Set sound volume, 0.0 - 1.0
sound_volume = float(ConfigSectionMap("sound")['sound_volume'])

if doorbell_enabled:
	# Init mixer:
	pygame.mixer.init()
	pygame.mixer.music.load("current.wav")
	pygame.mixer.music.set_volume(sound_volume)
	# Init button:
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(button_pin, GPIO.IN)

while doorbell_enabled:
	if GPIO.input(button_pin) == 0:
		if doorbell_silenced != 1 and doorbell_schedule_mute != 1:
			pygame.mixer.music.play()
			time.sleep(sound_time)
			pygame.mixer.music.fadeout(fadeout_time)
			time.sleep(fadeout_time/1000.0)
			if logging_enabled:
	                        logging.info("Doorbell activated and made sound")
		else:
			time.sleep(5)
			if logging_enabled:
				if doorbell_silenced == 1:
					logging.info("Doorbell activated but muted manually")
				if doorbell_schedule_mute == 1:
					logging.info("Doorbell activated but muted by scheduler")
	time.sleep(button_bounce)

GPIO.cleanup()
