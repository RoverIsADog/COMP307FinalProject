#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get the prof's student_id from the ticket username
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
prof_id = record[0]

# Query database for the prof's wishlist
cur.execute("SELECT DISTINCT ta_id FROM wishlists "
			"WHERE prof_id = ? AND course_num = ? AND term_month_year = ?;",
			[prof_id, args.course_num, args.term_month_year])

records = cur.fetchall()
if records is None:
	sys.exit(-1)
else:
	for record in cur.fetchall():
		# get the name of each TA from the wishlist
		cur.execute("SELECT ta_name FROM teacherassistants WHERE student_id = ?;", [record[0]])
		name = cur.fetchone()[0]
		print('"%s"' % name)

con.commit()
con.close()

sys.exit(0)
