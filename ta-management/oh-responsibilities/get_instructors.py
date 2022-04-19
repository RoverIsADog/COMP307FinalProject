#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

# DEBUG DEBUG DEBUG
print('"%s","%s"' % ("TA1", "Prof1"))
print('"%s","%s"' % ("TA2", "Prof2"))
print('"%s","%s"' % ("TA3", "Prof3"))
print('"%s","%s"' % ("TA4", "Prof4"))
print('"%s","%s"' % ("TA5", "Prof5"))
print('"%s","%s"' % ("TA6", "Prof6"))

parser = argparse.ArgumentParser()
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
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
