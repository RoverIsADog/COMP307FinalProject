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

# get student_id
student_id, num_records = getId(args.username)

# get roles for a given student_id
cur.execute("SELECT role_id FROM assigned WHERE student_id = ?;", [student_id])
records = cur.fetchall()

roles = {2: False, 5: False}
for role in roles:
	for r in records:
		if r[0] == role:
			roles[role] = True
			break


# If TA or prof, query database for all the courses they are assisting
if roles[5] or roles[2]:
	cur.execute("SELECT course_num, term_month_year FROM teaches WHERE student_id = ?;", [student_id])

# if sysop or admin, return all courses
else:
	cur.execute("SELECT course_num, term_month_year FROM courses;")

for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))


con.commit()
con.close()


sys.exit(0)
