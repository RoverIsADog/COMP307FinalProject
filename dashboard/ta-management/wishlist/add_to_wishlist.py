#!/usr/bin/python
import argparse
import sqlite3
import sys
from utils import getId

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

parser.add_argument("--student_id", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

con = sqlite3.connect('../../project.db')
cur = con.cursor()

prof_id = getId(args.username)

# generate unique wishlist id
wishlist_id = 1
cur.execute("SELECT wishlist_id FROM wishlists ORDER BY wishlist_id;")
records = cur.fetchall()
if records is not None:
	for record in records:
		if wishlist_id == record[0]:
			wishlist_id += 1

# add record to wishlists
cur.execute("INSERT INTO wishlists VALUES (?,?,?,?,?);",
			[wishlist_id, prof_id, args.student_id, args.course_num, args.term_month_year])

con.commit()
con.close()


sys.exit(0)
