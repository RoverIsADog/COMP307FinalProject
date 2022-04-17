#!/usr/bin/python
import sqlite3
import sys

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# Query database for all the courses the user is registered to
cur.execute("SELECT course_num, term_month_year FROM courses;")

for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))


con.commit()
con.close()


sys.exit(0)
