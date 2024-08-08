INSERT INTO patient (pn, first, last, dob)
VALUES
    ('PN001', 'John', 'Doe', '1980-01-01'),
    ('PN002', 'Jane', 'Smith', '1990-02-15'),
    ('PN003', 'Alice', 'Johnson', '1965-03-23'),
    ('PN004', 'Bob', 'Ross', '1995-03-23'),
    ('PN005', NULL, NULL, NULL);

INSERT INTO insurance (patient_id, iname, from_date, to_date)
VALUES
    (1, 'HealthPlan A', '2023-01-01', '2023-12-30'),
    (2, 'HealthPlan B', '2023-06-01', '2024-05-30'),
    (3, 'HealthPlan C', '2024-03-01', '2024-10-30'),
    (4, 'HealthPlan D', '2024-04-01', '2024-11-30'),
    (5, 'HealthPlan E', '2021-05-01', '2024-09-30'),
    (1, 'HealthPlan E', '2021-05-01', '2024-09-30'),
    (2, 'HealthPlan A', '2016-02-01', '2023-06-03'),
    (3, 'HealthPlan C', '2019-08-01', '2022-07-15'),
    (4, 'HealthPlan B', '2009-03-01', '2026-03-14'),
    (5, NULL, NULL, NULL);