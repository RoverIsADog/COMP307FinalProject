#!/usr/bin/python
import argparse
import sqlite3
import sys

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# get student_id
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
student_id = record[0]

# Query database for all the courses the user is registered to
cur.execute("SELECT r.course_num, c.term_month_year "
			"FROM registered r JOIN courses c on r.course_num = c.course_num "
			"WHERE student_id = ?;", [student_id])

for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))


con.commit()
con.close()


sys.exit(0)
