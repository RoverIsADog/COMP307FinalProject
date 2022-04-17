#!/usr/bin/python
import argparse
import sqlite3
import sys

parser = argparse.ArgumentParser()
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

con = sqlite3.connect('../../../project.db')
cur = con.cursor()

# Query database for all the instructors in a given course
cur.execute("SELECT DISTINCT student_id, name "
			"FROM teaches "
			"WHERE course_num = ? AND term_month_year = ?;", [args.course_num, args.term_month_year])
for record in cur.fetchall():
	print('"%s","%s"' % (record[0], record[1]))

con.commit()
con.close()

sys.exit(0)
