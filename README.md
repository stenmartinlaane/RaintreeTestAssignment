## Raintree test assignment - Sten Martin Lääne
#### contact info: stenmartinlaane@gmail.com
## Dependencies
- composer: https://getcomposer.org/download/
- php version 8.3: https://www.php.net/downloads.php
- git: https://git-scm.com/downloads
- mysql: https://www.mysql.com

## Setup
~~~bash
git clone https://github.com/stenmartinlaane/RaintreeTestAssignment
cd ./RaintreeTestAssignment
composer install
~~~

## Relevant file locations
### Exercise 1 - preparing MySQL database and tables.

~~~bash
code ./DataBase/Migrations/migrations.sql
code ./DataBase/Seeds/TestSeedData.sql
~~~
### Exercise 2 – PHP scripting.
a) Display the following columns for each patient to the console:
~~~bash
code ./App/App.Console/patients-data.php
~~~
Run it
~~~bash
php ./App/App.Console/scripts.php patients-data
~~~
b) Create statistics:
~~~bash
code ./App/App.Console/statistics.php
~~~
Run it
~~~bash
php ./App/App.Console/scripts.php patients-data
~~~
### Exercise 3 – Object-oriented PHP.
Patient class
~~~bash
code ./App/App.Domain/Patient.php
~~~
Insurance class
~~~bash
code ./App/App.Domain/Insurance.php
~~~
PatientRecord interface
~~~bash
code ./Base/Base.Contracts.Domain/PatientRecord.php
~~~
Test script to test the features of Patient and Insurance classes.
~~~bash
code ./App/App.Console/test-script.php
~~~
Run it
~~~bash
php ./App/App.Console/scripts.php test-script
~~~