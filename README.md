# HCPSS Directory

1. Set your variables

```
$ cp .env.dist .env
```

And then edit .env to your taste.

2. Install vendors

```
$ docker run --rm --volume $(pwd)/symfony:/app --env-file=$(pwd)/.env composer install
```

3. (Optional) get a backup of the live database and call it symfony.sql. If you don't do this, comment out this line in docker-compose.yml:

```yml
  ...
  db:
    image: mysql:5.5
    container_name: directory_db
    restart: always
    volumes:
      # - ./symfony.sql:/docker-entrypoint-initdb.d/symfony.sql
      - ./.data:/var/lib/mysql
    environment:
    ...
```

3. Launch

```
$ docker-compose up -d
```

4. Visit your site at http://localhost:9090
