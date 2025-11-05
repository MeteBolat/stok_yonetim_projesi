FROM php:8.2-apache

# PHP eklentileri
RUN docker-php-ext-install pdo pdo_mysql mysqli

# mod_rewrite
RUN a2enmod rewrite

# Apache DocumentRoot'u /var/www/public yap
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/public#g' /etc/apache2/sites-available/000-default.conf \
 && printf "\n<Directory /var/www/public>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n" >> /etc/apache2/apache2.conf

# Çalışma dizini (public)
WORKDIR /var/www/public
