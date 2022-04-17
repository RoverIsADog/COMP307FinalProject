#!/usr/bin/python
import argparse
import sqlite3
import sys

parser = argparse.ArgumentParser()

parser.add_argument("--username", type=str)

args = parser.parse_args()

con = sqlite3.connect('../project.db')
cur = con.cursor()

# get the name of the user with the provided username
cur.execute("SELECT name FROM users WHERE username = ?;", [args.username])
print('"%s"' % (cur.fetchone()[0]))


con.commit()
con.close()
sys.exit(0)
