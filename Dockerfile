# Etapa 1: Ambiente de build para dependências PHP
FROM composer:2.6 AS build

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction

COPY . .

# Etapa 2: Ambiente final com PHP e Apache
FROM php:8.2-apache

# Instala extensões necessárias do Laravel e PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Copia o app
COPY --from=build /app /var/www/html

# Configura permissões e Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Porta exposta
EXPOSE 80

# Comando de inicialização
CMD ["apache2-foreground"]
