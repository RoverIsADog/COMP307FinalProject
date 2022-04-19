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

-- These TAs also teach courses (for now, they all teach COMP307)
INSERT INTO teaches (course_num, student_id, term_month_year, name, assigned_hours)
VALUES
                    ("COMP307" , 555000001, "WINTER2022", "TA 555000001", 90),
                    ("COMP307" , 555000002, "WINTER2022", "TA 555000002", 90),
                    ("COMP307" , 555000003, "WINTER2022", "TA 555000003", 90),
                    ("COMP307" , 555000004, "WINTER2022", "TA 555000004", 90),
                    ("COMP307" , 555000005, "WINTER2022", "TA 555000005", 90),
                    ("COMP307" , 555000006, "WINTER2022", "TA 555000006", 90),
                    ("COMP307" , 555000007, "WINTER2022", "TA 555000007", 90),
                    ("COMP307" , 555000008, "WINTER2022", "TA 555000008", 90),
                    ("COMP307" , 555000009, "WINTER2022", "TA 555000009", 90);