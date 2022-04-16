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


# parser = argparse.ArgumentParser()
# parser.add_argument("--student_id", type=int)
# parser.add_argument("--student_id", type=int)
# parser.add_argument("--student_id", type=int)
# 
# args = parser.parse_args()


# Query database for all assignments of the provided TA to a course
#cur.execute("SELECT DISTINCT course_num, term_month_year FROM assists WHERE student_id = ?", args.student_id)
#for record in cur.fetchall():
#	print(record)
print('"%s","%s"' % ("COMP307", "may2077"))
print('"%s","%s"' % ("COMP308", "june2077"))
print('"%s","%s"' % ("COMP309", "july2077"))
print('"%s","%s"' % ("COMP310", "august2077"))
print('"%s","%s"' % ("COMP311", "winter2077"))

sys.exit(0)
