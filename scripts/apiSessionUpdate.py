#!/usr/bin/env python3
import configparser
import requests
import json
import time
import os
import sys
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

db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)

today = datetime.now().strftime("%Y-%m-%d")
yesturday = datetime.now() + timedelta(days=-1)

td = today
yest = yesturday.strftime("%Y-%m-%d")
print(td)

tDwgs = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endTime', 'participants', 'parent'], filters={'meetingNumber': meetingNum, '`show`': 0, 'startDate': td})
yDwgs = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endTime', 'participants', 'parent'], filters={'meetingNumber': meetingNum, '`show`': 0, 'startDate': yest})
wgs = tDwgs + yDwgs


#wgs = db.fetch('meeting_sessions', fields=['id', 'title', 'startDate', 'endTime', 'participants'], filters={'meetingNumber': meetingNum, '`show`': 0})
td = datetime.now()
for wg in wgs:
    print('------------------')
    #print("ID: " + str(user['id']))
    print("Working Group ID: " + str(wg['id']))
    print("Working Group Title: " + wg['title'])

    endpoint = "/stats/rooms/"+ str(wg['title']) + "/accesses"
    reqURL = url + endpoint

    ## Query MeetEcho API for Session Participants
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
        pass
        #sys.exit()
    if(response.status_code == 503):
        print("Internal Error -- Stopping")
        pass
        #sys.exit()
    #pprint(response.content)
    if(response.status_code == 404):
        print("URL Not Found -- Skipping")
        pass
    if(response.status_code == 200):
        if response.content:
            wgInfo = json.loads(response.content)
        else:
            print("No response from API or Invalid Request")
            print(response)
            pass
        #print(wgInfo)
        for user in wgInfo:
            wgPT = "wg_" + str(wg['id']) + "_" + str(meetingNum)
            if 'user_id' not in user:
                pass
            else:
                userID = user['user_id']
            if 'join_time' not in user:
                login = ""
            else:
                login = user['join_time']
            if 'role' not in user:
                role = "No Role"
            else:
                role = user['role']
            if 'leave_time' not in user:
                logout = ""
            else:
                logout = user['leave_time']

            ckrow = db.fetch(wgPT, fields=['id', 'logout'], filters={'dataTrackerID': userID, 'login': login})
            localUserID = db.fetch('participants', fields=['id'], filters={'dataTrackerID': userID, 'meetingID': meetingNum})
            #print(localUserID[0]['id'])
            #print(localUserID)
            if not localUserID:
                pass
            else:
                lUID = str(localUserID[0]['id'])
                #print("WG Participants: " + wg['participants'])
                #print("Pariticpant ID: " + lUID)
                #print(ckrow)
                if not ckrow:
                    if 'join_time' not in user:
                        pass
                    else:
                        wgDT = datetime.strptime(user['join_time'], "%Y-%m-%d %H:%M:%S")
                        wgDate = wgDT.strftime("%Y-%m-%d")
                        userAddQuery = {'wgID': wg['id'],'dataTrackerID': userID, 'wgRole': role, 'wgDate': wgDate, 'login': login, 'logout': logout, 'created_at': datetime.now()}
                        userAdd = db.insert(userAddQuery, wgPT)
                        #print(userAdd)
                        db.commit()
                        log.debug("User: " + user['fullname'] + " ID: " + str(userID) + " was added to WG Participant Table")
                        print("User: " + user['fullname'] + " ID: " + str(userID) +" was added to WG Participant Table. With login time: " + login)
                elif 'logout' not in ckrow[0]:
                    print("User was last logged in -- Checking to see if still online.")
                    if 'leave_time' not in user:
                        pass
                    else:
                        logout = user['leave_time']
                        print(ckrow[0]['id'])
                        print("User has logged out Updating Logout time")
                        updateLogOff = db.update({'logout': logout, 'updated_at': str(datetime.now())}, {'id': ckrow[0]['id']}, wgPT)
                        db.commit()
                        print(updateLogOff)
                else:
                    print("Row Already Present -- Skipping")

                wgPs = db.fetch('meeting_sessions', fields=['participants'], filters={'id': wg['id'], 'meetingNumber': meetingNum})

                if not wgPs[0]['participants']:
                    print("Working Group Participants Empty -- Adding Fist Participant")
                    wgParticipantsFirstInsert = db.update({'participants': str(lUID), 'updated_at': str(datetime.now())}, {'id': wg['id']}, 'meeting_sessions')
                    #print(wgParticipantsFirstInsert)
                    db.commit()
                else:
                    #print(wgPs[0]['participants'])
                    if lUID not in wgPs[0]['participants']:
                        print("User is not listed in the Working Group Participants List -- Adding")
                        wgParticipantsLocal = str(wgPs[0]['participants'])
                        #print(wgParticipantsLocal)
                        wgParticipantsLocalList = wgParticipantsLocal.split(",")
                        wgParticipantsLocalList.append(lUID)
                        wgParticipants = ","
                        wgParticipants = wgParticipants.join(wgParticipantsLocalList)
                        wgParticipantsUpdate = db.update({'participants': wgParticipants, 'updated_at': str(datetime.now())}, {'id': wg['id']}, 'meeting_sessions')
                        db.commit()
                        #print(wgParticipantsUpdate)
                        print("Participant Added to the Meeting Session")
                    else:
                        #print("Participant already listed in Meeting Session")
                        print("")

                mPL = db.fetch('meeting_participants', fields=['participantID'], filters={'sessionID': wg['id'], 'participantID': lUID, 'meetingID': meetingNum})
                if not mPL:
                    ##Add Participant Attendance to Meeting_Participants Table
                    hideStatus = db.fetch('participants', fields=['hide'], filters={'meetingID': meetingNum, 'id': lUID })
                    hideFloat = float(hideStatus[0]['hide'])
                    hideInt = int(hideFloat)
                    print(hideInt)
                    if(hideInt == 0):
                        addParticipantQ = {'sessionID': wg['id'], 'participantID': lUID, 'meetingID': meetingNum, 'created_at': datetime.now()}
                        addParticipant = db.insert(addParticipantQ, 'meeting_participants')
                        incParticipantSC = db.increment('participants', ['sessionCount'], steps=1, filters={'dataTrackerID': lUID, 'meetingID': meetingNum})
                        print(addParticipant)
                        db.commit()
                else:
                    pass
        time.sleep(2)
