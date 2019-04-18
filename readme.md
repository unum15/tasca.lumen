# Tasca Lumen

Tascsa Lumen is PHP Lumen based backend for tracking clients and scheduling for small contractors.
## Official Documentation

Documentation can be found on the [Github Wiki](https://github.com/unum15/tasca.lumen/wiki).

Tasca Lumen is open-sourced software licensed under the [GPL 3 License](https://opensource.org/licenses/GPL-3.0)

#Install

install php
install postgresql
createuser tasca
psql tasca -c "ALTER ROLE tasca password 'tascapw'"
createdb tasca -O tasca
git clone git@github.com:unum15/tasca.lumen.git
cd tasca.lumen
composer install
cp .env.example .env
./artisan migrate
./artisan db:init
sudo cp tasca.conf /etc/nginx/sites-available/
sudo ln -s /etc/nginx/sites-available/tasca.conf /etc/nginx/sites-enabled
