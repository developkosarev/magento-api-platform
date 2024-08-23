# API

The API will be here.

Refer to the [Getting Started Guide](https://api-platform.com/docs/distribution) for more information.

composer require symfony/messenger

docker compose run --user root php bash
docker compose run --user www-data php bash

php bin/console app:send
php bin/console messenger:consume async_magento -vv
