#!/bin/bash

composer install --no-dev -o

php /opt/www/bin/hyperf.php start
