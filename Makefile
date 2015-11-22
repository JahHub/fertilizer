env = "dev"

###Project tasks
build: configure install-dep db-reset

configure:
	./bin/create-parameters-file
install-dep:
	./bin/install-composer
	./composer.phar install
db-reset:
	app/console doctrine:database:drop --force -e $(env) || true
	app/console doctrine:database:create -e $(env)
	app/console doctrine:schema:create -e $(env)


###Dev env

##Tests
test: unit-test phpcs

unit-test:
	./bin/phpunit
phpcs:
	phpcs

##Coverage
coverage: reset-coverage phpunit-coverage

scrutinizer-coverage:
	./bin/phpunit --coverage-clover=my-coverage-file
reset-coverage:
	rm -rf coverage
phpunit-coverage:
	./bin/phpunit --coverage-html=coverage
