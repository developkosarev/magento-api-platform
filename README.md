
## Build compose
```
docker compose build --no-cache
docker compose up --wait 

docker compose -f compose.yaml -f compose.prod.yaml build --no-cache
docker compose -f compose.yaml -f compose.prod.yaml up --wait

SERVER_NAME=your-domain-name.example.com \
APP_SECRET=ChangeMe \
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey \
docker compose -f compose.yaml -f compose.prod.yaml up -d --wait

SERVER_NAME=localhost \
APP_SECRET=ChangeMe \
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey \
docker compose -f compose.yaml -f compose.prod.yaml up -d --wait

docker compose -f compose.yaml -f compose.prod.yaml down
```

## PHP
```bash
php bin/console app:send
docker exec -it sn-php-1 php bin/console app:send
docker exec -it sn-php-1 php bin/console messenger:stop-workers 
docker exec -it sn-php-1 bash
```

## Docker
```bash
docker exec -it sn-php-1 php bin/console app:send
docker exec -it sn-php-1 bash
```

## Queue
```bash
php bin/console messenger:consume -vv external_magento
```

## RabbitMQ
```json
{"email_type":"NEWSLETTER_SUBSCRIBE_CONFIRM", "store_id":1}
```

## Scheduler
```bash
php bin/console messenger:consume -v scheduler_default
```

## Import CSV
```bash
echo $DATABASE_URL
apt-get update && apt-get install -y git curl libmcrypt-dev default-mysql-client
docker cp ./api/src/DataFixtures/mp_gift_cart.csv  magento-api-platform-php-1:/app/var/data/orders.csv
php bin/console import:import-from-csv --import-orders
```

## Mailer
```bash
php bin/console mailer:test d.k@gmail.com --from=fs@gmail.com  --subject=test --body=test
```

## Fixtures
```bash
php bin/console doctrine:fixtures:load
```

## Curl
```bash
curl -k -X GET https://localhost/salesforce/customer_lead
```

## Example
https://github.com/api-platform/demo/blob/4.1/api/src/Entity/User.php

## Docs
https://github.com/dunglas/symfony-docker/blob/main/docs/production.md
https://thomas-baier.medium.com/php-workers-in-docker-environments-the-right-way-27e822546014


<h1 align="center"><a href="https://api-platform.com"><img src="https://api-platform.com/images/logos/Logo_Circle%20webby%20text%20blue.png" alt="API Platform" width="250" height="250"></a></h1>

API Platform is a next-generation web framework designed to easily create API-first projects without compromising extensibility
and flexibility:

* Design your own data model as plain old PHP classes or [**import an existing ontology**](https://api-platform.com/docs/schema-generator).
* **Expose in minutes a hypermedia REST or a GraphQL API** with pagination, data validation, access control, relation embedding,
  filters, and error handling...
* Benefit from Content Negotiation: [GraphQL](https://api-platform.com/docs/core/graphql/), [JSON-LD](https://json-ld.org), [Hydra](https://hydra-cg.com),
  [HAL](https://github.com/mikekelly/hal_specification/blob/master/hal_specification.md), [JSON:API](https://jsonapi.org/), [YAML](https://yaml.org/), [JSON](https://www.json.org/), [XML](https://www.w3.org/XML/) and [CSV](https://www.ietf.org/rfc/rfc4180.txt) are supported out of the box.
* Enjoy the **beautiful automatically generated API documentation** ([OpenAPI](https://api-platform.com/docs/core/openapi/)).
* Add [**a convenient Material Design administration interface**](https://api-platform.com/docs/admin) built with [React](https://reactjs.org/)
  without writing a line of code.
* **Scaffold fully functional Progressive-Web-Apps and mobile apps** built with [Next.js](https://api-platform.com/docs/client-generator/nextjs/) (React),
[Nuxt.js](https://api-platform.com/docs/client-generator/nuxtjs/) (Vue.js) or [React Native](https://api-platform.com/docs/client-generator/react-native/)
thanks to [the client generator](https://api-platform.com/docs/client-generator/) (a Vue.js generator is also available).
* Install a development environment and deploy your project in production using **[Docker](https://api-platform.com/docs/distribution)**
and [Kubernetes](https://api-platform.com/docs/deployment/kubernetes).
* Easily add **[OAuth](https://oauth.net/) authentication**.
* Create specs and tests with **[a developer friendly API testing tool](https://api-platform.com/docs/distribution/testing/)**.

The official project documentation is available **[on the API Platform website](https://api-platform.com)**.

API Platform embraces open web standards and the
[Linked Data](https://www.w3.org/standards/semanticweb/data) movement. Your API will automatically expose structured data.
It means that your API Platform application is usable **out of the box** with technologies of
the semantic web.

It also means that **your SEO will be improved** because **[Google leverages these formats](https://developers.google.com/search/docs/guides/intro-structured-data)**.

Last but not least, the server component of API Platform is built on top of the [Symfony](https://symfony.com) framework,
while client components leverage [React](https://reactjs.org/) ([Vue.js](https://vuejs.org/) flavors are also available).
It means that you can:

* Use **thousands of Symfony bundles and React components** with API Platform.
* Integrate API Platform in **any existing Symfony, React, or Vue application**.
* Reuse **all your Symfony and JavaScript skills**, and benefit from the incredible amount of documentation available.
* Enjoy the popular [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html) (used by default, but fully optional:
  you can use the data provider you want, including but not limited to MongoDB and Elasticsearch)

## Install

[Read the official "Getting Started" guide](https://api-platform.com/docs/distribution/).

## Credits

Created by [Kévin Dunglas](https://dunglas.fr). Commercial support is available at [Les-Tilleuls.coop](https://les-tilleuls.coop).
