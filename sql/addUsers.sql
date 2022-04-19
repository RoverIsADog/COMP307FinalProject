-- SQLite
INSERT INTO users (student_id, username, password, name, email)
VALUES

-- GENERIC STUDENT USERS
(000000001, "username1", "1234", "User Name1", "user1.mail.com"),
(000000001, "username1", "1234", "User Name1", "user1.mail.com"),
(000000001, "username1", "1234", "User Name1", "user1.mail.com"),
(000000001, "username1", "1234", "User Name1", "user1.mail.com"),
(000000001, "username1", "1234", "User Name1", "user1.mail.com"),

-- ADD TA USERS (555 Before username)
(555000001, "username1", "1234", "User Name1", "user1.mail.com"),
(555000001, "username1", "1234", "User Name1", "user1.mail.com"),
(555000001, "username1", "1234", "User Name1", "user1.mail.com"),
(555000001, "username1", "1234", "User Name1", "user1.mail.com"),
(555000001, "username1", "1234", "User Name1", "user1.mail.com"),

-- ADD PROF USERS
(999000001, "username1", "1234", "Full Prof1", "prof1.mail.com"),
(999000002, "username1", "1234", "Full Prof2", "prof2.mail.com"),
(999000003, "username1", "1234", "Full Prof3", "prof3.mail.com");