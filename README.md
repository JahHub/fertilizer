Fertilizer
==
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7b4b3585-f33b-4ae6-bab7-30cef98e2e70/big.png)](https://insight.sensiolabs.com/projects/7b4b3585-f33b-4ae6-bab7-30cef98e2e70)

[![Build Status](https://travis-ci.org/JahHub/fertilizer.svg?branch=master)](https://travis-ci.org/JahHub/fertilizer)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JahHub/fertilizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JahHub/fertilizer/?branch=master)[![Code Coverage](https://scrutinizer-ci.com/g/JahHub/fertilizer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JahHub/fertilizer/?branch=master)[![Build Status](https://scrutinizer-ci.com/g/JahHub/fertilizer/badges/build.png?b=master)](https://scrutinizer-ci.com/g/JahHub/fertilizer/build-status/master)

#How to use 
## Available make tasks
```bash
# project
make build [env=myEnv] # Will do a "make configure", a "make install-dep" and a "make db-create [env=myEnv]"
make configure # Will create the parameters.yml file from parameters.yml.dist file
make install-dep # Will download composer or update it to last version and do a "composer install"
# database
make db-reset [env=myEnv] # Will do a "make db-drop [env=myEnv]" following by a "make db-create [env=myEnv]"
make db-drop [env=myEnv] # Will remove the database if exist for 'myEnv' environment
make db-create [env=myEnv] # Will create the database. Database must not exist else task will be on error for 'myEnv' environment

#Dev/test env
# Tests
make test # Will launch a "make phpcs" and a "make phpunit"
make phpcs # Will launch phpcs tests
make phpunit # Will launch phpunit tests
make paratest [paratest_process_count=N] # Will launch phpunit tests in N thread

# Coverage
make coverage  [paratest_process_count=N] # Will do a "make reset-coverage" and a "make paratest-coverage  [paratest_process_count=N]"
make phpunit-coverage # Will launch phpunit tests with html coverage created on 'coverage' directory
make paratest-coverage [paratest_process_count=N] # Will launch phpunit tests in N thread with html coverage created on 'coverage' directory
make scrutinizer-coverage [paratest_process_count=N] # Will create coverage for scrutinizer in N threads
make reset-coverage # Will remove 'coverage' directory
```
## Create environment
```bash
make build [env=dev]
```
## Test environment
```bash
make build env=test
make test
```
## Test environment with paratest (4 threads)
```bash
make build env=test # Will create the 'test' database for first thread
make db-create env=test_1 # Will create the 'test_1' database for second thread
make db-create env=test_2 # Will create the 'test_2' database for third thread
make db-create env=test_3 # Will create the 'test_3' database for last thread
make phpcs
make paratest paratest_process_count=4
```
## Create coverage with phpunit
```bash
make build env=test
make coverage-reset
make phpunit-coverage
```
## Create coverage with paratest (more faster)
```bash
make build env=test # Will create the 'test' database for first thread
make db-create env=test_1 # Will create the 'test_1' database for second thread
make db-create env=test_2 # Will create the 'test_2' database for third thread
make db-create env=test_3 # Will create the 'test_3' database for last thread
make coverage paratest_process_count=4
```
