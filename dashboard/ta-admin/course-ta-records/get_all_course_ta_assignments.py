#!/usr/bin/python
import sqlite3
import sys


con = sqlite3.connect('../../../project.db')
cur = con.cursor()


# Query database for all courses
first_output_array = []
cur.execute("SELECT DISTINCT course_num, term_month_year FROM courses;")
for record in cur.fetchall():
	first_output_array.append((record[0], record[1]))

second_output_array = []
for course in first_output_array:
	# Query database for all assignments of a TA to the provided course
	ta_string = ""
	is_first = True
	cur.execute("SELECT DISTINCT student_id, name FROM teaches "
				"WHERE course_num = ? AND term_month_year = ? AND assigned_hours != -1;",
				[course[0], course[1]])
	for record in cur.fetchall():
		if is_first:
			ta_string = record[1]
			is_first = False
		else:
			ta_string = ta_string + ',' + str(record[1])

	print('"%s","%s","%s"' % (str(course[0]), str(course[1]), ta_string))


con.commit()
con.close()


sys.exit(0)
