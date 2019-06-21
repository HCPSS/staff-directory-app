FROM banderson/symfony

ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=symfony
ENV MYSQL_USER=symfony
ENV MYSQL_PASSWORD=symfony
ENV SYMFONY_SECRET=ThisIsNotASecret
ENV SYMFONY_ENV=dev

COPY docker/web/000-default.conf /etc/apache2/sites-available/000-default.conf

# Symfony project structure.
COPY symfony/bin                         /var/www/symfony/bin
COPY symfony/config                      /var/www/symfony/config
COPY symfony/src                         /var/www/symfony/src
COPY symfony/templates                   /var/www/symfony/templates
COPY symfony/tests                       /var/www/symfony/tests
COPY symfony/translations                /var/www/symfony/translations
COPY symfony/composer.json               /var/www/symfony/composer.json
COPY symfony/composer.lock               /var/www/symfony/composer.lock
COPY symfony/public/css                  /var/www/symfony/public/css
COPY symfony/public/apple-touch-icon.png /var/www/symfony/public/apple-touch-icon.png
COPY symfony/public/index.php            /var/www/symfony/public/index.php
COPY symfony/public/favicon.ico          /var/www/symfony/public/favicon.ico
COPY symfony/public/robots.txt           /var/www/symfony/public/robots.txt

RUN mkdir -p /var/www/symfony/var \
	&& composer install -d /var/www/symfony \
    && chown -R www-data:www-data /var/www/symfony

COPY docker/web/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
