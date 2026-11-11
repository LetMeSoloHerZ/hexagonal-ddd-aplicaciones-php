# ============================================================
# Imagen de la aplicacion (PHP + Apache)
#   docker build -t aplicaciones-php .
#   docker run -p 8081:80 --env-file .env aplicaciones-php
# En Render el puerto llega por la variable PORT.
# ============================================================
FROM php:8.2-apache

# Extension PDO MySQL + mod_rewrite (el .htaccess del proyecto lo necesita)
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Configuracion de PHP para produccion (no muestra errores en pantalla)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Apache escucha en $PORT (80 por defecto; Render define otro)
ENV PORT=80
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Codigo de la aplicacion (el .dockerignore deja fuera .env, .git, etc.)
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
