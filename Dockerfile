FROM php:8.2-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip \
    && docker-php-ext-install zip pdo pdo_pgsql

# Ativa o módulo de reescrita
RUN a2enmod rewrite

# Copia os arquivos do Laravel
COPY . /var/www/html

# Define permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Configura o Apache para apontar para public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Adiciona configurações extras de rewrite para Laravel
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf
