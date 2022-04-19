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
                 (000008, "COMP307" , "WINTER2022"   , 999000001, 555000008, "Note TA 0008 - 1"),
                 (000009, "COMP307" , "WINTER2022"   , 999000002, 555000008, "Note TA 0008 - 2"),
                 (000010, "COMP307" , "WINTER2022"   , 999000003, 555000008, "Note TA 0008 - 3"),
                 (000011, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 4"),
                 (000012, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 5"),
                 (000013, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 6"),
                 (000014, "COMP307" , "WINTER2022"   , 888000001, 555000008, "Note TA 0008 - 7"),

