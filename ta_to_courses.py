#!/usr/bin/python
import argparse
import sqlite3
import sys


parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)

args = parser.parse_args()

con = sqlite3.connect('../project.db')
cur = con.cursor()


# Query database for all assignments of the provided TA to a course
#cur.execute("SELECT DISTINCT course_num, term_month_year FROM assists WHERE student_id = ?", args.student_id)
#for record in cur.fetchall():
#	print(record)
print("COMP307, Winter2021")
print("COMP308, Winter2022")
print("COMP309, Winter2023")
print("COMP310, Winter2024")
print("COMP311, Winter2025")

con.commit()
con.close()


sys.exit(0)
