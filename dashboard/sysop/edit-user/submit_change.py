#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()

parser.add_argument("--student_id", type=str)
parser.add_argument("--name", type=str)
parser.add_argument("--email", type=str)
parser.add_argument("--role", type=str)  # student:"student", TA and student:"ta", prof:"prof"
parser.add_argument("--is_admin", type=int)  # 1 if true, 0 if not
parser.add_argument("--is_sysop", type=int)  # 1 if true, 0 if not
args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# update the users record
cur.execute("UPDATE users SET name = ?, email = ? WHERE student_id = ?;", [args.name, args.email, args.student_id])

# get the user's previous roles
cur.execute("SELECT role_id FROM assigned WHERE student_id = ?;", [args.student_id])
records = cur.fetchall()

prev_roles = {1: False, 2: False, 3: False, 4: False, 5: False}
for role in prev_roles:
	for r in records:
		if r[0] == role:
			prev_roles[role] = True
			break

# change admin role if needed
if prev_roles[3] and args.is_admin == 0:
	# remove admin role
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 3;", [args.student_id])
elif not prev_roles[3] and args.is_admin == 1:
	# add admin role
	cur.execute("INSERT INTO assigned VALUES (?,3);", [args.student_id])

# change sysop role if needed
if prev_roles[4] and args.is_sysop == 0:
	# remove sysop role
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 3;", [args.student_id])
elif not prev_roles[4] and args.is_sysop == 1:
	# add sysop role
	cur.execute("INSERT INTO assigned VALUES (?,4);", [args.student_id])

# if removing prof role, make the associated professors record temporary (is_temporary = 1)
if prev_roles[2] and args.role != "prof":
	# remove user's prof role
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 2;", [args.student_id])

	# generate temp_id
	temp_id = 1
	cur.execute("SELECT professor_id FROM professors ORDER BY professor_id;")
	records = cur.fetchall()
	if records is not None:
		for record in records:
			if temp_id == record[0]:
				temp_id += 1

			# update id in professors table and make the record temporary
			cur.execute("UPDATE professors SET professor_id = ?, is_temporary = 1 WHERE professor_id = ?;",
						[temp_id, args.student_id])

			# update id in the teaches table
			cur.execute("UPDATE teaches SET student_id = ? WHERE student_id = ?;", [temp_id, args.student_id])

			# update id in the officehours table
			cur.execute("UPDATE officehours SET student_id = ? WHERE student_id = ?;", [temp_id, args.student_id])

			# update id in the wishlist table
			cur.execute("UPDATE wishlists SET prof_id = ? WHERE prof_id = ?;", [temp_id, args.student_id])

# if adding the prof role, check if there is a temporary prof with the same name. Otherwise, exit 1
if not prev_roles[2] and args.role == "prof":
	# check if the entered name matches the name of a prof with a temporary ID. If so, assign prof role
	cur.execute("SELECT COUNT(*) FROM professors WHERE name = ? and is_temporary = 1;", [args.name])
	count = cur.fetchone()[0]

	if count != 0:
		# add prof role
		cur.execute("INSERT INTO assigned VALUES (?, 2);", [args.student_id])

		# change temp_id for provided id
		cur.execute("SELECT professor_id FROM professors WHERE name = ?;", [args.name])
		temp_id = cur.fetchone()[0]

		# update id in professors table and make the record non-temporary
		cur.execute("UPDATE professors SET professor_id = ?, is_temporary = 0 WHERE name = ?;",
					[args.student_id, args.name])

		# update id in the teaches table
		cur.execute("UPDATE teaches SET student_id = ? WHERE student_id = ?;", [args.student_id, temp_id])

		# update id in the officehours table
		cur.execute("UPDATE officehours SET student_id = ? WHERE student_id = ?;", [args.student_id, temp_id])

		# update id in the wishlist table
		cur.execute("UPDATE wishlists SET prof_id = ? WHERE prof_id = ?;", [args.student_id, temp_id])

	else:
		# if there is no temporary record with the same name, keep the previous roles and exit 1
		con.commit()
		con.close()
		sys.exit(1)

# if removing TA role, no check are required, since we are not deleting teacherassistant record, but just preventing
# user from accessing TA tasks
if prev_roles[5] and args.role != "ta":
	# remove the TA role
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 5;", [args.student_id])

# if adding the TA role, check if there is a record in teacherassistants with the same student_id. If not, only assign
# student role since all TAs are students but user is not a valid TA, and exit 2
if not prev_roles[5] and args.role == "ta":
	cur.execute("SELECT COUNT(*) FROM teacherassistants WHERE student_id = ?;", [args.student_id])
	count = cur.fetchone()[0]
	# assign student role if they do not already have it
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 1;", [args.student_id])
	cur.execute("INSERT INTO assigned VALUES (?, 1);", [args.student_id])
	if count != 0:
		# assign the TA role
		cur.execute("INSERT INTO assigned VALUES (?, 5);", [args.student_id])
	else:
		# only assign student role and exit 2
		con.commit()
		con.close()
		sys.exit(2)

# if removing student role (i.e. assigning prof role since TAs are students), remove all courses to which they are
# registered
if prev_roles[1] and args.role == "prof":
	# remove student role
	cur.execute("DELETE FROM assigned WHERE student_id = ? AND role_id = 1;", [args.student_id])
	# remove all courses to which the user was registered
	cur.execute("DELETE FROM registered WHERE student_id = ?;", [args.student_id])

# if adding student role, no checks are required
if not prev_roles[1] and args.role == 1:
	cur.execute("INSERT INTO assigned VALUES (?,1);", [args.student_id])


con.commit()
con.close()
sys.exit(0)
