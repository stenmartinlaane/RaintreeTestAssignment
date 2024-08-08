## Raintree test assignment - Sten Martin Lääne
### contact info: stenmartinlaane@gmail.com
## Requirements
- #### php version 8.3: https://www.php.net/downloads.php
- #### composer: https://getcomposer.org/download/
- #### git: https://git-scm.com/downloads
- #### docker: https://docs.docker.com/get-docker/
 
## Setup
### Install
~~~bash
git clone https://github.com/stenmartinlaane/RaintreeTestAssignment
cd ./RaintreeTestAssignment
composer install
composer dump-autoload
~~~
- Start docker daemon if not already started (Launch Docker Desktop).
- Then run the following command:
~~~bash
docker-compose up -d --build
~~~
If you encounter error `Uncaught Error: Class "mysqli" not found` while running the code, enable the `extension=mysqli` in `php.ini`.

### Configure env
If you are not using docker database you can configure the connection here:
~~~bash
code Config/.env
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
php ./App/App.Console/scripts.php statistics
~~~
### Exercise 3 – Object-oriented PHP.
Patient class:
~~~bash
code ./App/App.Domain/Patient.php
~~~
Insurance class:
~~~bash
code ./App/App.Domain/Insurance.php
~~~
PatientRecord interface:
~~~bash
code ./Base/Base.Contracts.Domain/PatientRecord.php
~~~
Test script to test the features of Patient and Insurance classes:
~~~bash
code ./App/App.Console/test-script.php
~~~
Run it
~~~bash
php ./App/App.Console/scripts.php test-script
~~~