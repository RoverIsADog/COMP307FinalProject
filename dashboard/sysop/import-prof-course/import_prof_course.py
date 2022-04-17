#!/usr/bin/python
import argparse
import sqlite3
import sys
import csv

parser = argparse.ArgumentParser()
parser.add_argument("--path", type=str)

args = parser.parse_args()

con = sqlite3.connect('../../project.db')
cur = con.cursor()

csv_file = csv.reader(args.path)

# add courses to database
for row in csv_file:
	# check if the course already exists in the database
	cur.execute("SELECT COUNT(*) FROM courses WHERE course_num = ? AND term_month_year = ?;", [row[1], row[0]])
	# If it does not exist, create a new record. Otherwise, update the existing record
	if cur.fetchone()[0] == 0:
		cur.execute("INSERT INTO courses VALUES (?,?,?,null,?,null,null,null);", [row[1], row[0], row[2], row[3]])
	else:
		cur.execute("UPDATE courses SET course_name = ?, instructor_assigned_name = ? "
					"WHERE course_num = ? AND term_month_year = ?;",
					[row[2], row[3], row[1], row[0]])

		# if updating the course record, the assigned professor might change, so remove the corresponding record in
		# the teaches table, as a new one will be inserted (could potentially be the same as the one removed)
		cur.execute("DELETE FROM teaches WHERE course_num = ? AND term_month_year = ? AND assigned_hours = -1;",
					[row[1], row[0]])

		# create new records for professors who are not already in the database
		# check if prof already exists in the database
		prof_id = 0
		cur.execute("SELECT COUNT(*) FROM professors WHERE name = ?;", [row[3]])
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

			cur.execute("INSERT INTO professors VALUES (?,?,1);", [temp_id, row[3]])
			prof_id = temp_id
		else:
			# if they do, get their professor ID
			cur.execute("SELECT professor_id FROM professors WHERE name = ?;", [row[3]])
			prof_id = cur.fetchone()[0]

		# add a record in the teaches table to indicate that the prof is teaching this course
		cur.execute("INSERT INTO teaches VALUES (?,?,?,?,?);", [row[1], prof_id, row[0], row[3], -1])

con.commit()
con.close()
sys.exit(0)
