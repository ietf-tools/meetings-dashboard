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
import country_converter as coco
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
#Get Meeting list of Session ID's
participantsWithoutRegion = db.fetch('participants', fields=['id', 'username', 'geoCode','country', 'lastGeoUpdate'], filters={'geo': '', 'meetingID': 108, 'hide': 0})
#print(participantsWithoutRegion)
for p in participantsWithoutRegion:
    region = coco.convert(names=p['geoCode'], to="continent", not_found="Not Found")
    updateGeo = db.update({'geo': region}, {'id': p['id']}, 'participants')
    if updateGeo:
        print('Update Participant: ' + p['username'] + " GEO to " + region)



