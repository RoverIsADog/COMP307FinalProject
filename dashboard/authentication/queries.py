#!/usr/bin/python
import sqlite3

con = sqlite3.connect('../project.db')
cur = con.cursor()


# Drop tables
def dropTables():
	cur.execute("DROP TABLE professors;")
	cur.execute("DROP TABLE officehours;")
	cur.execute("DROP TABLE wishlists;")
	cur.execute("DROP TABLE tickets;")
	cur.execute("DROP TABLE teaches;")
	cur.execute("DROP TABLE logs;")
	cur.execute("DROP TABLE ratings;")
	cur.execute("DROP TABLE teacherassistants;")
	cur.execute("DROP TABLE registered;")
	cur.execute("DROP TABLE courses;")
	cur.execute("DROP TABLE assigned;")
	cur.execute("DROP TABLE roles;")
	cur.execute("DROP TABLE users;")


# Create tables
def createTables():
	cur.execute("CREATE TABLE users ("
				"student_id INTEGER NOT NULL UNIQUE,"
				"username TEXT NOT NULL UNIQUE,"
				"password TEXT NOT NULL,"
				"name TEXT NOT NULL,"
				"email TEXT NOT NULL,"
				"PRIMARY KEY (student_id)"
				");")

	cur.execute("CREATE TABLE roles ("
				"role_id INTEGER NOT NULL UNIQUE,"
				"name TEXT NOT NULL UNIQUE,"
				"PRIMARY KEY (role_id)"
				");")

	cur.execute("CREATE TABLE assigned ("
				"student_id INTEGER NOT NULL,"
				"role_id INTEGER NOT NULL,"
				"PRIMARY KEY (student_id, role_id),"
				"FOREIGN KEY (student_id) REFERENCES users (student_id),"
				"FOREIGN KEY (role_id) REFERENCES roles (role_id)"
				");")

	cur.execute("CREATE TABLE courses ("
				"course_num TEXT NOT NULL,"
				"term_month_year TEXT NOT NULL,"
				"course_name TEXT NOT NULL,"
				"course_type TEXT,"
				"instructor_assigned_name TEXT,"
				"course_enrollment_num INTEGER,"
				"ta_quota INTEGER,"
				"enrollment_div DOUBLE,"
				"PRIMARY KEY (course_num, term_month_year)"
				");")

	cur.execute("CREATE TABLE registered ("
				"student_id INTEGER NOT NULL,"
				"course_num TEXT NOT NULL,"
				"term_month_year TEXT NOT NULL, "
				"PRIMARY KEY (student_id,course_num, term_month_year),"
				"FOREIGN KEY (student_id) REFERENCES users (student_id),"
				"FOREIGN KEY (course_num) REFERENCES courses (course_num), "
				"FOREIGN KEY (term_month_year) REFERENCES courses (term_month_year)"
				");")

	cur.execute("CREATE TABLE teacherassistants ("
				"student_id INTEGER NOT NULL,"
				"term_month_year TEXT NOT NULL,"
				"ta_name TEXT NOT NULL,"
				"legal_name TEXT NOT NULL,"
				"email TEXT NOT NULL,"
				"grad_ugrad TEXT NOT NULL,"
				"supervisor_name TEXT NOT NULL,"
				"priority TEXT NOT NULL,"
				"hours INTEGER NOT NULL,"  # either 90, or 180
				"date_applied TEXT NOT NULL,"  # as ISO8601 strings ("YYYY-MM-DD HH:MM:SS.SSS")
				"location TEXT NOT NULL,"
				"phone TEXT NOT NULL,"
				"degree TEXT,"
				"courses_applied_for TEXT,"
				"open_to_other_courses TEXT,"
				"notes TEXT,"
				"PRIMARY KEY (student_id, term_month_year)"
				");")

	cur.execute("CREATE TABLE ratings ("
				"rating_id INTEGER NOT NULL UNIQUE,"
				"term_month_year TEXT NOT NULL,"
				"score INTEGER NOT NULL,"  # int from 0 to 5
				"comment TEXT,"
				"ta_id INT NOT NULL,"
				"course_num TEXT NOT NULL,"
				"PRIMARY KEY (rating_id),"
				"FOREIGN KEY (ta_id) REFERENCES teacherassistants (student_id),"
				"FOREIGN KEY (course_num) REFERENCES courses (course_num)"
				");")

	cur.execute("CREATE TABLE logs ("
				"log_id INTEGER NOT NULL UNIQUE,"
				"course_num TEXT,"
				"term_month_year TEXT,"
				"prof_id INTEGER,"
				"ta_id INTEGER,"
				"note TEXT,"
				"PRIMARY KEY (log_id)"
				");")

	cur.execute("CREATE TABLE teaches ("
					"course_num TEXT,"
					"student_id INTEGER,"
					"term_month_year TEXT,"
					"name TEXT,"
					"assigned_hours INTEGER,"
					"PRIMARY KEY (course_num, student_id, term_month_year),"
					"FOREIGN KEY (course_num) REFERENCES courses (course_num),"
					"FOREIGN KEY (student_id) REFERENCES teacherassistants (student_id),"
					"FOREIGN KEY (term_month_year) REFERENCES courses (term_month_year)"
				");")

	cur.execute("CREATE TABLE tickets ("
					"ticket_id INTEGER NOT NULL UNIQUE,"
					"username TEXT NOT NULL,"
					"timeout TEXT NOT NULL,"
					"PRIMARY KEY (ticket_id),"
					"FOREIGN KEY (username) REFERENCES users (username)"
				");")

	cur.execute("CREATE TABLE wishlists ("
					"wishlist_id INTEGER NOT NULL UNIQUE, "
					"prof_id INTEGER NOT NULL, "
					"ta_id INTEGER NOT NULL, "
					"course_num TEXT, "
					"term_month_year TEXT,"
					"PRIMARY KEY (wishlist_id)"
				");")

	cur.execute("CREATE TABLE officehours ("
				"student_id INTEGER NOT NULL, "
				"course_num TEXT, "
				"term_month_year TEXT, "
				"job_description TEXT, "
				"monday_start TEXT, "
				"monday_end TEXT, "
				"tuesday_start TEXT, "
				"tuesday_end TEXT, "
				"wednesday_start TEXT, "
				"wednesday_end TEXT, "
				"thursday_start TEXT, "
				"thursday_end TEXT, "
				"friday_start TEXT, "
				"friday_end TEXT, "
				"notes TEXT,"
				"PRIMARY KEY (student_id, course_num, term_month_year)"
				");")

	cur.execute("CREATE TABLE professors ("
					"professor_id INTEGER NOT NULL, "
					"name TEXT, "
					"is_temporary INTEGER, "  # 1 if there is a user tied to the record, 0 if not
					"PRIMARY KEY (professor_id)"
				");")

# inputs: username, ticket_id, student_id (ta), course_num, term_month_year

def loadRoles():
	cur.execute("INSERT INTO roles VALUES"
				"(1, 'Student'),"
				"(2, 'Professor'),"
				"(3, 'Administrator'),"
				"(4, 'Sysop'),"
				"(5, 'TA')"
				";")


def main():
    #dropTables()
    createTables()
    loadRoles()

    con.commit()
    con.close()


if __name__ == '__main__':
	main()
