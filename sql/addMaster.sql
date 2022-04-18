-- SQLite
INSERT INTO users (student_id, username, password, name, email)
VALUES (-1, "defaultsysop", "1234", "Default Sysop", "default@mail.com");

-- SQLite
INSERT INTO assigned (student_id, role_id)
VALUES (-1, 4);

--SQLite
SELECT COUNT(*) FROM users WHERE username = 1234 AND password = 1234;