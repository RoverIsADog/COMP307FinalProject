-- SQLite
DELETE FROM users WHERE student_id != -1;
DELETE FROM assigned WHERE student_id != -1;
DELETE FROM tickets WHERE username != "defaultsysop";