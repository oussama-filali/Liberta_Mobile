FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# On veux plus voir l'avertissement ServerName il fait peur
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf