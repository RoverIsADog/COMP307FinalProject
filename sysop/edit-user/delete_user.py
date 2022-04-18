#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()

parser.add_argument("--student_id", type=int)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get roles for a given student_id
cur.execute("SELECT role_id FROM assigned WHERE student_id = ?;", [args.student_id])
records = cur.fetchall()

roles = {1: False, 2: False, 3: False, 4: False, 5: False}
for role in roles:
	for r in records:
		if r[0] == role:
			roles[role] = True
			break

# remove all roles assigned with this user
cur.execute("DELETE FROM assigned WHERE student_id = ?;", [args.student_id])

# if user is a student, remove all registered courses
if roles[1]:
	cur.execute("DELETE FROM registered WHERE student_id = ?;", [args.student_id])

# if user is a professor, make the corresponding record in professors table a temporary record
if roles[2]:
	# generate temp_id
	temp_id = 1
	cur.execute("SELECT professor_id FROM professors ORDER BY professor_id;")
	records = cur.fetchall()
	if records is not None:
		for record in records:
			if temp_id == record[0]:
				temp_id += 1

			# update id in professors table and make the record temporary
			cur.execute("UPDATE professors SET professor_id = ?, is_temporary = 1 WHERE professor_id = ?;",
						[temp_id, args.student_id])

			# update id in the teaches table
			cur.execute("UPDATE teaches SET student_id = ? WHERE student_id = ?;", [temp_id, args.student_id])

			# update id in the officehours table
			cur.execute("UPDATE officehours SET student_id = ? WHERE student_id = ?;", [temp_id, args.student_id])

			# update id in the wishlist table
			cur.execute("UPDATE wishlists SET prof_id = ? WHERE prof_id = ?;", [temp_id, args.student_id])


# delete user record
cur.execute("DELETE FROM users WHERE student_id = ?;", [args.student_id])

con.commit()
con.close()
sys.exit(0)
