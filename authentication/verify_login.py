#!/usr/bin/python
import argparse
import sqlite3
import sys
import time
import os
import pathlib
import pathlib

def close():
	con.commit()
	con.close()

timeOutTime = 3600

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--password", type=str)

args = parser.parse_args()

# print("checkpoint1")
# print(args.username)
# print(args.password)
# print(os.getcwd())

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")

#print(os.getcwd())
#print("checkpoint2")

cur = con.cursor()

#print("checkpoint3")

# else, get check if username and password exist
cur.execute("SELECT COUNT(*) FROM users WHERE username = ? AND password = ?;", [args.username, args.password])
count = cur.fetchone()[0]

# if there is no user with the provided username and password, return 1
if count == 0:
	close()
	sys.exit(1)


# if there exists such a user, delete existing tickets for that
# user and create a new ticket
cur.execute("DELETE FROM tickets WHERE username = ?;", [args.username])
# find unique ID
ticket_id = 1
cur.execute("SELECT ticket_id FROM tickets ORDER BY ticket_id;")
records = cur.fetchall()
if records is not None:
	for record in records:
		if ticket_id == record[0]:
			ticket_id += 1

# timeout is current time plus 30 seconds
curr_time = time.time()
timeout_time = curr_time + timeOutTime

cur.execute("INSERT INTO tickets VALUES (?,?,?);", [ticket_id, args.username, timeout_time])

print(str(ticket_id) + ',' + str(args.username))

close()
sys.exit(0)
