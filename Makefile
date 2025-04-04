#DOCKER_COMPOSE_APPS = docker compose -f docker-compose.yml
#DOCKER_COMPOSE_DEV = docker compose -f docker-compose.yml -f docker-compose.dev.yml
DOCKER_COMPOSE_DEV = docker compose


args = `arg="$(filter-out $(firstword $(MAKECMDGOALS)),$(MAKECMDGOALS))" && echo $${arg:-${1}}`

green  = $(shell printf "\e[32;01m$1\e[0m")
yellow = $(shell printf "\e[33;01m$1\e[0m")
red    = $(shell printf "\e[33;31m$1\e[0m")

format = $(shell printf "%-40s %s" "$(call green,make $1)" $2)

comma:= ,

.DEFAULT_GOAL:=help

%:
	@:

help:
	@echo ""
	@echo "$(call yellow,Use the following commands)"
	@echo "$(call red,===============================)"
	@echo "$(call format,build,'Build dev')"
	@echo "$(call format,start,'Start dev')"
	@echo "$(call format,stop,'Stop dev')"
	@echo "$(call format,down,'Down dev')"
	@echo "$(call format,bash,'Bash dev')"
	@echo "$(call red,===============================)"
	@echo "$(call format,app-consume,'App consume workers')"
	@echo "$(call format,app-stop-workers,'App stop workers')"
	@echo "$(call red,===============================)"
	@echo "$(call format,app-fixture,'App fixture load')"
	@echo "$(call format,app-tests-fixture,'App tests fixture load --env=test')"
	@echo "$(call format,app-tests,'App tests')"
	@echo "$(call format,app-tests-salesforce,'App tests salesforce')"
	@echo "$(call red,===============================)"
	@echo "$(call format,magento-fixture,'Magento fixture load')"
	@echo "$(call format,magento-fixture-perf,'Magento fixture performance load')"
	@echo "$(call red,===============================)"
	@echo "$(call format,start-apps,'Start apps')"
	@echo "$(call format,stop-apps,'Stop apps')"

build: ## Start dev
	$(DOCKER_COMPOSE_DEV) build --no-cache
.PHONY: build

start: ## Start dev
	$(DOCKER_COMPOSE_DEV) up --wait
.PHONY: start

stop: ## Stop dev
	$(DOCKER_COMPOSE_DEV) stop
.PHONY: stop

down: ## Down dev
	$(DOCKER_COMPOSE_DEV) down
.PHONY: down

bash: ## Bash dev
	docker exec -it magento-api-platform-php-1 bash
.PHONY: bash


app-consume: ## app-consume
	docker exec -it magento-api-platform-php-1 php bin/console messenger:consume -vv external_magento
.PHONY: app-consume

app-stop-workers: ## app-stop-workers
	docker exec -it magento-api-platform-php-1 php bin/console messenger:stop-workers
.PHONY: app-stop-workers


## Tests
app-fixture: ## app-fixture
	docker exec -it magento-api-platform-php-1 php bin/console doctrine:fixtures:load --group=main
.PHONY:

app-tests-fixture:
	docker exec -it magento-api-platform-php-1 php bin/console doctrine:fixtures:load --group=main --env=test
.PHONY: app-tests-fixture

app-tests:
	docker exec -it magento-api-platform-php-1 php bin/phpunit --colors --verbose --testdox
.PHONY: app-tests

app-tests-salesforce:
	docker exec -it magento-api-platform-php-1 php bin/phpunit --colors --verbose --testdox tests/Service/Salesforce
.PHONY: app-tests-salesforce

#Magento fixture
magento-fixture: ## magento-fixture
	docker exec -it magento-api-platform-php-1 php bin/console doctrine:fixtures:load --em=magento --group=magento --purge-exclusions=customer_entity --purge-exclusions=customer_address_entity --purge-exclusions=sunday_newsletter_subscriber --purge-exclusions=sales_order --purge-exclusions=store --purge-exclusions=store_website --purge-exclusions=store_group
.PHONY:

magento-fixture-perf: ## magento-fixture-performance
	docker exec -it magento-api-platform-php-1 php bin/console doctrine:fixtures:load --no-debug --em=magento --group=magento --group=magento-performance --purge-exclusions=sunday_newsletter_subscriber --purge-exclusions=sales_order --purge-exclusions=store --purge-exclusions=store_website --purge-exclusions=store_group
.PHONY:


start-apps: ## Start apps
	$(DOCKER_COMPOSE_APPS) up --build -d
.PHONY: start-apps

stop-apps: ## Stop apps
	$(DOCKER_COMPOSE_APPS) stop
.PHONY: stop-apps
