FROM php:8.4-apache-bookworm

RUN set -eux; \
    docker-php-ext-install pdo_mysql; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2enmod mpm_prefork; \
    sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf; \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

EXPOSE 8080
