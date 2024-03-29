#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib


parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# Find all ratings done on this TA
cur.execute("SELECT * FROM ratings WHERE ta_id = ?", [args.student_id])
# aggregate sum to get average
num_ratings = 0
sum_ratings = 0

for record in cur.fetchall():
	num_ratings += 1
	sum_ratings += record[2]
	print('"%s","%s"' % (str(record[2]), str(record[3])))

if num_ratings != 0:
	print(str(sum_ratings / num_ratings))

con.commit()
con.close()


sys.exit(0)
