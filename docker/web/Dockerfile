FROM banderson/symfony:4

ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=symfony
ENV MYSQL_USER=symfony
ENV MYSQL_PASSWORD=symfony
ENV SYMFONY_SECRET=ThisIsNotASecret

# PHP and Apache configuration.
COPY docker/web/config/php-prod.ini     /etc/php/7.1/apache2/php.ini
COPY docker/web/config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Symfony project structure.
COPY symfony/app             /var/www/symfony/app
COPY symfony/src             /var/www/symfony/src
COPY symfony/composer.json   /var/www/symfony/composer.json
COPY symfony/composer.lock   /var/www/symfony/composer.lock
COPY symfony/web/css         /var/www/symfony/web/css
COPY symfony/web/.htaccess   /var/www/symfony/web/.htaccess
COPY symfony/web/app.php     /var/www/symfony/web/app.php
COPY symfony/web/favicon.ico /var/www/symfony/web/favicon.ico
COPY symfony/web/robots.txt  /var/www/symfony/web/robots.txt

RUN composer install -d /var/www/symfony \
    && chown -R www-data:www-data /var/www/symfony/app/cache \
    && chown -R www-data:www-data /var/www/symfony/app/logs
