# Usa imagem oficial do PHP com FPM
FROM php:8.2-fpm

# Instala extensões e dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip unzip curl git vim \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instala o Composer (do container oficial do Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia todos os arquivos da aplicação
COPY . .

# Instala dependências PHP do Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissões corretas para diretórios usados pelo Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Gera caches do Laravel (rotas e config)
RUN php artisan config:cache && php artisan route:cache

# Expõe a porta usada pelo artisan serve
EXPOSE 8000

# Comando para iniciar a aplicação
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
