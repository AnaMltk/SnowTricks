# SnowTricks

To verify the forgot password function, please use a valid email address.

## About the project

Le projet doit avoir les fonctionnalités suivantes : 

- un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes ;
- la gestion des figures (création, modification, consultation) ;
- un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

- la page d’accueil où figurera la liste des figures ; 
- la page de création d'une nouvelle figure ;
- la page de modification d'une figure ;
- la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).


## Prerequisites

 -  PHP 7 or higher
 -  Symfony 5
 -  Mysql
 -  Composer
 -  npm

## Installation

### Clone the repo

```
$ git clone https://github.com/AnaMltk/Blog.git
$ cd Blog
$ composer update
```
### Run latest migration
run
```
symfony console doctrine:migrations:migrate

```
### Upload data fixtures
run
```
symfony console doctrine:load:fixtures

```


### Edit .env file
``` 
DATABASE_URL="mysql://db_user:db_password:@127.0.0.1:3306/db_name?serverVersion=5.7"
MAILER_DSN=smtp://smtp_user_name:smtp_password@smtp_address:smtp_port
```
For **database** connection, assign the values to **db_name**, **db_user** and **db_password**.

For **smtp** connection, assign the values to **smtp_user_name**, **smtp_password**, **smtp_address** and **smtp_port**.
