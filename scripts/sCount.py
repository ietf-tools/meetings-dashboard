#!/usr/bin/env python3
import configparser
import sys
import mysql.connector
from mysql.connector import Error
from datetime import datetime
from dbConnect import DBConnect
import os
import logging
import logging.handlers

config = configparser.ConfigParser()

config.read('/opt/dashboard/scripts/config.conf')

## Get Meeting Information
meetingInfo = config['DEFAULT']
meetingNum = meetingInfo['MEETINGNUMBER']

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

## Connect to Database

db = DBConnect(host = dbHost, user=dbUser, password=dbPassword, database=dbDatabase)

meetingSessions = db.fetch('meeting_sessions', fields=['id', 'title'], filters={'meetingNumber': meetingNum, '`show`': 0})
numberOfPs = len(meetingSessions)
for sess in meetingSessions:
    print("Session Title: ", sess['title'])
    query = "SELECT dataTrackerID, count(distinct(dataTrackerID)) from wg_" + str(sess['id']) + "_" + str(meetingNum) + " group by dataTrackerID;"
    #print(query)
    db.cursor.execute(query)
    wgPs = db.cursor.fetchall()
    wgPCount = len(wgPs)
    print("Number of Participants: ", wgPCount)

    db.update({'totalParticipantCount': wgPCount}, {'id': sess['id']}, 'meeting_sessions')

#print(meetingSessions)
#print("Number of Sessions: ", numberOfPs)



#select dataTrackerID, count(distinct(dataTrackerID)) from wg_102_108 group by dataTrackerID;
