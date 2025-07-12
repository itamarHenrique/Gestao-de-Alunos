# Etapa 1: Composer - build das dependências
FROM composer:2.6 as build

WORKDIR /app

# Copia apenas arquivos do Composer e instala dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist

# Copia todo o restante da aplicação Laravel
COPY . .

# Etapa 2: Ambiente final com PHP e Apache
FROM php:8.2-apache

# Instala extensões necessárias (incluindo PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Ativa o mod_rewrite (essencial para Laravel)
RUN a2enmod rewrite

# Define o diretório raiz para o Apache como /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Aponta o Apache para a pasta public do Laravel
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copia o app da etapa de build para o container final
COPY --from=build /app /var/www/html

# Ajusta permissões das pastas de cache e storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Define o diretório de trabalho
WORKDIR /var/www/html

# Expõe a porta padrão
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
