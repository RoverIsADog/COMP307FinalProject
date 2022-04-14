#!/usr/bin/python
import argparse
import sqlite3
import sys

"""
Input:
  --username
  --ticket_id

Output:
  Multiple lines of:
    course_number,term_month_year
"""

# Input: username

# OUTPUT:
#Multiple lines of:
#  course_number,term_month_year


parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)
parser.add_argument("--student_id", type=int)
parser.add_argument("--student_id", type=int)

args = parser.parse_args()


# Query database for all assignments of the provided TA to a course
#cur.execute("SELECT DISTINCT course_num, term_month_year FROM assists WHERE student_id = ?", args.student_id)
#for record in cur.fetchall():
#	print(record)
print(args.student_id)
print("COMP307,Winter2021")
print("COMP308,Winter2022")
print("COMP309,Winter2023")
print("COMP310,Winter2024")
print("COMP311,Winter2025")

sys.exit(0)
