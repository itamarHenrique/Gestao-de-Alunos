FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev unzip \
    && docker-php-ext-install zip pdo pdo_pgsql

# Habilitar mod_rewrite (Laravel precisa)
RUN a2enmod rewrite

# Copiar código fonte para /var/www/html
COPY . /var/www/html

WORKDIR /var/www/html

# Instalar Composer e dependências do Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

# Permissões (ajuste conforme seu setup)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor porta 80
EXPOSE 80

# Rodar Apache em foreground
CMD ["apache2-foreground"]
