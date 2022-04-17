#!/usr/bin/python
import sqlite3
import sys

con = sqlite3.connect('../../../project.db')
cur = con.cursor()

# query database for all users, except for genesis account (student_id -1)
cur.execute("SELECT student_id, name, email FROM users WHERE student_id != -1;")
records = cur.fetchall()

# for each user, get a list of their permissions and print out everything
for record in records:
	# get roles for a given student_id
	cur.execute("SELECT role_id FROM assigned WHERE student_id = ?;", [record[0]])
	output = cur.fetchall()

	roles = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0}
	for role in roles:
		for r in output:
			if r[0] == role:
				roles[role] = 1
				break

	# print all the information
	print('"%s","%s","%s","%s","%s","%s","%s","%s"' % (record[0], record[1], record[2],
													   roles[1], roles[2], roles[3], roles[4], roles[5]))

con.commit()
con.close()
sys.exit(0)
