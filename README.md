# Simple Exchange Currency App



## Prerequisites

- PHP 7.4
- Composer
- Node 14.15
- Npm 6.14

## Stack used:
- Laravel 8.83.23
- Sqlite
- Vue 2.6.12

## Installation
After cloning the repository install backend dependencies with Composer:

`$ composer install`

Copy environment example file

`$ mv .env.example .env`

From the project root create database by running:

`$ touch database/database.sqlite`

Run migration and seeder:

`$ php artisan migrate --seed`

Next, install dependencies for the frontend:

`$ npm install`

Compile assets and build frontend by running:

`$ npm run dev`

From the project root start server by running:

`php artisan serve`

In your browser open up the app by typing in the address: http://localhost:8000.
Make sure your system has port `8000` available.


## Commands

To update rates, please run from the project root:

`$ php artisan currency:update-rates`

This command is "cron-ready" and scheduled to run every day at 6am.




