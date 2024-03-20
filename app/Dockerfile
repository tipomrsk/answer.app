FROM php:8.2-fpm

WORKDIR /var/www

# Instala as dependências
RUN apt-get update
RUN apt-get install -y unzip zip wget nano curl

RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_mysql

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

# Adiciona os arquivos de configuração do PHP
ADD init.sh /var/www/init.sh
ADD php.ini /usr/local/etc/php/php.ini
ADD php-fpm.conf /usr/local/etc/php-fpm.conf
ADD www.conf /usr/local/etc/php-fpm.d/www.conf
ADD opcache.ini /usr/local/etc/php/conf.d/opcache.ini
