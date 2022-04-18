#!/usr/bin/python
import argparse
import sqlite3
import sys
import pathlib

parser = argparse.ArgumentParser()
parser.add_argument("--username", type=str)

path = pathlib.Path(__file__).parent.parent
con = sqlite3.connect(str(path) + "/project.db")
cur = con.cursor()

args = parser.parse_args()

cur.execute("DELETE FROM tickets WHERE username = ?;", [args.username])

con.commit()
con.close()
sys.exit(0)