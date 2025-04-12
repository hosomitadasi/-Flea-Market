# -Flea-Market

## 環境構築

Dockerビルド

・git clone git@github.com:coachtech-material/laravel-docker-template.git

・mv laravel-docker-template Flea-Market

・git remote set-url origin 作成したリポジトリのurl

・git add .

・git commit -m "新たなリポジトリ作成"

・git push origin main

・docker-compose up -d --build


Laravel環境構築

・docker-compose exec php bash

・composer install

・cp .env.example .env


PHP unit実装

・docker-compose exec php bash

・composer require --dev phpunit/phpunit ^9.5


Fortify実装

・docker-compose exec php bash

・composer require laravel/fortify

・php artisan migrate


## 開発環境

・お問い合わせ画面：

・ユーザー登録：

・phpMyAdmin：

## 使用技術（実行環境）

・PHP 7.4.9

・Laravel 8.83.8

・Fortify v1.19.1

・MySQL 15.1

・nginx

## ER図
