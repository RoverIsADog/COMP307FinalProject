#!/usr/bin/python
import argparse
import sqlite3
import sys


parser = argparse.ArgumentParser()

parser.add_argument("--student_id", type=int)

args = parser.parse_args()

con = sqlite3.connect('../../project.db')
cur = con.cursor()


# Query database for all assignments of the provided TA to a course
cur.execute("SELECT DISTINCT course_num, term_month_year FROM teaches WHERE student_id = ?", args.student_id)
for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))


con.commit()
con.close()


sys.exit(0)
