# Etapa 1: Imagem base com PHP e Apache
FROM php:8.2-apache

# Instala extensões do PHP necessárias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Ativa mod_rewrite para o Laravel funcionar com URLs amigáveis
RUN a2enmod rewrite

# Define o diretório raiz do Apache como /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia todos os arquivos do projeto para o container
COPY . .

# Instala o Composer e as dependências da aplicação
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --no-dev --no-interaction --prefer-dist

# Corrige permissões das pastas de cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expondo a porta padrão da aplicação
EXPOSE 80

# Comando que inicia o servidor Apache
CMD ["apache2-foreground"]
