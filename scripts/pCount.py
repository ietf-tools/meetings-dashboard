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

## Debug ##
## Print Python Version in CLI
##print('Python Version: ')
##print(sys.version)

## Read in Config File
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

db.cursor.execute("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'IETFDashboard' and table_name = 'pct" + meetingNum + "';")
tbCheckDict = db.cursor.fetchall()
tbCheck = tbCheckDict[0]
#print(tbCheck[0])
if not tbCheck[0]:
    log.info("Participant Count Table Not Present -- Creating")
    db.cursor.execute("CREATE TABLE pct"+ meetingNum + " (id INT AUTO_INCREMENT PRIMARY KEY, pCount DECIMAL(20,0), check_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)")
    ##print(tbAddQuery)
    tbAdd = db.cursor.fetchall()
    log.info("Participant Count Table: pct" + meetingNum + "has been created")
else:
    db.cursor.execute("SELECT COUNT(*) FROM participants WHERE status=1 AND hide=0 AND meetingID="+ meetingNum +";")
    ps = db.cursor.fetchall()
    log.info("Number of Participants Currently Online: " + str(ps[0][0]))
    pcAdd = db.insert({'pCount': str(ps[0][0])}, 'pct' + meetingNum)
    log.info("Updated Table with Count")
    #print("Count Updated")
    db.commit()