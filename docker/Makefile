DOCKER_COMPOSE = docker compose
POSTGRES_SERVICE = postgres
PHP_SERVICE = php
NODE_SERVICE = node

down:
	@echo "Arrêt des conteneurs..."
	$(DOCKER_COMPOSE) down --remove-orphans

build:
	@echo "Build des conteneurs..."
	$(DOCKER_COMPOSE) build

start:
	@echo "Démarrage des conteneurs..."
	$(DOCKER_COMPOSE) up -d

restart:
	make down
	make start

build-restart:
	make down
	make build
	make start

exec-php:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bash

exec-node:
	$(DOCKER_COMPOSE) exec $(NODE_SERVICE) bashe