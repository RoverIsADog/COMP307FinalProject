#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib


parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)

required_role = 3

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get all logs associated with a given TA
cur.execute("SELECT prof_id, course_num, term_month_year, note FROM logs WHERE ta_id = ?;", [args.student_id])
records = cur.fetchall()
for record in records:
	rec1 = record[1]
	rec2 = record[2]
	rec3 = record[3]
	# get prof name using the ID
	cur.execute("SELECT name FROM professors WHERE professor_id = ? LIMIT 1;", [record[0]])
	prof_name = cur.fetchone()
	print('"%s","%s","%s","%s"' % (prof_name[0], rec1, rec2, rec3))


con.commit()
con.close()


sys.exit(0)
