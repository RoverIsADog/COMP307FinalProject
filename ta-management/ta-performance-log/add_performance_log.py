#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

parser.add_argument("--student_id", type=int)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--comment", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()


# get the prof's student_id from the ticket username
cur.execute("SELECT student_id FROM users WHERE username = ?;", [args.username])
record = cur.fetchone()
prof_id = record[0]

# generate unique log id
log_id = 1
cur.execute("SELECT log_id FROM logs ORDER BY log_id;")
records = cur.fetchall()
if records is not None:
	for record in records:
		if log_id == record[0]:
			log_id += 1

# create new log record
cur.execute("INSERT INTO logs VALUES ("
				"log_id = ?, "
				"course_num = ?, "
				"term_month_year = ?, "
				"prof_id = ?, "
				"ta_id = ?, "
				"note = ?"
			");", [log_id, args.course_num, args.term_month_year, prof_id, args.student_id, args.comment])

con.commit()
con.close()

sys.exit(0)
