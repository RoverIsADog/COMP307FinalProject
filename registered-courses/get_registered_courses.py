#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get student_id for given username
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
student_id = cur.fetchone()[0]

# query database for all courses to which the user is registered
cur.execute("SELECT course_num, term_month_year FROM registered WHERE student_id = ?;", [student_id])
courses = cur.fetchall()

# for each course, print the course number and the term_month_year
for course in courses:
	print('"%s","%s"' % (course[0], course[1]))


con.commit()
con.close()
sys.exit(0)
