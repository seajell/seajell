-----------------------------------------
# THIS PROJECT IS STILL UNDER DEVELOPMENT
-----------------------------------------

# SeaJell
A simple e-Certificate Generator.


## Requirements
1. Access to terminal / SSH
2. Web server (Apache2, NGINX)
2. MySQL / MongoDB
3. Composer
4. NodeJS (for NPM)
5. PHP Extensions (enabled in php.ini)
   1. ext-dom
   2. ext-zip
   3. ext-gd
   4. ext-mysql
   4. etc
6. Appropriate access to web folder.

## Installation
1. Download the source code of this system.
2. Setup your web server (Apache/Nginx) to suit Laravel app.
3. Copy `.env.example` file and rename to `.env`. Configure the `.env` file for database connection.
4. Run `composer update`, `npm update`, `composer install`, `npm install` to update/upgrade and install necessary dependencies.
5. Run `npm run prod` to and compile the assests.
6. Generate the application key with `php artisan key:generate` command. This key will be stored in `.env` file and be used for encryption.
7. (Optional) For production environment, set the `APP_DEBUG` value to `false` to prevent sensitive config to be exposed to the user.
8. Upload the files to your web server.
9. Go to your `/install` to proceed the installation.
The script will add a new `admin` user, migrate the database and generate the application key.
10. System installation is completed!

## License

This system/project is licensed under [GNU GPLv3](COPYING). Each contributions to this system will
be licensed under the same terms. Contributions are listed in [CREDITS](CREDITS) and eKV website in the future.
