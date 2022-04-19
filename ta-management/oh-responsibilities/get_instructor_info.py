#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib
import json

parser = argparse.ArgumentParser()
parser.add_argument("--student_id", type=int)
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# print("Checkpoint 1")

cur.execute("SELECT job_description, monday_start, monday_end,"
				"tuesday_start, tuesday_end, "
				"wednesday_start, wednesday_end, "
				"thursday_start, thursday_end, "
				"friday_start, friday_end, "
				"notes "
			"FROM officehours WHERE student_id = ? AND course_num = ? AND term_month_year = ?;",
			[args.student_id, args.course_num, args.term_month_year])

# print("Checkpoint 2")

record = cur.fetchone()
if record is None:
	con.commit()
	con.close()

	sys.exit(-1)
else:
	ret = {
		"job_description": str(record[0]), 
		"monday_start": str(record[1]), "monday_end": str(record[2]),
		"tuesday_start": str(record[3]), "tuesday_end": str(record[4]), 
		"wednesday_start": str(record[5]), "wednesday_end": str(record[6]),
		"thursday_start": str(record[7]), "thursday_end": str(record[8]),
		"friday_start": str(record[9]), "friday_end": str(record[10]),
		"notes": str(record[11])
	}
	print(json.dumps(ret))

#	print('"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' %
#		  (str(record[0]), str(record[1]), str(record[2]), str(record[3]), str(record[4]), str(record[5]),
#		   str(record[6]), str(record[7]), str(record[8]), str(record[9]), str(record[10]), str(record[11])))


con.commit()
con.close()


sys.exit(0)
