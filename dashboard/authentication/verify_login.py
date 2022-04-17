#!/usr/bin/python
import argparse
import sqlite3
import sys
import time

def close():
	con.commit()
	con.close()


parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--password", type=str)

args = parser.parse_args()

con = sqlite3.connect('../project.db')
cur = con.cursor()


# else, get check if username and password exist
cur.execute("SELECT COUNT(*) FROM users WHERE username = ? AND password = ?", [args.username, args.password])
count = cur.fetchone()[0]

# if there is no user with the provided username and password, return 1
if count == 0:
	close()
	sys.exit(1)

# if there exists such a user, create a ticket
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
timeout_time = curr_time + 30

cur.execute("INSERT INTO tickets VALUES (?,?,?)", [ticket_id, args.username, timeout_time])

print(str(ticket_id) + ',' + str(args.username))

close()
sys.exit(0)
