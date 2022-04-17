#!/usr/bin/python
import argparse
import sqlite3
import sys


parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# get all profs who have the TA on their wishlist
cur.execute("SELECT prof_id, course_num, term_month_year FROM wishlists WHERE ta_id = ?;", [args.student_id])
records = cur.fetchall()
for record in records:
	# get prof name using the ID
	cur.execute("SELECT name FROM users WHERE student_id = ?;", [record[0]])
	prof_name = cur.fetchone()
	print('"%s","%s","%s"', (str(prof_name[0]), str(record[1]), str(record[2])))


con.commit()
con.close()


sys.exit(0)
