# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y     libpng-dev     libjpeg-dev     libfreetype6-dev     zip     unzip     && docker-php-ext-configure gd --with-freetype --with-jpeg     && docker-php-ext-install gd pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . .

# Da permisos a los archivos
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
