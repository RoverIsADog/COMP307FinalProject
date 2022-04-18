#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get username's student_id
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
student_id = record[0]

# get roles for a given username
cur.execute("SELECT role_id FROM assigned WHERE student_id = ?;", [student_id])
records = cur.fetchall()

# print 1 or 0 for each role based on if the user has it or not
for i in range(5):
	role_id = i + 1
	has_role = False
	for r in records:
		if r[0] == role_id:
			print(1)
			has_role = True
			break
	if not has_role:
		print(0)

con.commit()
con.close()

sys.exit(0)
