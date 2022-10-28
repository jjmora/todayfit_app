<h1 align="center">
  <img src="https://admin.todayfit.fr/build/images/logo_white.png" />
</h1>

TodayFit is a website created as a educational project for the "Graduate Développeur Web Full Stack" programme of <b><a href="https://www.studi.com" target="_blank">STUDI</a></b> Digital School
<br></br>
Is a website on top of <b><a href="https://symfony.com" target="_blank">Symfony</a></b>.

You can test the deployed site here: 

<p align="center">
  <a href="https://admin.todayfit.fr"><img src="https://admin.todayfit.fr/build/images/logo_white.png" alt="logo todayfit" width="100px" target="_blank" /></a>
</p>


TodayFit Application
====================

Documentation index
-------------------

  * [Installation](doc/installation.md)
  * [Data model](doc/model.md)
  * [Database](doc/data.md)
  * [Provisioning](doc/provisioning.md)
  * [Git Workflow](doc/git-workflow.md)
  * [Environments](doc/environments.md)
  

📦 Requirements
----------------

Before anything, you need the following software installed on your machine:

  * PHP 8.1.0 or higher
  * Node JS
  * composer
  * and the other [usual Symfony application requirements][2].



⚙️ Installation
----------------

Application initialisation
--------------------------

To install the project, you must at first clone the code repository :
```
    git@github.com:jjmora/todayfit_app.git
```
or 
```
    https://github.com/jjmora/todayfit_app.git
```

or download the <a href="https://github.com/jjmora/todayfit_app/archive/refs/heads/master.zip">ZIP</a> version

Then, 
```
    cd todayfit_app
```

Create the ".env" file
```
    touch .env
```
and put this content inside:

```
###> symfony/webapp-pack ###
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
###< symfony/webapp-pack ###

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL=
###< doctrine/doctrine-bundle ###

###> symfony/mailer ###
MAILER_DSN=
###< symfony/mailer ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###

```

Then,

execute the commands
```
    composer install
    npm install
```

Database initialisation
-----------------------

The last thing to do to make the project work locally: you must generate a database filled with entities.

This project uses DoctrineMigrationsBundle, so, first, put your database data access into the "DATABASE_URL=" variable into the ".env" file.
Something similar to:
```
DATABASE_URL="mysql://user_name:password@127.0.0.1:3306/database_name?serverVersion=mariadb-10.4.11"
```
** If you are goint to commit the file ".env" put all this values in a new ".env.local" file that won't be commited.

Then build your database schema:
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Admin user
-----------
This project uses a login form, and you need to login to access some particular pages on the application.

You need to create first a Admin user. You can do it with mysql commands. But first you will need a hashed password. Execute the following command and type your password. Copy the Password hash (you will need later).
```
php bin/console security:hash-password
```
Now, you can create an Admin User
```
  INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES('user@admin.com','["ROLE_ADMIN"]', 'your-hashed-password', 1, 1);

```

You are now able to take a first look to the application.
Start your server and visit "http://localhost:8000/" and it will automatically redirect you to the Login Page.
Use your new user to login. You can browser the pages but you will be able to see an empty application without any data.

Populate the DataBase
---------------------

You can use all the project forms to create new entities. We have 4 types of entities with some constraints for its creation:

  * Users => you only need a Admin User -> ok, we got that!
  * Permissions => you only need a Admin User -> ok, we got that!
  * Franchises => you need a user with role "ROLE_FRANCHISE" in order to create a new Franchise
  * Partners => you need a user with role "ROLE_PARTNER" and at least one Franchise in order to create a new Partner

Here you will find some SQL commands that you can use to create two new users:

Franchise User:
```
INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES('user@franchise.com','["ROLE_FRANCHISE"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);
```
Partner User:
```
INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES ('user@partner.com','["ROLE_PARTNER"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);
```

✍️ Author
----------
[![](https://github.com/jjmora.png?size=40)](https://github.com/jjmora) jjmdev

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://symfony.com/book



ERRORS ON TESTS:

  # webpack.config.js / and symfony.lock
  # js folder with darkMode.js file
    => darkMode.js

  # mailer variable for /register


INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES('user@franchise.com','["ROLE_FRANCHISE"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);
INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES ('user@partner.com','["ROLE_PARTNER"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);

INSERT INTO franchise(name, email, active, user_id) VALUES ('franchise1', 'franchise1@email.com',)