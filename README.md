<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements

- PHP ^8.1
- Composer ^2.4.4
- Docker ^20.10.21
- Docker-compose ^1.29.2

## Local environment

In the project root directory

- run `composer install` to set up project.
- run `./vendor/bin/sail up` to build and run application container

## Parse products from example website

In the project root directory

- run `./vendor/bin/sail artisan wireless-logic:get-products`

## Run tests

In the project root directory

- run `./vendor/bin/sail compose test`


