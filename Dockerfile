FROM php:8.2-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

# Copia os arquivos do Laravel para dentro do container
COPY . /var/www/html

# Define permissões e owner corretos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Configura o Apache para servir a pasta public/ do Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permite override com .htaccess
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf
