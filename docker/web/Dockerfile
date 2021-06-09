FROM banderson/symfony:base

LABEL maintainer="brendan_anderson@hcpss.org"
LABEL vendor="Howard County Public School System"
LABEL org.hcpss.directory.version="3.0.2"

ENV APP_ENV=dev \
	NEO4J_AUTH_USERNAME=neo4j \
	NEO4J_AUTH_PASSWORD=tHis1snotAgOodpa5Sw0rd \
	MONGO_URL=mongodb://root:example@mongo:27017/?authSource=auth-db

RUN install-php-extensions bcmath mongodb

COPY docker/web/conf/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/web/conf/apache/001-api.conf     /etc/apache2/sites-available/001-api.conf
COPY docker/web/conf/apache/ports.conf       /etc/apache2/ports.conf

RUN ln -s /etc/apache2/sites-available/001-api.conf /etc/apache2/sites-enabled/001-api.conf

# Symfony project structure.
COPY symfony/bin              /var/www/symfony/bin
COPY symfony/config           /var/www/symfony/config
COPY symfony/src              /var/www/symfony/src
COPY symfony/templates        /var/www/symfony/templates
COPY symfony/composer.json    /var/www/symfony/composer.json
COPY symfony/composer.lock    /var/www/symfony/composer.lock
COPY symfony/public/css       /var/www/symfony/public/css
COPY symfony/public/index.php /var/www/symfony/public/index.php

COPY docker/web/entrypoint.sh /entrypoint.sh

RUN mkdir -p /var/www/symfony/var \
	&& composer install -d /var/www/symfony \
	&& chown -R www-data:www-data /var/www/symfony

EXPOSE 8080
