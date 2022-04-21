-- TAs start with 555
INSERT INTO teacherassistants (student_id, term_month_year, ta_name,  legal_name, email             , grad_ugrad, supervisor_name, priority, hours, date_applied, location, phone     , degree  , courses_applied_for, open_to_other_courses, notes)
VALUES
                              (555000001 , "WINTER2022"   , "TA 555000001", "lTA 555000001" , "555000001@mail.ta"     , "grad"    , "sup123"       , "high"  , 90   , "2022-01-01", "earth" , "tel123"  , "deg123", "cappli123"        , "yes"                , "notes123" ),
                              (555000002 , "WINTER2022"   , "TA 555000002", "lTA 555000002" , "555000002@mail.ta"     , "grad"    , "sup124"       , "high"  , 90   , "2022-01-01", "earth" , "tel124"  , "deg124", "cappli124"        , "yes"                , "notes124" ),
                              (555000003 , "WINTER2022"   , "TA 555000003", "lTA 555000003" , "555000003@mail.ta"     , "grad"    , "sup125"       , "high"  , 90   , "2022-01-01", "earth" , "tel125"  , "deg125", "cappli125"        , "yes"                , "notes125" ),
                              (555000004 , "WINTER2022"   , "TA 555000004", "lTA 555000004" , "555000004@mail.ta"     , "grad"    , "sup126"       , "high"  , 90   , "2022-01-01", "earth" , "tel126"  , "deg126", "cappli126"        , "yes"                , "notes126" ),
                              (555000005 , "WINTER2022"   , "TA 555000005", "lTA 555000005" , "555000005@mail.ta"     , "grad"    , "sup127"       , "high"  , 90   , "2022-01-01", "earth" , "tel127"  , "deg127", "cappli127"        , "yes"                , "notes127" ),
                              (555000006 , "WINTER2022"   , "TA 555000006", "lTA 555000006" , "555000006@mail.ta"     , "grad"    , "sup128"       , "high"  , 90   , "2022-01-01", "earth" , "tel128"  , "deg128", "cappli128"        , "yes"                , "notes128" ),
                              (555000007 , "WINTER2022"   , "TA 555000007", "lTA 555000007" , "555000007@mail.ta"     , "grad"    , "sup123"       , "high"  , 90   , "2022-01-01", "earth" , "tel123"  , "deg123", "cappli123"        , "yes"                , "notes123" ),
                              (555000008 , "WINTER2022"   , "TA 555000008", "lTA 555000008" , "555000008@mail.ta"     , "grad"    , "sup124"       , "high"  , 90   , "2022-01-01", "earth" , "tel124"  , "deg124", "cappli124"        , "yes"                , "notes124" ),
                              (555000009 , "WINTER2022"   , "TA 555000009", "lTA 555000009" , "555000009@mail.ta"     , "grad"    , "sup125"       , "high"  , 90   , "2022-01-01", "earth" , "tel125"  , "deg125", "cappli125"        , "yes"                , "notes125" );

-- These TAs also teach courses (for now, they all teach COMP307W2022 and the 1st half also teach 2023)
INSERT INTO teaches (course_num, student_id, term_month_year, name, assigned_hours)
VALUES
-- Everyone teaches COMP307 W2022
                    ("COMP307" , 555000001, "WINTER2022", "TA 555000001", 90),
                    ("COMP307" , 555000002, "WINTER2022", "TA 555000002", 90),
                    ("COMP307" , 555000003, "WINTER2022", "TA 555000003", 90),
                    ("COMP307" , 555000004, "WINTER2022", "TA 555000004", 90),
                    ("COMP307" , 555000005, "WINTER2022", "TA 555000005", 90),
                    ("COMP307" , 555000006, "WINTER2022", "TA 555000006", 90),
                    ("COMP307" , 555000007, "WINTER2022", "TA 555000007", 90),
                    ("COMP307" , 555000008, "WINTER2022", "TA 555000008", 90),
                    ("COMP307" , 555000009, "WINTER2022", "TA 555000009", 90),
-- The 1st half (1-5) teaches COMP307 AUGUST2023
                    ("COMP307" , 555000001, "AUGUST2023", "TA 555000001", 90),
                    ("COMP307" , 555000002, "AUGUST2023", "TA 555000002", 90),
                    ("COMP307" , 555000003, "AUGUST2023", "TA 555000003", 90),
                    ("COMP307" , 555000004, "AUGUST2023", "TA 555000004", 90),
                    ("COMP307" , 555000005, "AUGUST2023", "TA 555000005", 90);

-- These TAs have office hours for the courses they are teaching
INSERT INTO officehours (student_id, course_num, term_month_year, job_description      , monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thursday_start, thursday_end, friday_start, friday_end, notes)
VALUES
-- COMP307 W2022 (everyone)
                        (555000001 , "COMP307" , "WINTER2022"   , "Grader1 (part time)", "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000001"),
                        (555000002 , "COMP307" , "WINTER2022"   , "Grader2 (part time)", ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000002"),
                        (555000003 , "COMP307" , "WINTER2022"   , "Grader3 (part time)", ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Zoom 555000003"),
                        (555000004 , "COMP307" , "WINTER2022"   , "Grader4 (part time)", ""          ,""         , ""           ,""          , ""             ,""            , "12:00"       ,"13:00"      , ""          ,""         , "Zoom 555000004"),
                        (555000005 , "COMP307" , "WINTER2022"   , "Grader5 (part time)", ""          ,""         , ""           ,""          , ""             ,""            , ""            ,""           , "12:00"     ,"13:00"    , "Zoom 555000005"),
                        (555000006 , "COMP307" , "WINTER2022"   , "Grader6"            , "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000006"),
                        (555000007 , "COMP307" , "WINTER2022"   , "Grader7"            , ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000007"),
                        (555000008 , "COMP307" , "WINTER2022"   , "Grader8"            , ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Zoom 555000008"),
                        (555000009 , "COMP307" , "WINTER2022"   , "Grader9"            , ""          ,""         , ""           ,""          , ""             ,""            , "12:00"       ,"13:00"      , ""          ,""         , "Zoom 555000008"),
-- COMP307 AUGUST2023 (1st half only 1-5)      
                        (555000001 , "COMP307" , "AUGUST2023"   , "Grader1 (part time)", "12:00"     ,"13:00"    , ""           ,""          , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000001"),
                        (555000002 , "COMP307" , "AUGUST2023"   , "Grader2 (part time)", ""          ,""         , "12:00"      ,"13:00"     , ""             ,""            , ""            ,""           , ""          ,""         , "Zoom 555000002"),
                        (555000003 , "COMP307" , "AUGUST2023"   , "Grader3 (part time)", ""          ,""         , ""           ,""          , "12:00"        ,"13:00"       , ""            ,""           , ""          ,""         , "Zoom 555000003"),
                        (555000004 , "COMP307" , "AUGUST2023"   , "Grader4 (part time)", ""          ,""         , ""           ,""          , ""             ,""            , "12:00"       ,"13:00"      , ""          ,""         , "Zoom 555000004"),
                        (555000005 , "COMP307" , "AUGUST2023"   , "Grader5 (part time)", ""          ,""         , ""           ,""          , ""             ,""            , ""            ,""           , "12:00"     ,"13:00"    , "Zoom 555000005");


