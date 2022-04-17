#!/usr/bin/python
import argparse
import sqlite3
import sys


parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()


# get student_id for given username
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
student_id = cur.fetchone()[0]

# check if user is already registered to the course
cur.execute("SELECT COUNT(*) FROM registered WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
			[student_id, args.course_num, args.term_month_year])
count = cur.fetchone()[0]

# if they are, delete record in registered table
if count != 0:
	cur.execute("DELETE FROM registered WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
				[student_id, args.course_num, args.term_month_year])

con.commit()
con.close()
sys.exit(0)
