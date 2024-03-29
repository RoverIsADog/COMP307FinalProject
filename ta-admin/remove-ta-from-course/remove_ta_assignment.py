#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib


parser = argparse.ArgumentParser()
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--student_id", type=int)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()


# remove provided TA-course assignment
cur.execute("DELETE FROM teaches WHERE course_num = ? AND term_month_year = ? AND student_id = ?;",
			[args.course_num, args.term_month_year, args.student_id])

con.commit()
con.close()

sys.exit(0)
