<!-- PROJECT LOGO -->
<div align="center">
  <h3 align="center">Docker Laravel MySQL Nginx Starter</h3>
  <p align="center">
    Project Starter For Web Application Development with Laravel, MySQL, Nginx, and Docker.
    <br />
  </p>
</div>

<!-- ABOUT THE PROJECT -->
## Features

* [Docker](https://www.docker.com/)
* [Dockerfile with Alpine](https://hub.docker.com/_/alpine)
* [Nginx](https://www.nginx.com)
* [Laravel 13.8](https://laravel.com/)
* [MySQL](https://www.mysql.com/)
* [PHP 8.3](https://nodejs.org)
* [Node](https://nodejs.org)
* [NPM](https://www.npmjs.com)
* [PHP Prettier](https://github.com/prettier/plugin-php)
* [Github Action To Run Prettier Check](https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/actions)
* [Github Action To Run PHP Unit Test](https://github.com/ishaqadhel/docker-laravel-mysql-nginx-starter/actions)

<!-- GETTING STARTED -->
## Getting Started

Follow the instructions below to set up your project.

### Prerequisites

- Download and Install [Docker](https://docs.docker.com/engine/install/)

### Clone This Template For Your Project

- By Clicking Use This Template Button or You can Click [Here](https://github.com/vamcart/laravel-docker-compose-nginx-mysql)

<!-- USAGE EXAMPLES -->
## Run Laravel App

![preview-docker-laravel](https://user-images.githubusercontent.com/49280352/131224609-401fcd2b-a815-49f2-8164-b6d9b77df87c.gif)

- Run command ```git clone git@github.com:vamcart/laravel-docker-compose-nginx-mysql.git``` on your terminal
- Run command ```cd laravel-docker-compose-nginx-mysql``` on your terminal
- Run command ```sudo docker compose up -d --build``` on your terminal
- Run command ```sudo docker exec -it laravel-app-php /bin/sh``` on your terminal
- Run command ```composer install``` on your terminal after going into the php container on docker
- Run command ```cp .env.example .env```
- Run command ```chmod -R 777 storage``` on your terminal after going into the php container on docker
- Run command ```php artisan key:generate```
- Run command ```php artisan migrate```
- Run command ```chmod 777 ./database/database.sqlite``` on your terminal after going into the php container on docker
- To run artisan commands like migrate, etc. go to php container using ```docker exec -it php /bin/sh```
- Go to http://localhost:8001 or any port you set to open Laravel

## Notes

- If you encounter a permission error when running Docker, try running it as an administrator or using ```sudo``` in Linux.
- Don't forget to run ```npm run format``` inside your php container before you push your code.
- Don't forget to run ```php artisan test``` inside your php container before you push your code.
