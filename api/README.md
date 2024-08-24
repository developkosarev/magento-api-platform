# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.

composer require symfony/messenger

docker compose run --user root php bash
docker compose run --user www-data php bash

php bin/console app:send
php bin/console messenger:consume async_magento -vv

## Build
```
docker build --tag magento-api-platform:v0.0.1 --file Dockerfile .
docker run --rm -it --entrypoint=sh magento-api-platform:v0.0.1
docker exec -it sn-php-1 bash; #docker exec -it -u dockeruser sn-php-1 bash

docker tag magento-api-platform:v0.0.1 ghcr.io/developkosarev/magento-api-platform:v0.0.1
docker images ghcr.io/developkosarev/*
docker push ghcr.io/developkosarev/magento-api-platform:v0.0.1
docker run -d -p 80:80 -p 443:443 --name magento-api-platform magento-api-platform:v0.0.1
docker run -d -p 80:80 -p 443:443 --name magento-api-platform magento-api-platform:v0.0.2
```     
