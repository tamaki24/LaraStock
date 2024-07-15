# Laravel 商品管理アプリ
Laravel Breeze / React / SQLite
## 事前準備
``` shell
# 準備
cp .env.example .env
composer install
php artisan key:generate
php artisan config:clear

npm i

touch database/database.sqlite
php artisan migrate:refresh --seed

# サーバー立ち上げ
$ npm run dev
$ php artisan serve

```

