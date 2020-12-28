
init :
	composer self-update
	symfony self-update
	composer global update
	composer update
	yarn install
	yarn run encore dev

asset:
	yarn run encore dev

######################################
#          C O N T R O L S           #
######################################

security:
	security-checker security:check

composer:
	composer -vv validate --strict

twig:
	bin/console lint:twig templates/ lib/Resources/views/
	twigcs templates -vv
	twigcs lib/Resources/views -vv

yaml:
	bin/console lint:yaml config lib/Resources/config phpstan.neon.dist .travis.yml

cs:
	~/.config/composer/vendor/bin/php-cs-fixer fix

stan:
	if [ ! -d "var/cache/phpunit/phpunit-8.3-0" ]; then vendor/bin/simple-phpunit install -v; fi
	~/.config/composer/vendor/bin/phpstan analyse src tests --level max

validate: security composer twig yaml stan cs

############################################
#          P H P   V E R S I O N           #
############################################

7.1:
	sudo update-alternatives --set php /usr/bin/php7.1

7.2:
	sudo update-alternatives --set php /usr/bin/php7.2

7.3:
	sudo update-alternatives --set php /usr/bin/php7.3

7.4:
	sudo update-alternatives --set php /usr/bin/php7.4

############################################
#      S Y M F O N Y   V E R S I O N       #
############################################

dev:
	composer config minimum-stability dev

beta:
	composer config minimum-stability beta

stable:
	composer config minimum-stability stable

4.3: stable
	composer config extra.symfony.require 4.3.*

4.4: stable
	composer config extra.symfony.require 4.4.*

5.0: stable
	composer config extra.symfony.require 5.0.*

5.1: dev
	composer config extra.symfony.require 5.1.*

############################################
#               S E R V E R                #
############################################

start:
	symfony server:stop
	symfony server:start -d
	symfony server:list

stop:
	symfony server:stop
	symfony server:list

restart: start

status:
	symfony server:status

############################################
#             D A T A B A S E              #
############################################

dbdrop:
	bin/console doctrine:database:drop --force

dbinit:
	bin/console doctrine:database:create
	bin/console doctrine:schema:create --no-interaction

dbreset: dbdrop dbinit

fixtures: dbreset
	bin/console doctrine:fixtures:load
	cp var/data/sqlite.db var/data/origine.db

############################################
#                T E S T S                 #
############################################

# test
# ====
clean:
	bin/console cache:clear --env=test
	bin/console cache:clear --env=dev
	cp var/data/origine.db var/data/sqlite.db

test:
	bin/phpunit -v

cover-text: clean
	bin/phpunit -v --coverage-text

cover: clean
	bin/phpunit --coverage-html var/test-coverage
