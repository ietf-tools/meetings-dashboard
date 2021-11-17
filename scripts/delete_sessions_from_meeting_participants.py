#!/usr/bin/env python3
import configparser
from pprint import pprint
from datetime import datetime
from dbConnect import DBConnect
## Read in Config File
config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')



## Gather Database Parameters
dbUser = config['DATABASE']['DB_USERNAME']
dbPassword = config['DATABASE']['DB_PASSWORD']
dbHost = config['DATABASE']['DB_HOST']
dbDatabase = config['DATABASE']['DB_DATABASE']


db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)

hiddenParts = db.fetch('meeting_sessions', filters={'`show`': 1})
for p in hiddenParts:
    d = db.delete('meeting_participants', {'sessionID': p['id']})
    #d = db.cursor.execute("DELETE from meeting_participants where participantID = "+str(p['id']))
    if d:
        print("User with Name: "+p['username']+" deleted from Table Meeting_Participants")
    else:
        print("Nothing Deleted")
db.commit()
db.disconnect()
