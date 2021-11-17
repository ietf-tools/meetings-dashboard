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


db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)
#Get Meeting 110 list of Session ID's
m110wgList = db.fetch('meeting_sessions', fields=['id', 'title', 'participants', 'parent'], filters={'meetingNumber': meetingNum})
hackParticipantsList = db.fetch('participants', fields=['id', 'username', 'hackathonOnly'], filters={'meetingID': meetingNum, 'hackathonParticipant': 1})
#print(m108wgList)
for wg in m110wgList:
    if wg['parent'] == 'hackathon':
        #print("Hackathon Meeting Skipping!!!")
        next
    else:
        if not wg['participants']:
            print('No Participants Yet')
            next
        else:
            print("Meeting: " + wg['parent'])
            participantList = wg['participants'].split(",")
            #print(participantList)
            for p in hackParticipantsList:
                print("Checking Participant: " + str(p['id']))
                if str(p['id']) in participantList:
                    pUpateFullMeetingParticipant = db.update({'hackathonOnly': 0}, {'id': p['id']}, 'participants')
                    print("Participant: " + str(p['id']) + " is a full attendee")



