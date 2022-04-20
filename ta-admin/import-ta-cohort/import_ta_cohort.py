#!/usr/bin/python
import argparse
import sqlite3
import sys
import csv
import pathlib


parser = argparse.ArgumentParser()
parser.add_argument("--course_quota_path", type=str)
parser.add_argument("--ta_cohort_path", type=str)
args = parser.parse_args()

required_role = 3

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

f = open(args.course_quota_path)
csv_f = csv.reader(f)

# add courses to database
is_first_row = True
for row in csv_f:
	if is_first_row:
		is_first_row = False
		continue
	enrollment_div = float(row[5]) / float(row[6])
	# check if the course already exists in the database
	cur.execute("SELECT COUNT(*) FROM courses WHERE course_num = ? AND term_month_year = ?;", [row[1], row[0]])
	# If it does not exist, create a new record. Otherwise, update the existing record
	if cur.fetchone()[0] == 0:
		cur.execute("INSERT INTO courses VALUES (?,?,?,?,?,?,?,?);",
					[row[1], row[0], row[3], row[2], row[4], row[5], row[6], enrollment_div])
	else:
		cur.execute("UPDATE courses SET "
						"course_name = ?, "
						"course_type = ?, "
						"instructor_assigned_name = ?, "
						"course_enrollment_num = ?, "
						"ta_quota = ?, "
						"enrollment_div = ?"
					"WHERE course_num = ? AND term_month_year = ?;",
					[row[3], row[2], row[4], row[5], row[6], enrollment_div, row[1], row[0]])

		# if updating the course record, the assigned professor might change, so remove the corresponding record in
		# the teaches table, as a new one will be inserted (could potentially be the same as the one removed)
		cur.execute("DELETE FROM teaches WHERE course_num = ? AND term_month_year = ? AND assigned_hours = -1;",
					[row[1], row[0]])

	# create new records for professors who are not already in the database
	# check if prof already exists in the database
	prof_id = 0
	cur.execute("SELECT COUNT(*) FROM professors WHERE name = ?;", [row[4]])
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

		cur.execute("INSERT INTO professors VALUES (?,?,1);", [temp_id, row[4]])
		prof_id = temp_id
	else:
		# if they do, get their professor ID
		cur.execute("SELECT professor_id FROM professors WHERE name = ?;", [row[4]])
		prof_id = cur.fetchone()[0]

	# add a record in the teaches table to indicate that the prof is teaching this course
	cur.execute("INSERT INTO teaches VALUES (?,?,?,?,?);", [row[1], prof_id, row[0], row[4], -1])


# add TAs to database
f = open(args.ta_cohort_path)
csv_f = csv.reader(f)

for row in csv_f:
	# check if the TA already exists in the database
	cur.execute("SELECT COUNT(*) FROM teacherassistants WHERE student_id = ? AND term_month_year = ?;", [row[2], row[0]])
	# If it does not exist, create a new record. Otherwise, update the existing record
	if cur.fetchone()[0] == 0:
		cur.execute("INSERT INTO teacherassistants VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);",
					[row[2], row[0], row[1], row[3], row[4], row[5], row[6], row[7], row[8], row[9], row[10], row[11],
					 row[12], row[13], row[14], row[15]])
	else:
		cur.execute("UPDATE teacherassistants SET "
						"ta_name = ?,"
						"legal_name = ?,"
						"email = ?,"
						"grad_ugrad = ?,"
						"supervisor_name = ?,"
						"priority = ?,"
						"hours = ?,"
						"date_applied = ?,"
						"location = ?,"
						"phone = ?,"
						"degree = ?,"
						"courses_applied_for = ?,"
						"open_to_other_courses = ?,"
						"notes = ?"
					"WHERE student_id = ? AND term_month_year = ?;",
					[row[1], row[3], row[4], row[5], row[6], row[7], row[8], row[9], row[10], row[11], row[12], row[13],
					 row[14], row[15], row[2], row[0]])

	# check if there is a user with the same student ID, and give them the TA role
	cur.execute("SELECT COUNT(*) FROM users WHERE student_id = ?;", [row[2]])
	if cur.fetchone() == 1:
		# update user info based on csv
		cur.execute("UPDATE users SET "
					"name = ?,"
					"email = ?"
					"WHERE student_id = ?;",
					[row[1], row[4], row[2]])

		# give the user the TA role if they don't have it
		cur.execute("SELECT COUNT(*) FROM assigned WHERE student_id = ? AND role_id = 5;", [row[2]])
		if cur.fetchone() == 0:
			cur.execute("INSERT INTO assigned VALUES (?, 5);", [row[2]])

con.commit()
con.close()

sys.exit(0)
