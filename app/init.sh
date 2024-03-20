#!/bin/bash

#Aqui você tem a possibilidade também de instalar o agente de monitoramento

# Instala as dependências da aplicação
composer update

echo "------------------------------"
echo "---- SETANDO PERMISSOES ------"
echo "------------------------------"
chown -R www-data:www-data /var/www
chmod -R 755 /var/www/storage
chmod -R 755 /var/www/bootstrap

echo "------------------------------"
echo "------ FIM PERMISSOES --------"
echo "------------------------------"

echo "------------------------------"
echo "-------- PHP ARTISAN ---------"
echo "------------------------------"

php artisan storage:link
php artisan migrate:fresh --seed
php artisan sid

echo "------------------------------"
echo "------ FIM PHP ARTISAN -------"
echo "------------------------------"

# Inicia o PHP-FPM
php-fpm && php artisan queue:work

