#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib


def close():
	con.commit()
	con.close()


parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)
parser.add_argument("--password", type=str)
parser.add_argument("--confirm_password", type=str)
parser.add_argument("--email", type=str)
parser.add_argument("--student_id", type=str)
parser.add_argument("--first_name", type=str)
parser.add_argument("--last_name", type=str)
parser.add_argument("--role", type=int)  # student:1, TA and student:2, prof:3

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
print(str(path) + "/project.db")
cur = con.cursor()

print("checkpoint1")

# check if username already exists. return 1 if it does
cur.execute("SELECT COUNT(*) FROM users WHERE username = ?;", [args.username])
count = cur.fetchone()[0]

print ("There were %d matches for userid = %s." % (count, args.username))

if count != 0:
	close()
	print("About to exit 1")
	sys.exit(1)

print("checkpoint2")

# check if there is already a user with the provided student_id. return 2 if there is
cur.execute("SELECT COUNT(*) FROM users WHERE student_id = ?;", [args.student_id])
count = cur.fetchone()[0]

print ("There were %d other users with id:  %s." % (count, args.username))

if count != 0:
	close()
	print("About to exit 3")
	sys.exit(2)

print("checkpoint3")

# check if there is already a user with the provided email. return 3 if there is
cur.execute("SELECT COUNT(*) FROM users WHERE email = ?;", [args.email])
count = cur.fetchone()[0]

print ("There were %d other users with email %s." % (count, args.email))

if count != 0:
	close()
	print("About to exit 3")
	sys.exit(3)

print("checkpoint4")

# check if the provided passwords match. return 4 if they do not
if args.password != args.confirm_password:
	close()
	print("About to exit 5")
	sys.exit(4)

print("checkpoint5")

# else, create a new user, check for permissions
print ("COMMAND ABOUT TO BE GIVEN")
print ("INSERT INTO users VALUES (%s,%s,%s,%s,%s);" % (args.student_id, args.username, args.password, str(args.first_name + " " + args.last_name), args.email))

try:
	cur.execute("INSERT INTO users VALUES (?,?,?,?,?);",[args.student_id, args.username, args.password, str(args.first_name + " " + args.last_name), args.email])
except Exception as e:
	print("INSERT FAILED")
	print(e)

print("checkpoint6")

# check permissions
if args.role == 2:
	# check if the student id matches that of a TA. If so, assign TA role (and student role since all TAs are students)
	cur.execute("SELECT COUNT(*) FROM teacherassistants WHERE student_id = ? ;", [args.student_id])
	count = cur.fetchone()[0]
	if count != 0:
		cur.execute("INSERT INTO assigned VALUES ((?, 5), (?, 1));", [args.student_id, args.student_id])

		close()
		print("About to exit 0")
		sys.exit(0)

	else:
		# if they requested TA and was invalid, assign student and return 5
		cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])

		close()
		print("About to exit 5")
		sys.exit(5)

elif args.role == 3:
	# check if the entered name matches the name of a prof with a temporary ID. If so, assign prof role
	cur.execute("SELECT COUNT(*) FROM professors WHERE name = ? and is_temporary = 1;",
				[str(args.first_name + " " + args.last_name)])
	count = cur.fetchone()[0]
	if count != 0:
		cur.execute("INSERT INTO assigned VALUES (?, 2);", [args.student_id])
		# if a record exists in the professors table, but the prof is just now registering, then the id for this
		# professor in the database is a temporary generated one, so update this value to the prof's real id
		# first, retrieve the generated id in order to update the rest of the database with the real id
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

		close()
		sys.exit(0)

	else:
		# if they requested prof and was invalid, assign student and return 6
		cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])

		close()
		print("About to exit 6")
		sys.exit(6)

elif args.role == 1:
	cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])
	close()
	sys.exit(0)

else:
	close()
	print("About to exit 7")
	sys.exit(7)
