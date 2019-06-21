#!/usr/bin/env bash

chown -R www-data:www-data /var/www/symfony/var

# Wait for MySQL
while ! mysqladmin ping -hdb --silent; do
    echo "Waiting for database connection..."
    sleep 5
done

php bin/console doctrine:migrations:migrate -n

exec "$@"
