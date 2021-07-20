# coding=utf-8

import os, time
os.environ['PYGAME_HIDE_SUPPORT_PROMPT'] = '1'
import pygame
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

config.read('current.ini')

# Set the time to play the file unti it starts to fade out, seconds:
sound_time = int(ConfigSectionMap("sound")['sound_time'])

# Fade-out time, microseconds
fadeout_time = int(ConfigSectionMap("sound")['fadeout_time'])

# Set sound volume, 0.0 - 1.0
sound_volume = float(ConfigSectionMap("sound")['sound_volume'])

# Init mixer:
pygame.mixer.init()
pygame.mixer.music.load("current.wav")
pygame.mixer.music.set_volume(sound_volume)

pygame.mixer.music.play()
time.sleep(sound_time)
pygame.mixer.music.fadeout(fadeout_time)
time.sleep(fadeout_time/1000.0)
