<h1 align="center">
  <img src="https://admin.todayfit.fr/build/images/logo_white.png" />
</h1>

TodayFit is a website created as a educational project for the "Graduate Développeur Web Full Stack" programme of <b><a href="https://www.studi.com" target="_blank">STUDI</a></b> Digital School
<br></br>
Is a website on top of <b><a href="https://symfony.com" target="_blank">Symfony</a></b>.

You can test the deployed site here: 

<p align="center">
  <a href="https://admin.todayfit.fr" target="_blank" ><img src="https://admin.todayfit.fr/build/images/logo_white.png" alt="logo todayfit" width="100px" /></a>
</p>


# TodayFit Application
====================

## 📦 Requirements

Before anything, you need the following software installed on your machine:

  * PHP 8.1.0 or higher
  * Node JS
  * composer
  * and the other <a href="https://symfony.com/doc/current/setup.html#technical-requirements" target="_blank">usual Symfony application requirements</a>
<br></br>


## ⚙️ Installation

### ⚙️ Application initialisation

To install the project, you must at first clone the code repository :
```
    git@github.com:jjmora/todayfit_app.git
```
or 
```
    https://github.com/jjmora/todayfit_app.git
```

or download the <a href="https://github.com/jjmora/todayfit_app/archive/refs/heads/master.zip">ZIP</a> version.
<br></br>

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

Then, execute the commands
```
    composer install
    npm install
    npm run build
```

  ### ⚙️ Database initialisation

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

### ⚠️ Mailing
If you want to use the Mailing feature you need to populate the "MAILER_DSN=" variable in the ".env" (or ".env.local") file.

⚠️ **You can skip this part and going to **"Populate the Database"** section if you want to load data automatically with fixtures*. ⚠️
### ⚙️ Admin user

This project uses a login form, and you need to login to access some particular pages on the application.

You need to create first an Admin user. You can do it with sql commands or with Data Fixtures (see below). But first you will need a hashed password. Execute the following command and type your password. Copy the Password hash (you will need it later).
```
php bin/console security:hash-password
```
Now, you can create an Admin User with the sql command line. Select the Database and Insert the values
```
  use database_name

  INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES('user@admin.com','["ROLE_ADMIN"]', 'your-hashed-password', 1, 1);

```

You are now able to take a first look to the application.

**Start your server** 

```php -S localhost:8000 -t public```

And visit "http://localhost:8000/" and it will automatically redirect you to the Login Page.
Use your new user to login. You can browse the pages but you will only be able to see an empty application without any data.

## 📗 Populate the DataBase
------------------------

Before we need to know the contraints for populating the database related to the entities relationships.

 We have 4 types of entities with some constraints for its creation:

  * **Users** => you only need an Admin User -> ok, we got that!
  * **Permissions** => you only need an Admin User -> ok, we got that!
  * **Franchises** => you need a user with role "ROLE_FRANCHISE" in order to create a new Franchise. This user can't be already linked to another Franchise
  * **Partners** => you need a user with role "ROLE_PARTNER" and at least one Franchise in order to create a new Partner. This user can't be already linked to another Partner

⚠️ **One User can be linked to only one Franchise or Partner** ⚠️

You have 2 Options: 

  * **The Automatic Way**: The Database will be populated with one command on your cli thanks to Data Fixtures 

  * **The Manual Way**:  You vill use the admin user created before and the forms on the website and/or sql commands

### 📗 **THE AUTOMATIC OPTION**

We'll use Fixtures for populating the Database. Execute the following command
<br></br>
⚠️ **Attention: this command will DELETE all the data from your Database!** ⚠️

```
php bin/console doctrine:fixtures:load
```
All the data from the databse will be deleted and the sample data will be loaded. Check your database for verification. If you have created a Admin User before, this will be now useless.

The data for the connexion created for the fixture are:
  - Admin User:
      email: admin@todayfit.fr
      password: tfit@pass
  - Franchise User:
      email: any of the generated emails, for example: 'idf@todayfit.fr' or 'sud@todayfit.fr' (connected with the admin account, check all the Franchises emails here: http://localhost:8000/admin/user )
      password: tfit@pass
  - Partner User:
      email: any of the generated emails, for example: 'creteil@todayfit.fr' or 'montpellier@todayfit.fr' (connected with the admin account, check all the Franchises emails here: http://localhost:8000/admin/user )
      password: tfit@pass

The e-mail fields are generated randomly from a list of users and server names. Is unlikely that two equal emails will be generated but in the case you'll have an error like this:
```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'leo-  
  eva@gmail.com' for key 'UNIQ_8D93D649E7927C74'
```
just try again the fixture command.

**MANUAL OPTION**

You can use all the project forms to create new entities.

Here you will find some SQL commands that you can use to create two new users before creating a Franchise and/or a Partner:

**Franchise User**:
```
INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES('user@franchise.com','["ROLE_FRANCHISE"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);
```
**Partner User**:
```
INSERT INTO user(email, roles, password, is_verified, password_reset) VALUES ('user@partner.com','["ROLE_PARTNER"]', '$2y$13$V.O21boLwr7KqIMq9nx/VefrsmhS.1yU207Ep3uCjktOIap8lXAD.', 1, 1);
```
In order to create a new Franchise and/or Partner you can now use the forms on the website.



The Database will be populated with just one command on your cli

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

  # possible error with fixtures 
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'leo-  
  eva@gmail.com' for key 'UNIQ_8D93D649E7927C74'
