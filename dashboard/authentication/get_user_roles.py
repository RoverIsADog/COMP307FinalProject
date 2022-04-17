#!/usr/bin/python
import argparse
import sqlite3
import sys
from utils import getId

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

args = parser.parse_args()

con = sqlite3.connect('../project.db')
cur = con.cursor()

# get username's student_id
student_id, num_records = getId(args.username)

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
