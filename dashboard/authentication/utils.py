import sqlite3
import time

con = sqlite3.connect('../project.db')
cur = con.cursor()

def close():
	con.commit()
	con.close()

# get student_id for provided username
def getId(username):
	cur.execute("SELECT student_id, COUNT(*) FROM users WHERE username = ?;", [username])
	record = cur.fetchone()
	return record[0], record[1]

# checks if user has an open ticket and if they have the required role
def validate(username, ticket_id, required_role):
	cur.execute("SELECT COUNT(*) FROM tickets WHERE ticket_id = ? AND username = ?;", [ticket_id, username])
	count = cur.fetchone()[0]

	# if there is no ticket associated with the provided username, return 1
	if count == 0:
		close()
		return 1

	# if ticket exists, check if timed out
	curr_time = time.time()
	cur.execute("SELECT timeout FROM tickets WHERE ticket_id = ? AND username = ?;", [ticket_id, username])
	timeout = cur.fetchone()[0]

	# if timed out, delete ticket and return 2
	if curr_time > timeout:
		cur.execute("DELETE FROM tickets WHERE ticket_id = ?;", [ticket_id])
		close()
		return 2

	# if not timed out, update the timeout and check if the provided user has the requested role
	# Update timeout
	cur.execute("UPDATE tickets SET "
					"timeout = ?"
				"WHERE ticket_id = ? AND username = ?;", [time.time() + 30, ticket_id, username])

	# get student_id for provided username
	student_id, num_records = getId(username)

	# if user does not exist, return 3
	if num_records == 0:
		close()
		return 3

	# else, check if user has requested permission
	cur.execute("SELECT COUNT(*) FROM assigned WHERE role_id = ? AND student_id = ?;", [required_role, student_id])
	count = cur.fetchone()[0]
	# if permission is invalid, return 4
	if count == 0:
		close()
		return 4
	# else, the permission is valid, so return 0
	else:
		close()
		return 0
