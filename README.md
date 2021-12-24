# SnowTricks


## About the project

The goal of this project is to have a website dedicated to snowboard tricks with the information about each trick and discussion space for members.
It has the following functions : 

- snowboard tricks directory with trick name, description and medias;
- tricks management (CRUD);
- discussion space for each trick.

Only the registered members can manage tricks and write comments. 
To create a new account, please use a valid email address, otherwise your account will not be activated. 

## Prerequisites

 -  PHP 7 or higher
 -  Symfony 5
 -  Mysql
 -  Composer
 -  npm

## Installation

### Clone the repo

```
$ git clone https://github.com/AnaMltk/Snowtricks.git yourFolderName
$ cd yourFolderName
```

### Edit .env file OR create .env.local to avoid commiting sensible information 
``` 
DATABASE_URL="mysql://db_user:db_password:@127.0.0.1:3306/db_name?serverVersion=5.7"
MAILER_DSN=smtp://smtp_user_name:smtp_password@smtp_address:smtp_port
```
For **database** connection, assign the values to **db_name**, **db_user** and **db_password**.

For **smtp** connection, assign the values to **smtp_user_name**, **smtp_password**, **smtp_address** and **smtp_port**.
### Create database
run
```
$ php bin/console doctrine:database:create
```
### Composer
run
```
$ composer install
```
### Run latest migration
run
```
$ php bin/console doctrine:migrations:migrate

```
### Upload data fixtures
run
```
$ php bin/console doctrine:load:fixtures

```
### Compile assets for WebpackEncore
run
```
$ npm run dev

```

