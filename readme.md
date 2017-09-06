# Project iGestion
## About

iGestion project is a web application developed with [Laravel Framework](https://laravel.com/docs/5.4)  Is teh intranet for small companies

For this project the following libraries are used:

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper): Laravel 5 IDE Helper Generator
- [doctrine/dbal](https://github.com/doctrine/dbal): Database Abstraction Layer
- [intervention/image](http://image.intervention.io/getting_started/installation): PHP image handling and manipulation
- [davejamesmiller/laravel-breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs): Laravel Breadcrumbs 3

## Implementation

### Server Requirements

The [Laravel Framework](https://laravel.com/docs/5.4) has a few system requirements:
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

The PFC Project has a few system requirements:
- GDL Library PHP Extension
- MySQL >= 5.6.x
- Sockets PHP Extension
- PHP upload_max_filesize >= 32M
- PHP post_max_size >= 32M


### Installation

1) Download the project from the repository:

```sh
git clone https://github.com/ElenaJMangas/iGestion.git public_html
```
2) Ubicate in public_html

3) Change write permissions [777] recursively to the following folders:
```sh
/storage/app/
/storage/framework/
/storage/logs/
/bootstrap/cache/
/public/uploads/
```

4) Duplicate the file **.env.example** and rename by **.env**. Modify your content this way:

```sh
APP_ENV=[current environment: local | dev | preprod | prod]
APP_KEY=
APP_DEBUG=false
APP_LOG=daily
APP_LOG_LEVEL=error
APP_URL=[site url]

DB_CONNECTION=mysql
DB_HOST=[server ip]
DB_PORT=[server port]
DB_DATABASE=[database name]
DB_USERNAME=[user]
DB_PASSWORD=[password]

MAIL_DRIVER=smtp
MAIL_HOST=[host name]
MAIL_PORT=[host port]
MAIL_USERNAME=[username mail]
MAIL_PASSWORD=[password mail]
MAIL_ENCRYPTION=[type encryption]
MAIL_FROM_ADDRESS=[from mail address]
MAIL_FROM_NAME=[from name]

```

5) Download the dependencies of **composer**:

```sh
composer install --no-dev
```

6) Create database with the following configuration:

```
Character set: utf8mb4 -- UTF-8 Unicode
Collaction: utf8mb4_general_ci
```

7) Generate a new **Application Key**. If the application key is not set, your user sessions and other encrypted data will not be secure!:

```sh
php artisan key:generate
```

8) Generate the structure of the database and basic data:

```sh
php artisan migrate
```

9) Fill the database:

```sh
php artisan db:seed --class=DatabaseSeeder
```

10) Configure your virtualhost pointing to the directory:

```
public_html/public/
```


### Log in

Open the browser with the corresponding url and enter the following login data for administrator:

```
elenajesus.mangasperez@gmail.com
0raOpib3
```

Open the browser with the corresponding url and enter the following login data for user:

```
elenajesus.mangasperez@alum.uca.es
0raOpib3
```

It is strongly recommended that you change the password.

### Finalized

Enjoy!
