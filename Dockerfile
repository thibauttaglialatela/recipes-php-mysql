FROM php:8.2-apache

# Mettre à jour les paquets et installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql

# Copier les fichiers de l'application dans le conteneur
COPY . /var/www/html/

# Créer le répertoire d'uploads et définir les permissions correctes
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

# Définir les permissions correctes pour tous les fichiers de l'application
RUN chown -R www-data:www-data /var/www/html/

# Exposer le port 80
EXPOSE 80

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Le conteneur démarrera avec Apache en mode premier plan par défaut
CMD ["apache2-foreground"]
