#!/usr/bin/python
import sqlite3
import sys
import pathlib

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# query database for all courses
cur.execute("SELECT course_num, course_name, term_month_year FROM courses;")
courses = cur.fetchall()

# for each course, print the course number, the name, and the term_month_year
for course in courses:
	print('"%s","%s","%s"' % (course[0], course[1], course[2]))


con.commit()
con.close()
sys.exit(0)
