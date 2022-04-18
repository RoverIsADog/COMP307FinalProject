#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--job", type=str)
parser.add_argument("--monday_start", type=str)
parser.add_argument("--monday_end", type=str)
parser.add_argument("--tuesday_start", type=str)
parser.add_argument("--tuesday_end", type=str)
parser.add_argument("--wednesday_start", type=str)
parser.add_argument("--wednesday_end", type=str)
parser.add_argument("--thursday_start", type=str)
parser.add_argument("--thursday_end", type=str)
parser.add_argument("--friday_start", type=str)
parser.add_argument("--friday_end", type=str)
parser.add_argument("--notes", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# check if there is already an office hour record for the prof and course
cur.execute("SELECT COUNT(*) FROM officehours WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
			[args.student_id, args.course_num, args.term_month_year])

count = cur.fetchone()[0]
# if there is not, create a new record with the provided data
if count == 0:
	cur.execute("INSERT INTO officehours VALUES ("
					"student_id = ?, "
					"course_num = ?, "
					"term_month_year = ?, "
					"job_description = ?, "
					"monday_start = ?, "
					"monday_end = ?, "
					"tuesday_start = ?, "
					"tuesday_end = ?, "
					"wednesday_start = ?, "
					"wednesday_end = ?, "
					"thursday_start = ?, "
					"thursday_end = ?, "
					"friday_start = ?, "
					"friday_end = ?, "
					"notes = ? "
				");", [args.student_id, args.course_num, args.term_month_year, args.job,
					   args.monday_start, args.monday_end,
					   args.tuesday_start, args.tuesday_end,
					   args.wednesday_start, args.wednesday_end,
					   args.thursday_start, args.thursday_end,
					   args.friday_start, args.friday_end,
					   args.notes])

# if there is, update it with the provided information
else:
	cur.execute("UPDATE officehours SET "
					"job_description = ?, "
					"monday_start = ?, "
					"monday_end = ?, "
					"tuesday_start = ?, "
					"tuesday_end = ?, "
					"wednesday_start = ?, "
					"wednesday_end = ?, "
					"thursday_start = ?, "
					"thursday_end = ?, "
					"friday_start = ?, "
					"friday_end = ?, "
					"notes = ? "
				"WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
				[args.job, args.monday_start, args.monday_end, args.tuesday_start, args.tuesday_end,
				 args.wednesday_start, args.wednesday_end, args.thursday_start, args.thursday_end,
				 args.friday_start, args.friday_end, args.notes,
				 args.student_id, args.course_num, args.term_month_year])


con.commit()
con.close()


sys.exit(0)
