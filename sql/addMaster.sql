-- Sysop number 1
INSERT INTO users (student_id, username, password, name, email)
VALUES (-1, "defaultsysop", "1234", "Default Sysop", "default@mail.com");

INSERT INTO assigned (student_id, role_id)
VALUES (-1, 4);

-- Sysop number 2
INSERT INTO users (student_id, username, password, name, email)
VALUES  (-2, "defaultsysop2", "1234", "Default Sysop2", "default2@mail.com");

INSERT INTO assigned (student_id, role_id) VALUES (-2, 4);