#!/usr/bin/env python3
import configparser
from pprint import pprint
from datetime import datetime
from dbConnect import DBConnect
from array import *
## Read in Config File
config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')



## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']


db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)

actualMeetingParticipants = db.fetch('participants', fields=['id'], limit=3000,  filters={'meetingID': 109})
mpTable = db.fetch('meeting_participants', fields=['id','participantID', 'meetingID'], filters={'meetingID': 109})
#print(actualMeetingParticipants)
#print(mpTable)
mpTableList = []
for mP in actualMeetingParticipants:
    m = float(mP['id'])
    mi = int(m)
    mpTableList.append(mi)
#print(mpTableList)
aMP = list(actualMeetingParticipants)
#print(aMP)
for p in mpTable:
    pFloat = float(p['participantID'])
    pInt = int(pFloat)
    #print(pInt)
    if pInt in mpTableList:
        print("Participant in 109 Participants List")
        pass
    else:
        print("Participant not in Participants list --- Deleting")
        db.delete('meeting_participants', {'id': p['id']})

db.commit()
db.disconnect()
