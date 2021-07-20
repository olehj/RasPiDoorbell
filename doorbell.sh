#!/bin/bash
if [[ "`pidof -x $(basename $0) -o %PPID`" ]]; then
	exit 1
fi

python /home/pi/doorbell.py
