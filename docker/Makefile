DOCKER_COMPOSE = docker compose
POSTGRES_SERVICE = postgres
PHP_SERVICE = php
NODE_SERVICE = node
BACK_DIR = ../back
BACK_ENV_LOCAL_FILE = $(BACK_DIR)/.env.local
DOCKER_ENV_FILE = .env

install:
	@echo "Création du fichier .env.local symfony..."
	@echo 'DATABASE_URL="postgresql://postgres:postgress@postgres:5432/webAtrio?serverVersion=16&charset=utf8"' > $(BACK_ENV_LOCAL_FILE)
	@echo 'APP_ENV=dev' >> $(BACK_ENV_LOCAL_FILE)
	@echo ".env.local symfony créé avec succès."

	@echo "Création du fichier .env docker..."
	@echo 'POSTGRES_DB=webAtrio' > $(DOCKER_ENV_FILE)
	@echo 'POSTGRES_USER=postgres' >> $(DOCKER_ENV_FILE)
	@echo 'POSTGRES_PASSWORD=postgress' >> $(DOCKER_ENV_FILE)
	@echo ".env docker créé avec succès."

	@echo "Build des conteneurs..."
	$(DOCKER_COMPOSE) build

	@echo "Démarrage des conteneurs..."
	$(DOCKER_COMPOSE) up -d

	@echo "MAJ COMPOSER..."
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bash -c "composer install"

	@echo "npm install..."
	$(DOCKER_COMPOSE) exec $(NODE_SERVICE) bash -c "npm install"

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
	$(DOCKER_COMPOSE) exec $(NODE_SERVICE) bash

start-front:
	@echo "Démarrage du frontend Angular..."
	$(DOCKER_COMPOSE) exec $(NODE_SERVICE) npx ng serve --host 0.0.0.0 --port 4200