#!/usr/bin/env python3
import configparser
import requests
import json
import time
import os
import logging
import logging.handlers
from pprint import pprint
from datetime import datetime
from datetime import timedelta
from dbConnect import DBConnect
import ipinfo
## Read in Config File
config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')

## Get Meeting Information
meetingInfo = config['DEFAULT']
meetingNum = meetingInfo['MEETINGNUMBER']

## Gather API Parameters
api = config['ME-API']
url = api['URL']
token = api['AUTH']

## IP Info Login
ipInfoToken = config['IP-INFO']['TOKEN']

## Setup Logging
filename = os.path.abspath(os.path.dirname('/opt/dashboard/storage/logs/script_logs/'))
logfilepath = config['LOGFILES']['USERUPDATES']
log = logging.getLogger('Session-Updates')
log.setLevel(logging.DEBUG)
#print(logfilepath)
logHandler = logging.handlers.RotatingFileHandler(os.path.join(filename, 'Session-Updates.log'), maxBytes=10485760, backupCount=5)
logFormat = logging.Formatter('%(asctime)s %(levelname)-8s %(message)s', datefmt='%m-%d %H:%M',)

logHandler.setFormatter(logFormat)
log.addHandler(logHandler)
#print(log.handlers())



## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']

today = datetime.now().strftime("%Y-%m-%d")
yesturday = datetime.now() + timedelta(days=-1)

td = today
yest = yesturday.strftime("%Y-%m-%d")
#print(yest.strftime("%Y-%m-%d"))

db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)
#Get Meeting 109 list of Session ID's
tDwgs = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endTime', 'participants', 'parent'], filters={'meetingNumber': meetingNum, '`show`': 0, 'startDate': td})
yDwgs = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endTime', 'participants', 'parent'], filters={'meetingNumber': meetingNum, '`show`': 0, 'startDate': yest})
wgs = tDwgs + yDwgs
#wgs = db.cursor.execute("SELECT * FROM meeting_sessions WHERE meetingNumber = " + meetingNum +" AND startDate = " + td)
print(wgs)
for wg in wgs:
    startDate = wg['startDate']
    print("Working Group: "+wg['parent']+"\n")
    print("Started On: "+ str(startDate)+"\n")
#print(m108wgList)
#Get List of Distinct Participants in Each Session and Increment their SessionCount (in Participants)
#for wg in m109wgList:
#    #print(wg['id'])
#    participantList = db.cursor.fetchall()
#    #print(participantList)
#    for p in participantList:
#        #print(p[0])
#        wgParticipantsUpdate = db.increment('participants', ['sessionCount'], steps=1, filters={'dataTrackerID': p[0], 'meetingID': 109})
##print(wgParticipantsUpdate)
