#!/usr/bin/env python3
import configparser
import requests
import json
import fcntl
import os
import sys
import time
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
log = logging.getLogger('User-Updates')
log.setLevel(logging.DEBUG)
#print(logfilepath)
logHandler = logging.handlers.RotatingFileHandler(os.path.join(filename, 'User-Updates.log'), maxBytes=10485760, backupCount=5)
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

users = db.fetch('participants', fields=['id', 'username', 'dataTrackerID', 'login', 'logout', 'ipv4Address', 'lastGeoUpdate'], filters={'meetingID': meetingNum, 'status': 1, 'hide': 0})

t = time.localtime()
current_time = time.strftime("%H:%M:%S", t)
print(current_time)
for user in users:
    print('------------------')
    #print("ID: " + str(user['id']))
    print("DataTrackerID: " + str(user['dataTrackerID']))
    print("User Fullname: " + user['username'])

    endpoint = "/stats/users/"+ str(user['dataTrackerID']) + "/accesses"
    reqURL = url + endpoint

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

    print(response)
    if(response.status_code == 500):
        print("Internal Error -- Skipping")
        pass
    #pprint(response.content)
    if(response.status_code == 503):
        print("Internal Error -- Trying Again")
        time.sleep(2)
        try:
            response = requests.get(reqURL, headers={"Authorization": "Bearer " + token})
        except requests.exceptions.RequestException as e:
            print(e)
        if(response.status_code == 503):
            print("Internal Error -- Skipping")
            pass
        continue
    if(response.status_code == 200):
        if response.content:
            userInfo = json.loads(response.content)
            #print(userInfo)
        else:
            print("No response from API or Invalid Request")
            print(response)
            pass
        #print(userInfo)
        if userInfo:
            if len(userInfo) == 1:
                userLast = userInfo[0]
            else:
                userLast = userInfo[-1]
            #print("User Last Sign-In Time: " + userLast['join_time'])
            #print("Local User Sign-In Time: " + user['login'])
            #pprint(userLast)

            if 'leave_time' not in userLast:
                ## User is Currently Online - or hasn't been marked as Logged Out
                ## Check to see if User has Geo Updated since last Logout
                print("User Online Checking to see if GeoLocation needs Updating.")
                log.debug("User: " + user['username'] + " is Online -- Checking GeoUpdate Needs")
                #print(userLast['join_time'])
                userJoinTime = datetime.strptime(userLast['join_time'], "%Y-%m-%d %H:%M:%S")
                if(userJoinTime > user['lastGeoUpdate']):
                    print("User Geo Information Needs Updating")
                    log.debug("User Needs GeoUpdating -- ")
                    ## Get IP Information for Latest Login
                    handler = ipinfo.getHandler(ipInfoToken)
                    userIP = userLast['ip']
                    userLoc = handler.getDetails(userIP)
                    userCity = userLoc.details.get('city', None)
                    userState = userLoc.details.get('region', None)
                    userCountry = userLoc.details.get('country_name', None)
                    userGeoCode = userLoc.details.get('country', None)
                    userGeo = coco.convert(names=userGeoCode, to="continent", not_found="Not Found")
                    print("               -------- User Location Information ---------")
                    print("   User City: ", userCity)
                    print("   User State: ", userState)
                    print("   User Country: ", userCountry)
                    print("   User Country Code: ", userGeoCode)
                    ##Insert Updates into Database
                    userUpdate = db.update({'status': 1, 'city': userCity, 'ipv4Address': userIP, 'state': userState, 'country': userCountry, 'geoCode': userGeoCode, 'geo': userGeo, 'updated_at': str(datetime.now()), 'lastGeoUpdate': str(datetime.now())}, {'id': user['id']}, 'participants')
                    print(userUpdate)
                    db.commit()
                else:
                    log.debug("User Geo Up-to-Date")
                    log.debug("Updating User Status")
                    userUpdate = db.update({'status': 1, 'updated_at': str(datetime.now())}, {'id': user['id']}, 'participants')
                    #print(userUpdate)
                    log.debug("User Status Updated to Online")
                    db.commit()

            else:
                userLastLogin = datetime.strptime(userLast['join_time'], '%Y-%m-%d %H:%M:%S')
                userLastLogoff = datetime.strptime(userLast['leave_time'], '%Y-%m-%d %H:%M:%S')
                if(user['login'] < userLastLogin):

                    ## User has been Online since last record check / Need to update Login List, and run GeoLocation
                    print("Updating User Login Status")
                    log.info("User: " + user['username'] + " has logged off")
                    userLogins = userLast['join_time']
                    print(userLogins)

                    ## Get IP Information for Latest Login
                    handler = ipinfo.getHandler(ipInfoToken)
                    userIP = userLast['ip']
                    userLoc = handler.getDetails(userIP)
                    userCity = userLoc.details.get('city', None)
                    userState = userLoc.details.get('region', None)
                    userCountry = userLoc.details.get('country_name', None)
                    userGeoCode = userLoc.details.get('country', None)
                    userGeo = coco.convert(names=userGeoCode, to="continent", not_found="Not Found")
                    print("               -------- User Location Information ---------")
                    print("   User City: ", userCity)
                    print("   User State: ", userState)
                    print("   User Country: ", userCountry)
                    print("   User Country Code: ", userGeoCode)



                    ##Insert Updates into Database
                    userUpdate = db.update({'login': userLogins, 'city': userCity, 'ipv4Address': userIP, 'state': userState, 'country': userCountry, 'geoCode': userGeoCode, 'geo': userGeo, 'updated_at': str(datetime.now()), 'status':1, 'lastGeoUpdate': str(datetime.now())}, {'id': user['id']}, 'participants')
                    print(userUpdate)
                    db.commit()
                if not user['logout']:
                    print("---- User First Log Off ---")
                    print("  Updating Database  ")
                    ## User has gone Offline since last record check / Need to update Logout List, and set Status Offline
                    userUpdate = db.update({'logout': userLastLogoff, 'status': 0, 'updated_at': str(datetime.now())}, {'id': user['id']}, 'participants')
                    print(userUpdate)
                    db.commit()
                else:
                    if(user['logout'] <= userLastLogoff):
                        print("---- User Logged Off ---")
                        print("  Updating Database  ")
                        ## User has gone Offline since last record check / Need to update Logout List, and set Status Offline
                        print("Updating User Login Status")
                        userLogouts = userLastLogoff
                        print(userLogouts)
                        userUpdate = db.update({'logout': userLogouts, 'status': 0, 'updated_at': str(datetime.now())}, {'id': user['id']}, 'participants')
                        print(userUpdate)
                        db.commit()
        time.sleep(2)

