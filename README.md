
# testWebAtrio

### Environnement de développement
- **Backend** : Symfony 7.2
- **Frontend** : Angular 19
- **Base de données** : PostgreSQL 16
- **Logiciels utilisés** : PhpStorm, WebStorm, DBeaver
- **Système d'exploitation** : Windows 11 (WSL2)

### URLs d'accès
- **Frontend** : [http://localhost:4200](http://localhost:4200)
- **Backend** : [http://localhost:8080](http://localhost:8080)

## Installation
Cloner le projet
- Se placer dans le dossier **docker/**
- Lancer la commande d'installation : `make install`
- Démarrer le serveur de dev angular : `make start-front`

## Commandes utiles
Commandes (se placer dans le dossier **docker**) :
- Build les conteneurs : `make build`
- Lancer les conteneurs : `make start`
- Stopper les conteneurs : `make down`
- Redémarrer les conteneurs: `make restart`
- Aller dans le conteneur php : `make exec-php`
- Aller dans le conteneur node : `make exec-node`
- Démarrer le serveur de test angular : `make start-front`
