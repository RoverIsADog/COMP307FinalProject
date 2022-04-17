#!/usr/bin/python
import sqlite3
import sys
import argparse

parser = argparse.ArgumentParser()
parser.add_argument("--course_num", type=str)
parser.add_argument("--term_month_year", type=str)
parser.add_argument("--course_name", type=str)
parser.add_argument("--instructor_name", type=str)

args = parser.parse_args()

con = sqlite3.connect("/home/yetong/web/www/html/COMP307FinalProject/dashboard/project.db")
cur = con.cursor()

# add courses to database

# check if the course already exists in the database
cur.execute("SELECT COUNT(*) FROM courses WHERE course_num = ? AND term_month_year = ?;",
			[args.course_num, args.term_month_year])
# If it does not exist, create a new record. Otherwise, update the existing record
if cur.fetchone()[0] == 0:
	cur.execute("INSERT INTO courses VALUES (?,?,?,null,?,null,null,null);",
				[args.course_num, args.term_month_year, args.course_name, args.instructor_name])
else:
	cur.execute("UPDATE courses SET course_name = ?, instructor_assigned_name = ? "
				"WHERE course_num = ? AND term_month_year = ?;",
				[args.course_name, args.instructor_name, args.course_num, args.term_month_year])

	# if updating the course record, the assigned professor might change, so remove the corresponding record in
	# the teaches table, as a new one will be inserted (could potentially be the same as the one removed)
	cur.execute("DELETE FROM teaches WHERE course_num = ? AND term_month_year = ? AND assigned_hours = -1;",
				[args.course_num, args.term_month_year])

	# create new records for professors who are not already in the database
	# check if prof already exists in the database
	prof_id = 0
	cur.execute("SELECT COUNT(*) FROM professors WHERE name = ?;", [args.instructor_name])
	count = cur.fetchone()[0]
	if count == 0:
		# if they do not, create a professor record with a unique temporary ID
		temp_id = 1
		cur.execute("SELECT professor_id FROM professors ORDER BY professor_id;")
		records = cur.fetchall()
		if records is not None:
			for record in records:
				if temp_id == record[0]:
					temp_id += 1

		cur.execute("INSERT INTO professors VALUES (?,?,1);", [temp_id, args.instructor_name])
		prof_id = temp_id
	else:
		# if they do, get their professor ID
		cur.execute("SELECT professor_id FROM professors WHERE name = ?;", [args.instructor_name])
		prof_id = cur.fetchone()[0]

	# add a record in the teaches table to indicate that the prof is teaching this course
	cur.execute("INSERT INTO teaches VALUES (?,?,?,?,?);",
				[args.course_num, prof_id, args.term_month_year, args.instructor_name, -1])

con.commit()
con.close()
sys.exit(0)
