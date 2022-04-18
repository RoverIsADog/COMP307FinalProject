#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib


parser = argparse.ArgumentParser()
parser.add_argument("--name", type=str)
parser.add_argument("--student_id", type=int)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--assigned_hours", type=int)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# add info to database
# check if the match already exists in the database
cur.execute("SELECT COUNT(*) FROM teaches WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
			[args.student_id, args.course_num, args.term_month_year])
# If it does not exist, create a new record. Otherwise, update the existing record
if cur.fetchone()[0] == 0:
	cur.execute("INSERT INTO teaches VALUES (?,?,?,?,?)",
				[args.course_num, args.student_id, args.term_month_year, args.name, args.assigned_hours])
else:
	cur.execute("UPDATE teaches SET "
					"name = ?, "
					"assigned_hours = ? "
				"WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
				[args.name, args.assigned_hours, args.student_id, args.course_num, args.term_month_year])

con.commit()
con.close()


sys.exit(0)
