env = "dev"
paratest_process_count = 1

###Project tasks
build: configure install-dep db-create

configure:
	./bin/create-parameters-file
install-dep:
	./bin/install-composer
	./composer.phar install

db-drop:
	app/console doctrine:database:drop --force -e $(env) || true
db-create:
	app/console doctrine:database:create -e $(env)
	app/console doctrine:schema:create -e $(env)
db-reset: db-drop db-create


###Dev env

##Tests
test: phpcs paratest

paratest:
	./bin/paratest -p $(paratest_process_count) --phpunit ./bin/phpunit --colors
phpcs:
	phpcs

##Coverage
coverage: reset-coverage paratest-coverage

scrutinizer-coverage:
	./bin/paratest -p $(paratest_process_count) --phpunit ./bin/phpunit --colors --coverage-clover=my-coverage-file
reset-coverage:
	rm -rf coverage
phpunit-coverage:
	./bin/phpunit --coverage-html=coverage
paratest-coverage:
	./bin/paratest -p $(paratest_process_count) --phpunit ./bin/phpunit --colors --coverage-html=coverage
