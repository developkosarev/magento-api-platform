# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.

composer require symfony/messenger

docker compose run --user root php bash
docker compose run --user www-data php bash

php bin/console app:send
php bin/console messenger:consume async_magento -vv
php bin/console messenger:consume scheduler_default --time-limit=86400 -vv

php bin/console cache:clear --env=dev

## Build github
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

## Build docker hub
```
docker build --tag magento-api-platform:v0.0.9 --file Dockerfile .
docker tag magento-api-platform:v0.0.9 developkosarev/magento-api-platform:v0.0.9
docker images developkosarev/*
docker login -u developkosarev
docker push developkosarev/magento-api-platform:v0.0.9 
```

## Build AWS ecr
```
docker build --tag magento-api-platform:aws0.0.1 --file Dockerfile .
docker tag magento-api-platform:aws0.0.1 801404438871.dkr.ecr.eu-central-1.amazonaws.com/sunday/magento-api-platform:aws0.0.1
docker images "801404438871.dkr.ecr.eu-central-1.amazonaws.com/sunday/*"
aws ecr get-login-password --region eu-central-1 | docker login --username AWS --password-stdin 801404438871.dkr.ecr.eu-central-1.amazonaws.com/sunday/
docker push 801404438871.dkr.ecr.eu-central-1.amazonaws.com/sunday/magento-api-platform:aws0.0.1
```

## Tags
```
git tag v0.0.3
git push --tags
git push origin-xxx --tags
```

## Commands
```
php bin/console salesforce:lead:populate --start-date=2024-01-01 --end-date=2025-02-01
php bin/console salesforce:lead:send
php bin/console app:send:email xx.yy@gmail.com

php bin/console bloomreach:customer-segment:import 99 1 -v --force --no-debug
```

## Git
```
git remote -v
git push origin-sunday
```
