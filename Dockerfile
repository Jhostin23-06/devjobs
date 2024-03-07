FROM php:8.2-fpm

# Instala las extensiones de PHP necesarias
RUN docker-php-ext-install pdo_mysql

# Copia el archivo de configuración de PHP local en el contenedor
# definir la variable WWWGROUP para que el contenedor pueda escribir en el directorio
# de la aplicación
COPY ./php.ini /usr/local/etc/php/


# Instala Composer en el contenedor
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
