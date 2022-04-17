#!/usr/bin/python
import argparse
import sqlite3
import sys

parser = argparse.ArgumentParser()
parser.add_argument("--course_num", type=str)
parser.add_argument("--ta_id", type=int)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--score", type=int)
parser.add_argument("--comment", type=str)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# find unique ID
rating_id = 1
cur.execute("SELECT rating_id FROM ratings ORDER BY rating_id;")
records = cur.fetchall()
if records is not None:
	for record in records:
		if rating_id == record[0]:
			rating_id += 1

cur.execute("INSERT INTO ratings VALUES (?,?,?,?,?,?)",
			[rating_id, args.term_month_year, args.score, args.comment, args.ta_id, args.course_num])

con.commit()
con.close()

sys.exit(0)
