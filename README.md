# Tiny Parcel

The project used to manage parcels. Structure:

1. server: server of project, built base on the Lumen framework.
2. tiny-parcel-sdk: small library use to integrate with an application.
3. demo: sample file to show how to use the SDK.

# How to set up the server

This server part was built based on the Lumen framework (#Ref: https://lumen.laravel.com/docs/8.x/installation)

1. Create a database
2. Go to the server directory, copy file .env.example to .env. Then fill in the information of database
3. Run command "composer install" to install the dependencies
4. Run command "php artisan migrate" to create database table
5. Run command "php -S localhost:8000 -t public" to start the built-in PHP development server. Then the URL of the server
   will be http://localhost:8000
6. We can update the configurations like "secret key" and "price model" in config/tinyparcel.php. The "tp_secret" will
   be used to authenticate (bearer token) as this system didn't have a login feature.

# How to set up the demo app

We just need to set up it as a normal PHP project (ex: install "xampp" and copy it into the "htdocs" directory).

# Use SDK in the demo app

Because this is a demo app, so I didn't register it on Packagist.org, so we will install it manually (in case it was
registered on Packagist.org we can install it by using composer).

1. Copy directory tiny-parcel-sdk to vendor directory of the project.
2. Go to directory /vendor/tiny-parcel-sdk and run the command "composer install"
3. Add class autoloader. There were the functions already in demo/index.php as the sample. P/s the sample of argument of
   class TPClient:
   ['secret' => 'xxx', 'base_url' => 'xxx']. The argument "secret" is Bearer token, and it has to match with "tp_secret"
   on server.
