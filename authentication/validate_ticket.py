#!/usr/bin/python
import argparse
import sqlite3
import time
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--ticket_id", type=str)

timeout_time = 3600 # 5 mins

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

def close():
	con.commit()
	con.close()


cur.execute("SELECT COUNT(*) FROM tickets WHERE ticket_id = ? AND username = ?;", [args.ticket_id, args.username])
count = cur.fetchone()[0]

# if there is no ticket associated with the provided username, return 1
if count == 0:
	close()
	sys.exit(1)

# if ticket exists, check if timed out
curr_time = time.time()
cur.execute("SELECT timeout FROM tickets WHERE ticket_id = ? AND username = ?;", [args.ticket_id, args.username])
timeout = cur.fetchone()[0]

# if timed out, delete ticket and return 2
if curr_time > float(timeout):
	cur.execute("DELETE FROM tickets WHERE ticket_id = ?;", [args.ticket_id])
	close()
	sys.exit(2)

# if not timed out, update the timeout and check if the provided user has the requested role
# Update timeout
cur.execute("UPDATE tickets SET "
				"timeout = ?"
			"WHERE ticket_id = ? AND username = ?;", [time.time() + timeout_time, args.ticket_id, args.username])

# get student_id for provided username
cur.execute("SELECT student_id, COUNT(*) FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
student_id, num_records = record[0], record[1]

# if user does not exist, return 3
if num_records == 0:
	close()
	sys.exit(3)

# else, the permission is valid, so return 0
else:
	close()
	sys.exit(0)
