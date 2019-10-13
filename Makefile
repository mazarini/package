
init :
	composer self-update
	composer global update
	composer update
	yarn install

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
#	bin/console lint:twig templates/ lib/Resources/views/
#	twigcs templates -vv
#	twigcs lib/Resources/views -vv

yaml:
	bin/console lint:yaml lib/Resources/config config phpstan.neon.dist

cs:
	php-cs-fixer fix

stan:
	if [ ! -d "var/cache/phpunit" ]; then vendor/bin/simple-phpunit install -v; fi
	phpstan analyse lib src tests --level max

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

stable:
	composer config minimum-stability stable

4.3: stable
	composer config extra.symfony.require 4.3.*

4.4: dev
	composer config extra.symfony.require 4.4.*

5.0: dev
	composer config extra.symfony.require 5.0.*

############################################
#               S E R V E R                #
############################################

start:
	bin/console server:start

stop:
	bin/console server:stop

restart: stop start

status:
	bin/console server:status

############################################
#             D A T A B A S E              #
############################################

dbdrop:
	bin/console doctrine:database:drop --force

dbinit:
	bin/console doctrine:database:create
	bin/console doctrine:schema:create --no-interaction

dbreset: dbdrop dbinit

fixtures:
	bin/console doctrine:fixtures:load

############################################
#                T E S T S                 #
############################################

# test
# ====
clean:
	bin/console cache:clear --env=test
	bin/console cache:clear --env=dev

test:
	vendor/bin/simple-phpunit -v

cover-text:
	vendor/bin/simple-phpunit -v --coverage-text

cover: clean
	vendor/bin/simple-phpunit --coverage-html var/test-coverage
