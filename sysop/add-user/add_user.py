#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

def close():
	con.commit()
	con.close()

def add_admin_sysop():
	if args.is_admin == 1:
		cur.execute("INSERT INTO assigned VALUES (?,3);", [args.student_id])

	if args.is_sysop == 1:
		cur.execute("INSERT INTO assigned VALUES (?,4);", [args.student_id])


parser = argparse.ArgumentParser()

parser.add_argument("--new_username", type=str)
parser.add_argument("--password", type=str)
parser.add_argument("--email", type=str)
parser.add_argument("--student_id", type=int)
parser.add_argument("--first_name", type=str)
parser.add_argument("--last_name", type=str)
parser.add_argument("--role", type=str)  # student:"student", TA and student:"ta", prof:"prof"
parser.add_argument("--is_admin", type=int)  # 1 if true, 0 if not
parser.add_argument("--is_sysop", type=int)  # 1 if true, 0 if not
args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# check if username already exists. return 1 if it does
cur.execute("SELECT COUNT(*) FROM users WHERE username = ?;", [args.new_username])
count = cur.fetchone()[0]

if count != 0:
	close()
	sys.exit(1)

# check if there is already a user with the provided student_id. return 2 if there is
cur.execute("SELECT COUNT(*) FROM users WHERE student_id = ?;", [args.student_id])
count = cur.fetchone()[0]

if count != 0:
	close()
	sys.exit(2)

# check if there is already a user with the provided email. return 3 if there is
cur.execute("SELECT COUNT(*) FROM users WHERE email = ?;", [args.email])
count = cur.fetchone()[0]

if count != 0:
	close()
	sys.exit(3)

# else, create a new user, check for permissions
cur.execute("INSERT INTO users VALUES (?,?,?,?,?);",
			[args.student_id, args.new_username, args.password, str(args.first_name + " " + args.last_name), args.email])

# check permissions
if args.role == "ta":
	# check if the student id matches that of a TA. If so, assign TA role (and student role since all TAs are students)
	cur.execute("SELECT COUNT(*) FROM teacherassistants WHERE student_id = ? ;", [args.student_id])
	count = cur.fetchone()[0]
	if count != 0:
		cur.execute("INSERT INTO assigned VALUES ((?, 5), (?, 1));", [args.student_id, args.student_id])
		add_admin_sysop()
		close()
		sys.exit(0)

	else:
		# if they requested TA and was invalid, assign student and return 5
		cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])
		add_admin_sysop()
		close()
		sys.exit(5)

elif args.role == "prof":
	# check if the entered name matches the name of a prof with a temporary ID. If so, assign prof role
	cur.execute("SELECT COUNT(*) FROM professors WHERE name = ? and is_temporary = 1;",
				[str(args.first_name + " " + args.last_name)])
	count = cur.fetchone()[0]
	if count != 0:
		cur.execute("INSERT INTO assigned VALUES (?, 2);", [args.student_id])
		# change temp_id for provided id
		cur.execute("SELECT professor_id FROM professors WHERE name = ?;", [str(args.first_name + " " + args.last_name)])
		temp_id = cur.fetchone()[0]

		# update id in professors table and make the record non-temporary
		cur.execute("UPDATE professors SET professor_id = ?, is_temporary = 0 WHERE name = ?;",
					[args.student_id, str(args.first_name + " " + args.last_name)])

		# update id in the teaches table
		cur.execute("UPDATE teaches SET student_id = ? WHERE student_id = ?;", [args.student_id, temp_id])

		# update id in the officehours table
		cur.execute("UPDATE officehours SET student_id = ? WHERE student_id = ?;", [args.student_id, temp_id])

		# update id in the wishlist table
		cur.execute("UPDATE wishlists SET prof_id = ? WHERE prof_id = ?;", [args.student_id, temp_id])
		add_admin_sysop()
		close()
		sys.exit(0)

	else:
		# if they requested prof and was invalid, assign student and return 6
		cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])
		add_admin_sysop()
		close()
		sys.exit(6)

elif args.role == "student":
	cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])
	add_admin_sysop()
	close()
	sys.exit(0)

else:
	close()
	sys.exit(7)
