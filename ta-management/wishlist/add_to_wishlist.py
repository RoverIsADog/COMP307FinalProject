#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

parser.add_argument("--student_id", type=str)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get the prof's student_id from the ticket username
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
prof_id = record[0]

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
