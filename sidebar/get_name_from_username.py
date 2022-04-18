#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()

parser.add_argument("--username", type=str)

args = parser.parse_args()

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

# get the name of the user with the provided username
cur.execute("SELECT name FROM users WHERE username = ?;", [args.username])
print('"%s"' % (cur.fetchone()[0]))


con.commit()
con.close()
sys.exit(0)
