#!/usr/bin/env python3
import configparser
import requests
import json
import os
import sys
import logging
import logging.handlers
from pprint import pprint
from datetime import datetime
from dbConnect import DBConnect
import country_converter as coco
import ipinfo


## Read in Config File
config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')

## Get Meeting Information
meetingInfo = config['DEFAULT']
meetingNum = meetingInfo['MEETINGNUMBER']

## IP Info Login
ipInfoToken = config['IP-INFO']['TOKEN']

## Setup Logging
filename = os.path.abspath(os.path.dirname('/opt/dashboard/storage/logs/script_logs/'))
logfilepath = config['LOGFILES']['USERUPDATES']
log = logging.getLogger('User-Updates')
log.setLevel(logging.DEBUG)
#print(logfilepath)
logHandler = logging.handlers.RotatingFileHandler(os.path.join(filename, 'User-Updates.log'), maxBytes=10485760, backupCount=5)
logFormat = logging.Formatter('%(asctime)s %(levelname)-8s %(message)s', datefmt='%m-%d %H:%M',)

logHandler.setFormatter(logFormat)
log.addHandler(logHandler)
#print(log.handlers())

## Gather API Parameters
api = config['ME-API']
url = api['URL']
token = api['AUTH']
endpoint = "/stats/accesses?unique=true"
reqURL = url + endpoint

## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']

## Query MeetEcho API for Participants
try:
    import http.client as http_client
except ImportError:
    # Python 2
    import httplib as http_client
try:
    response = requests.get(reqURL, headers={"Authorization": "Bearer " + token})
except requests.exceptions.RequestException as e:
    print(e)
    log.error(e)

print(response)
if(response.status_code == 500):
    print("Internal Error -- Stopping")
    sys.exit()
#pprint(response.content)

users = json.loads(response.content)
#pprint(users)
for user in users:
    dataTrackerID = user['user_id']
    if 'fullname' not in user:
        username = "Unknown User Name"
    else:
        username = user['fullname']
    if 'email' not in user:
        email = "Unknown User Email - " + str(dataTrackerID)
        pass
    else:
        email = user['email']
    if 'ip' not in user:
        ipv4Address = "127.1.1.1"
    else:
        ipv4Address = user['ip']
    if 'room' not in user:
        userRoom = "Unknown User Room" + str(dataTrackerID)
    else:
        userRoom = user['room']

    loginTime = user['join_time']
    status = "1"
    print("-----------------------------------")
    print("Checking to see if User exists in Database")
    log.debug('Checking to see if User: ' + username + ' exists in Database')
    db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)
    ue = db.fetch('participants', fields=['id'], filters={'dataTrackerID': dataTrackerID, 'meetingID': meetingNum})
    print("DataTracker ID: ", dataTrackerID)
    #print(ue)
    if not ue:
        ## Check to see if email exists and user has new DataTracker ID
        eamCheck = db.fetch('participants', fields=['id'], filters={'email': email, 'meetingID': meetingNum})
        if not eamCheck:
            print("User Not Found in Database -- Adding")
            logging.info('User: ' + username + ' not found in Database -- Adding')
            handler = ipinfo.getHandler(ipInfoToken)
            userIP = ipv4Address
            userLoc = handler.getDetails(userIP)
            userCity = userLoc.details.get('city', None)
            userState = userLoc.details.get('region', None)
            userCountry = userLoc.details.get('country_name', None)
            userGeoCode = userLoc.details.get('country', None)
            if(userGeoCode):
                region = coco.convert(userCountry, to="continent", not_found="Not Found")
            else:
                region = 'Unknown'
            userInfo = {'username': username, 'email': email, 'ipv4Address': ipv4Address, 'city': userCity, 'state': userState, 'country': userCountry, 'geoCode': userGeoCode, 'status': status, 'login': loginTime,'geo': region, 'dataTrackerID': dataTrackerID, 'meetingID': meetingNum, 'sessionCount': 0, 'lastGeoUpdate': datetime.now(), 'created_at': datetime.now()}
            addUser = db.insert(userInfo, 'participants')
            print(addUser)
            print("User Added --- ", username)
            log.info('User: ' + username + ' added to Database')
    else:
        print("User Found in Database -- Skipping")
        log.debug("User Found in Database -- Skipping")
        pass





