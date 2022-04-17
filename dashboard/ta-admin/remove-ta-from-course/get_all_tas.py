#!/usr/bin/python
import sqlite3
import sys

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# Query database for all the TAs
cur.execute("SELECT DISTINCT student_id, ta_name FROM teacherassistants;")
for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))

con.commit()
con.close()

sys.exit(0)
