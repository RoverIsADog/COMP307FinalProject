#!/usr/bin/python
import argparse
import sqlite3
import sys

parser = argparse.ArgumentParser()

parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# Query database for all the TAs
cur.execute("SELECT DISTINCT student_id, ta_name "
			"FROM teacherassistants WHERE term_month_year = ?;", [args.term_month_year])
for record in cur.fetchall():
	print('"%s","%s"' % (str(record[0]), str(record[1])))

con.commit()
con.close()

sys.exit(0)
