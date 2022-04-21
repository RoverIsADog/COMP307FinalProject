-- SQLite
INSERT INTO users (student_id, username, password, name, email)
VALUES
-- GENERIC STUDENT USERS
(000000001, "username1", "1234", "User Name2", "user1@mail.com"),
(000000002, "username2", "1234", "User Name2", "user2@mail.com"),
(000000003, "username3", "1234", "User Name2", "user3@mail.com"),
(000000004, "username4", "1234", "User Name2", "user4@mail.com"),
(000000005, "username5", "1234", "User Name2", "user5@mail.com"),

-- ADD TA USERS (555 Before username)
(555000001, "ta1", "1234", "TA Name1", "ta1@mail.com"),
(555000002, "ta2", "1234", "TA Name2", "ta2@mail.com"),
(555000003, "ta3", "1234", "TA Name3", "ta3@mail.com"),
(555000004, "ta4", "1234", "TA Name4", "ta4@mail.com"),
(555000005, "ta5", "1234", "TA Name5", "ta5@mail.com"),

-- ADD PROF USERS
(999000001, "prof1", "1234", "Full Prof1", "prof1@mail.com"),
(999000002, "prof2", "1234", "Full Prof2", "prof2@mail.com"),
(999000003, "prof3", "1234", "Full Prof3", "prof3@mail.com");

INSERT INTO assigned (student_id, role_id)
VALUES
-- GENERIC STUDENT USERS
(000000001, 1),
(000000002, 1),
(000000003, 1),
(000000004, 1),
(000000005, 1),

-- ADD TA USERS (555 Before username)
(555000001, 5),
(555000002, 5),
(555000003, 5),
(555000004, 5),
(555000005, 5),

-- ADD PROF USERS
(999000001, 4),
(999000002, 4),
(999000003, 4);