#!/usr/bin/env python3
import configparser
import requests
import json
import logging
import logging.handlers
import os
import sys
from pprint import pprint
import dbConnect
from dbConnect import DBConnect
from datetime import datetime
from datetime import date
from datetime import timedelta


## Read in Config File
config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')

## Get Meeting Information
meetingInfo = config['DEFAULT']
meetingNum = meetingInfo['MEETINGNUMBER']

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

## Gather API Parameters
api = config['ME-API']
url = api['URL']
token = api['AUTH']
endpoint = "/stats/rooms"
reqURL = url + endpoint

## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']

## Query MeetEcho API for Sessions
try:
    import http.client as http_client
except ImportError:
    # Python 2
    import httplib as http_client
try:
    response = requests.get(reqURL, headers={"Authorization": "Bearer " + token})
except requests.exceptions.RequestException as e:
    print(e)

print(response)
if(response.status_code == 500):
    print("Internal Error -- Stopping")
    sys.exit()
#pprint(response.content)

workingGroups = json.loads(response.content)

#pprint(workingGroups)
db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)


for wg in workingGroups:
    duration = wg['duration']
    name = wg['session_name']
    if 'description' not in wg:
        description = "No Description"
    else:
        description = wg['description']

    startDT = datetime.strptime(wg['start_date'], "%Y-%m-%d %H:%M:%S")
    startDay = startDT.strftime("%Y-%m-%d")

    endTime = startDT + timedelta( minutes=duration)
    endDay = endTime.strftime("%Y-%m-%d")

    wgExists = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endDate'], filters={'meetingNumber': meetingNum, 'title': name})
    #print(wgExists)
    if not wgExists:
        print("Meeting Not in Database")
        log.debug("Meeting Not in Database -- Adding")
        wgInfo = {'title': name, 'description': description, 'startDate': startDay, 'endDate': endDay, 'startTime': startDT.strftime("%H:%M:%S"),'endTime': endTime.strftime("%H:%M:%S"), 'meetingNumber': meetingNum, 'created_at': datetime.now()}
        addWG = db.insert(wgInfo, 'meeting_sessions')
        log.debug("Meeting: " + name + " added to Database")
        wgId = db.fetch('meeting_sessions', fields=["id"], filters={'meetingNumber': meetingNum, 'title': name})
        wgId = str(wgId[0]['id'])
        #print(wgId)
        print("Creating Meeting Participants Table for Working Group: "+ name)
        db.cursor.execute("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'IETFDashboard' and table_name = 'wg_" + wgId + "_" + meetingNum + "';")
        tbCheckDict = db.cursor.fetchall()
        tbCheck = tbCheckDict[0]
        print(tbCheck[0])
        if not tbCheck[0]:
            print("Working Group Participants Table Not Present -- Creating")
            log.info("Working Group Participants Table Not Present -- Creating")
            tbAddQuery = db.cursor.execute("CREATE TABLE wg_"+ wgId + "_" + meetingNum + " (id INT AUTO_INCREMENT PRIMARY KEY, wgID DECIMAL(8,0), wgDate DATE, wgRole VARCHAR(64), dataTrackerID DECIMAL(32,0), login TIMESTAMP NULL DEFAULT NULL, logout TIMESTAMP NULL DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NULL DEFAULT NULL)")
            print(tbAddQuery)
            #tbAdd = db.cursor.fetchall(tbAddQuery)
            log.info("Working Group Table: wg_"+ wgId + "_" + meetingNum + "has been created")
        else:
            print("Working Group Participants Table Exists -- Skipping")
            log.info("Working Group Participants Table Exists -- Skipping")

    else:
        if startDay > str(wgExists[0]['startDate']):
            print("----Meeting Exists but with New Start Date----")
            print("Meeting Title: " + name)
            print("Meeting old Start Date: " + str(wgExists[0]['startDate']))
            print("Meeting new Start Date: " + str(startDay))
            print("----Updating Meeting Start Date ----")
            updateSession = db.update({'startDate': startDay, 'updated_at': str(datetime.now())}, {'id': wgExists[0]['id']}, 'meeting_sessions')

        if endDay > str(wgExists[0]['endDate']):
            print("----Meeting Exists but with New End Date----")
            print("Meeting Title: " + name)
            print("Meeting old End Date: " + str(wgExists[0]['endDate']))
            print("Meeting new End Date: " + str(endDay))
            print("----Updating Meeting Start Date ----")
            updateSession = db.update({'endDate': endDay, 'updated_at': str(datetime.now())}, {'id': wgExists[0]['id']}, 'meeting_sessions')

        else:
            print("Meeting " + name + " already in Database -- Skipping")
            log.debug("Meeting " + name + " already in Database -- Skipping")
            wgId = db.fetch('meeting_sessions', fields=["id"], filters={'meetingNumber': meetingNum, 'title': name})
            wgId = str(wgId[0]['id'])
            print("Checking for Meeting Participants Table for Working Group: "+ name)
            db.cursor.execute("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'IETFDashboard' and table_name = 'wg_" + wgId + "_" + meetingNum + "';")
            tbCheckDict = db.cursor.fetchall()
            tbCheck = tbCheckDict[0]
            print("Working Group ID: " + wgId)

            print(tbCheckDict)
            print(tbCheck[0])
            if not tbCheck[0]:
                print("Working Group Participants Table Not Present -- Creating")
                log.info("Working Group Participants Table Not Present -- Creating")
                tbAddQuery = db.cursor.execute("CREATE TABLE wg_"+ wgId + "_" + meetingNum + " (id INT AUTO_INCREMENT PRIMARY KEY, wgID DECIMAL(8,0), wgDate DATE, wgRole VARCHAR(64), dataTrackerID DECIMAL(32,0), login TIMESTAMP NULL DEFAULT NULL, logout TIMESTAMP NULL DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP NULL DEFAULT NULL)")
                print(tbAddQuery)
                #tbAdd = db.cursor.fetchall(tbAddQuery)
                log.info("Working Group Table: wg_"+ wgId + "_" + meetingNum + "has been created")
            else:
                print("Working Group Participants Table Exists -- Skipping")
                log.info("Working Group Participants Table Exists -- Skipping")
