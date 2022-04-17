#!/usr/bin/python
import argparse
import sqlite3
import sys
from utils import getId

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

con = sqlite3.connect('../../../project.db')
cur = con.cursor()

prof_id = getId(args.username)

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
