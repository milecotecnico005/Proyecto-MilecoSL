# Usar la imagen base de PHP
FROM php:8.2-fpm

# Instalar dependencias necesarias para PHP, MySQL y la extensión Imagick
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libzip-dev \
    libmagickwand-dev \
    libmariadb-dev-compat \
    libexif-dev \
    libmagickcore-dev \
    && apt-get clean

# Instalar las extensiones necesarias de PHP
RUN docker-php-ext-install gd exif pdo pdo_mysql zip

# Instalar la extensión Imagick usando PECL
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos de Composer
COPY composer.json composer.lock ./ 

# Instalar las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Copiar el resto de los archivos del proyecto
COPY . .

# Configurar permisos correctos para la carpeta de almacenamiento y caché
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para iniciar el servidor PHP-FPM
CMD ["php-fpm"]
