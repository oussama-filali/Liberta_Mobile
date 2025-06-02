FROM php:8.1-apache

# Active mod rewrite pour Laravel ou autres frameworks
RUN a2enmod rewrite

COPY site/ /var/www/html/
COPY ../apache/default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
