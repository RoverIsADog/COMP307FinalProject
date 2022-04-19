#!/usr/bin/python3
import argparse
import json
import secrets
import sqlite3
import sys
import time
import pathlib
import pathlib

def close():
	con.commit()
	con.close()

timeout_duration = 3600 # 5 mins
ticket_length = 16

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--password", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")

cur = con.cursor()


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

# Ensure a unique ticket is created
ticket_id = secrets.token_hex(ticket_length)
cur.execute("SELECT ticket_id FROM tickets WHERE ticket_id = ?;", (ticket_id,)) #DO NOT REMOVE THIS COMMA
records = cur.fetchall()
while (ticket_id in records):
	ticket_id = secrets.token_hex(ticket_length)

# timeout is current time plus 30 seconds
curr_time = time.time()
timeout_time = curr_time + timeout_duration

cur.execute("INSERT INTO tickets VALUES (?,?,?);", [ticket_id, args.username, timeout_time])

retDict = {
	"ticket_id": str(ticket_id),
	"username": str(args.username)
}

print(json.dumps(retDict))
# print(str(ticket_id) + ',' + str(args.username))


close()
sys.exit(0)