# Requirements
1. Access to terminal / SSH
2. Web server (Apache2, NGINX)
3. MySQL / MongoDB
4. NodeJS (for NPM)
5. PHP Extensions (enabled in php.ini)
   1. ext-dom
   2. ext-zip
   3. ext-gd
   4. ext-mysql
   4. All the other extensions needed by the Laravel framework.
6. Appropriate access to web folder.

# The Steps
Setup your web server (Apache/Nginx) to suit Laravel app. Make sure to set the `DocumentRoot` to the `public` folder.
If you're hosting with a shared hosting, the root folder may be something like `html_www`, `htdocs`, `public_html` etc 
so make sure to redirect the requests to the `public`. Refer below.

1. Source code
 - Download the source code of this system.
 - Copy `.env.example` file and rename to `.env`. Configure the `.env` file for database connection.
 - Run `composer update`, `npm update`, `composer install`, `npm install` to update/upgrade and install necessary dependencies.
 - Run `npm run prod` to and compile the assests.
 - Generate the application key with `php artisan key:generate` command. This key will be stored in `.env` file and be used for encryption.
 - (Optional) For production environment, set the `APP_DEBUG` value to `false` to prevent sensitive config to be exposed to the user.
 - Upload the files to your web server.
 - Go to your `/install` to proceed the installation.
   The script will add a new `admin` user, migrate the database and generate the application key.
 - System installation is completed!
2. Compiled binary
 - Download the the compiled binary from the release.
 - Configure the `.env` file for database connection.
 - Generate the application key with `php artisan key:generate` command. This key will be stored in `.env` file and be used for encryption.
 - (Optional) For production environment, set the `APP_DEBUG` value to `false` to prevent sensitive config to be exposed to the user.
 - Upload the files to your web server.
 - Go to your `/install` to proceed the installation.
   The script will add a new `admin` user, migrate the database and generate the application key.
 - System installation is completed!

If you're hosting this system in a shared hosting, make sure to edit or add the `.htaccess` file containing the code below in the root folder to redirect all request to the `public` path. Unfortunately, this system won't work with free shared hosting due to limitations.
```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```
