FROM node:20

# Crée le dossier pour le projet frontend
RUN mkdir -p /var/www/front

# Installe les dépendances globales si nécessaire
RUN npm install -g npm

# Définit le répertoire de travail
WORKDIR /var/www/front

# Installe Angular CLI globalement
RUN npm install -g @angular/cli@19

# Garde le conteneur actif
CMD ["tail", "-f", "/dev/null"]