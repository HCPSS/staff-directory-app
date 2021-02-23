FROM banderson/symfony:base

ENV APP_ENV=dev \
	NEO4J_AUTH_USERNAME=neo4j \
	NEO4J_AUTH_PASSWORD=tHis1snotAgOodpa5Sw0rd \
	MONGO_URL=mongodb://root:example@mongo:27017/?authSource=auth-db

RUN install-php-extensions bcmath mongodb

COPY docker/web/000-default.conf /etc/apache2/sites-available/000-default.conf

# Symfony project structure.
COPY symfony/bin              /var/www/symfony/bin
COPY symfony/config           /var/www/symfony/config
COPY symfony/src              /var/www/symfony/src
COPY symfony/templates        /var/www/symfony/templates
COPY symfony/composer.json    /var/www/symfony/composer.json
COPY symfony/composer.lock    /var/www/symfony/composer.lock
COPY symfony/public/css       /var/www/symfony/public/css
COPY symfony/public/index.php /var/www/symfony/public/index.php

RUN mkdir -p /var/www/symfony/var \
	&& composer install -d /var/www/symfony \
	&& chown -R www-data:www-data /var/www/symfony
