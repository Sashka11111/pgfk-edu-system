#!/bin/bash

# Перехід до директорії додатку
cd /home/site/wwwroot

# Встановлення прав доступу
chmod -R 755 .
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Перевірка наявності файлу .env
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Створення символічного посилання для сховища
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

# Кешування конфігурації
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск міграцій
php artisan migrate

# Створення файлу перенаправлення для Nginx
cat > /home/site/wwwroot/index.php << 'EOL'
<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 */

// Перенаправлення до public/index.php
require_once __DIR__.'/public/index.php';
EOL

# Створення .htaccess файлу для перенаправлення
cat > /home/site/wwwroot/.htaccess << 'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL

# Створення та копіювання конфігурації Nginx
cat > /home/site/wwwroot/default.conf << 'EOL'
server {
    listen 8080;
    server_name _;
    root /home/site/wwwroot/public;
    index index.php;

    charset utf-8;
    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOL

# Спроба копіювання конфігурації Nginx (може потребувати прав адміністратора)
if [ -d "/etc/nginx/sites-available" ]; then
    # Спроба копіювання без sudo
    cp /home/site/wwwroot/default.conf /etc/nginx/sites-available/default 2>/dev/null || echo "Could not copy Nginx config (may need admin rights)"

    # Спроба перезапуску Nginx
    service nginx reload 2>/dev/null || echo "Could not reload Nginx (may need admin rights)"
fi

# Альтернативний шлях для Azure App Service
if [ -d "/home/site/wwwroot" ]; then
    # Створення символічного посилання в директорії, яку може використовувати Nginx
    mkdir -p /home/site/nginx
    cp /home/site/wwwroot/default.conf /home/site/nginx/default.conf

    # Створення файлу для Azure, який може вказувати на конфігурацію Nginx
    echo "NGINX_CONF_PATH=/home/site/nginx/default.conf" > /home/site/wwwroot/.env.nginx
fi
