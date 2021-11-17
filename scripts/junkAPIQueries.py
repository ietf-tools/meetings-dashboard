#!/usr/bin/env python3
import configparser
import requests
import json
import logging
import sys
from pprint import pprint
from datetime import datetime
from dbConnect import DBConnect


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
endpoint = "/stats/accesses"
reqURL = url + endpoint


## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']

db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)


## Query MeetEcho API for Participants
try:
    import http.client as http_client
except ImportError:
    # Python 2
    import httplib as http_client
#http_client.HTTPConnection.debuglevel = 1
# You must initialize logging, otherwise you'll not see debug output.
#logging.basicConfig()
#logging.getLogger().setLevel(logging.DEBUG)
#requests_log = logging.getLogger("requests.packages.urllib3")
#requests_log.setLevel(logging.DEBUG)
#requests_log.propagate = True

try:
    response = requests.get(reqURL, headers={"Authorization": "Bearer " + token})
except requests.exceptions.RequestException as e:
    print(e)
#print(reqURL)
print(response)
if(response.status_code == 500):
    print("Internal Error -- Stopping")
    sys.exit()
if(response.status_code == 503):
    print("Internal Error -- Stopping")
    sys.exit()
if(response.status_code == 404):
    print("URL Not Found -- Skipping")
    sys.exit()
#pprint(response.content)
userList = json.loads(response.content)

for user in userList:
    userLocal = db.fetch('participants', fields=['id','email','dataTrackerID','hide','login', 'logout', 'status', 'lastGeoUpdate', 'ipv4Address'], filters={'meetingID': meetingNum, 'dataTrackerID': user['user_id']})
    print(user)
    #break
    #if(userLocal['hide'] == 1):
    #    pass
    #if 'leave_time' in user:
    #    logoutTime = datetime.strptime(user['leave_time'], '%Y-%m-%d %H:%M:%S')
    #    if(logoutTime == userLocal["logout"]):
    #        print("User Logout Times Match for User: "+user['username'])
    #        pass
    #    else:
    #        print("User " + user['username'] + " has logged out -- Updating Participant Database")
    #        #db.update({'logout': logoutTime, 'status': 0, 'updated_at': str(datetime.now())}, {'id': userLocal['id']}, 'participants')

    #if 'leave_time' not in user:
       #print(user['fullname'] + " : is Curenntly Online")
