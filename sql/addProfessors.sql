-- SQLite

-- Professors with IDs starting with 999 are tied to an accound permanent
-- Professors with IDs starting with 888 are using temporary IDs
INSERT INTO professors (professor_id, name        , is_temporary)
VALUES 
                       (999000001   , "Full Prof1", 0           ),
                       (999000002   , "Full Prof2", 0           ),
                       (999000003   , "Full Prof3", 0           ),

                       (888000001   , "Temp Prof1", 1           ),
                       (888000002   , "Temp Prof2", 1           ),
                       (888000003   , "Temp Prof3", 1           ),
                       (888000004   , "Temp Prof4", 1           ),
                       (888000005   , "Temp Prof5", 1           ),
                       (888000006   , "Temp Prof6", 1           ),
                       (888000007   , "Temp Prof7", 1           ),
                       (888000008   , "Temp Prof8", 1           );

-- These profs also teach courses (for now, they all teach COMP307W2022 and non temporary ID profs teach 2023)
INSERT INTO teaches (course_num, student_id, term_month_year, name, assigned_hours)
VALUES
-- Everyone teaches COMP307 W2022
                    ("COMP307" , 999000001, "WINTER2022", "Full Prof1", 90),
                    ("COMP307" , 999000002, "WINTER2022", "Full Prof2", 90),
                    ("COMP307" , 999000003, "WINTER2022", "Full Prof3", 90),
                    ("COMP307" , 888000001, "WINTER2022", "Temp Prof1", 90),
                    ("COMP307" , 888000002, "WINTER2022", "Temp Prof2", 90),
                    ("COMP307" , 888000003, "WINTER2022", "Temp Prof3", 90),
                    ("COMP307" , 888000004, "WINTER2022", "Temp Prof4", 90),
                    ("COMP307" , 888000005, "WINTER2022", "Temp Prof5", 90),
                    ("COMP307" , 888000006, "WINTER2022", "Temp Prof6", 90),
                    ("COMP307" , 888000007, "WINTER2022", "Temp Prof7", 90),
                    ("COMP307" , 888000008, "WINTER2022", "Temp Prof8", 90),
-- Only the teachers with accounts teach COMP307 W2023
                    ("COMP307" , 999000001, "WINTER2023", "Full Prof1", 90),
                    ("COMP307" , 999000002, "WINTER2023", "Full Prof2", 90),
                    ("COMP307" , 999000003, "WINTER2023", "Full Prof3", 90);

-- These profs have office hours for the courses they are teaching
INSERT INTO officehours (student_id, course_num, term_month_year, job_description      , monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thursday_start, thursday_end, friday_start, friday_end, notes)
VALUES
-- COMP307 W2022 (everyone)
                        (999000001 , "COMP307" , "WINTER2022"   , "Prof1 (part time)"  , "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 999000001"),
                        (999000002 , "COMP307" , "WINTER2022"   , "Prof2 (part time)"  , ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 999000002"),
                        (999000003 , "COMP307" , "WINTER2022"   , "Prof3 (part time)"  , ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Prof Zoom 999000003"),
                        (888000001 , "COMP307" , "WINTER2022"   , "Prof1"              , ""          ,""         , ""           ,""          , ""             ,""            , "12:00"       ,"13:00"      , ""          ,""         , "Prof Zoom 888000001"),
                        (888000002 , "COMP307" , "WINTER2022"   , "Prof2"              , ""          ,""         , ""           ,""          , ""             ,""            , ""            ,""           , "12:00"     ,"13:00"    , "Prof Zoom 888000002"),
                        (888000003 , "COMP307" , "WINTER2022"   , "Prof3"              , "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 888000003"),
                        (888000004 , "COMP307" , "WINTER2022"   , "Prof4"              , ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 888000004"),
                        (888000005 , "COMP307" , "WINTER2022"   , "Prof5"              , ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Prof Zoom 888000005"),
                        (888000006 , "COMP307" , "WINTER2022"   , "Prof6"              , ""          ,""         , ""           ,""          , ""             ,""            , "12:00"       ,"13:00"      , ""          ,""         , "Prof Zoom 888000006"),
                        (888000007 , "COMP307" , "WINTER2022"   , "Prof7"              , ""          ,""         , ""           ,""          , ""             ,""            , ""            ,""           , "12:00"     ,"13:00"    , "Prof Zoom 888000007"),
                        (888000008 , "COMP307" , "WINTER2022"   , "Prof8"              , "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 888000008"),
-- COMP307 W2023 (1st half only 1-5)      
                        (999000001 , "COMP307" , "WINTER2023"   , "Prof1 (part time)"  , "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 999000001"),
                        (999000002 , "COMP307" , "WINTER2023"   , "Prof2 (part time)"  , ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Prof Zoom 999000002"),
                        (999000003 , "COMP307" , "WINTER2023"   , "Prof3 (part time)"  , ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Prof Zoom 999000003");






-- These professors also created logs
-- Prof 1 rates everyone
-- TA 555000008 is rated many times
-- TA 555000009 is rated no times
INSERT INTO logs (log_id, course_num, term_month_year, prof_id  , ta_id    , note)
VALUES
                 (000001, "COMP307" , "WINTER2022"   , 999000001, 555000001, "Note TA 0001 - 1"),
                 (000002, "COMP307" , "WINTER2022"   , 999000001, 555000002, "Note TA 0002 - 1"),
                 (000003, "COMP307" , "WINTER2022"   , 999000001, 555000003, "Note TA 0003 - 1"),
                 (000004, "COMP307" , "WINTER2022"   , 999000001, 555000004, "Note TA 0004 - 1"),
                 (000005, "COMP307" , "WINTER2022"   , 999000001, 555000005, "Note TA 0005 - 1"),
                 (000006, "COMP307" , "WINTER2022"   , 999000001, 555000006, "Note TA 0006 - 1"),
                 (000007, "COMP307" , "WINTER2022"   , 999000001, 555000007, "Note TA 0007 - 1"),
                 (000008, "COMP307" , "WINTER2022"   , 999000001, 555000008, "Note TA 0008 - 1"), -- TA 8 rated many times
                 (000009, "COMP307" , "WINTER2022"   , 999000002, 555000008, "Note TA 0008 - 2"),
                 (000010, "COMP307" , "WINTER2022"   , 999000003, 555000008, "Note TA 0008 - 3"),
                 (000011, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 4"),
                 (000012, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 5"),
                 (000013, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 6"),
                 (000014, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 7"),
                 (000015, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 8"),
                 (000016, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 9");

