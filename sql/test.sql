-- SQLite
INSERT INTO registered (student_id, course_num, term_month_year)
VALUES
(52415	, "COMP306", "WINTER2020"),
(52415	, "COMP307", "WINTER2021"),
(52415	, "COMP308", "WINTER2022");

SELECT student_id FROM users WHERE username = 124;
SELECT r.course_num, c.term_month_year FROM registered r JOIN courses c on r.course_num = c.course_num WHERE student_id = 52415;

SELECT student_id, name, email FROM users WHERE student_id != -1;

SELECT role_id FROM assigned WHERE student_id = 111;

INSERT INTO users VALUES (newstudentid,newuser,1234,newname newlastname,new@email);