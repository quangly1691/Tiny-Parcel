# Tiny Parcel

The project is built to manage parcels. It includes the following components:

1. Server: the server side of the project, it is based on the Lumen framework.
2. Tiny-parcel-sdk: a small library use to integrate with an application.
3. Demo: a sample file to show how to use the SDK.

# Setting up the server

This server part was built based on the Lumen framework (#Ref: https://lumen.laravel.com/docs/8.x/installation). Please
use the following step to start the server:

1. Create a database
2. Go to the server directory, copy file .env.example to .env. Then fill in the information of database
3. Run command "composer install" to install the dependencies
4. Run command "php artisan migrate" to create database table
5. Run command "php -S localhost:8000 -t public" to start the built-in PHP development server. Then the URL of the
   server will be http://localhost:8000
6. We can update the configurations like "secret key" and "price model" in config/tinyparcel.php. The "tp_secret" will
   be used to authenticate (bearer token) as this system didn't have a login feature.

# Setting up the demo app

The demo app is set up as a normal PHP project (ex: install "xampp" and copy it into the "htdocs" directory).

# Using SDK in the demo app

I have not registered the SDK on Packagist.org, hence, we will need to install it manually (if it was registered on
Packagist.org we could install it using composer).

1. Copy directory tiny-parcel-sdk to vendor directory of the project.
2. Go to directory /vendor/tiny-parcel-sdk and run the command "composer install"
3. Add class autoloader. There were the functions already in demo/index.php as the sample. P/s the sample of argument of
   class TPClient:
   ['secret' => 'xxx', 'base_url' => 'xxx']. The argument "secret" is the Bearer token, and it has to match with "tp_secret"
   on the server. The "base_url" is the URL of the server (if we use the built-in server as the tutorial above then it
   will be http://localhost:8000).
