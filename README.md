# Projeto-TaskManager
Sistema de Gerenciamento de Tarefas

# passos pra fazer funcionar o backend

## baixar ferramentas necessárias
> $ sudo apt update

> $ sudo apt install php mysql-server nodejs npm 7zip php-curl php-mbstring php-mysql php-xml

## instalar composer
> $ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

> $ php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"

> $ php composer-setup.php

> $ php -r "unlink('composer-setup.php');"

## instalar laravel
> $ composer global require laravel/installer

## preparar banco mysql
> $ sudo mysql

> mysql\> CREATE DATABASE laravel_db;

> mysql\> CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'senha123';

> mysql\> GRANT ALL PRIVILEGES ON 'laravel_db.* TO 'laravel_user'@'localhost' WITH GRANT OPTION;

> mysql\> FLUSH PRIVILEGES;

## rodar backend
> $ composer update

> $ composer install

> $ php artisan migrate

> $ php artisan key:generate

> $ composer run dev

# passos pra fazer funcionar o frontend

> $ composer 