createuser:
	php app/console fos:user:create testuser testuser@stefanius.nl 1234

createadminuser:
	php app/console fos:user:create admin admin@stefanius.nl 1234

install:
	php app/console assetic:dump
	php app/console braincrafted:bootstrap:install
	make createuser
	make createadminuser

create-database:
	php app/console doctrine:database:create
	php app/console doctrine:schema:create

load-fixtures:
	php app/console doctrine:fixtures:load

provision:
	bash /vagrant/dev-setup/install.sh
	make create-database
	make load-fixtures

create-fixtures:
	php app/console stef:fixture:generate:bv-blog
	php app/console stef:fixture:generate:bv-news
	php app/console stef:fixture:generate:bv-page

test:
	php bin/phpunit -c app/

restart-nginx:
	sudo service nginx stop
	sudo service nginx start

gen-entities:
	php app/console doctrine:generate:entities StefBVBundle

cache-clear:
	rm app/cache/dev -rf
	rm app/cache/prod -rf
	rm app/cache/test -rf
	rm app/cache/dev.old -rf
