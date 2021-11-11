# Tiny Parcel

Project used to manage parcels. Structure:

1. server: server of project, built base on Lumen framework.
2. tiny-parcel-sdk: small library use to integrate with an application.
3. demo: sample file to show how to use the sdk.

# How to set up server

This server part was built base on Lumen framework (#Ref: https://lumen.laravel.com/docs/8.x/installation)

1. Create a database
2. Go to server directory, copy file .env.example to .env. Then fill information of database
3. Run command "composer install" to install the dependencies
4. Run command "php artisan migrate" to create database table
5. Run command "php -S localhost:8000 -t public" to start the built-in PHP development server. Then the url of server
   will be http://localhost:8000
6. We can update the configurations like "secret key" and "price model" in config/tinyparcel.php. The "tp_secret" will
   be used to authenticate (bearer token) as this system didn't have login feature.

# How to set up demo app

We just need set up it as a normally PHP project (ex: install xampp and copy it into htdocs directory).

# Use sdk in demo app

Because this is a demo app, so I didn't register it on Packagist.org, so we will install it manually (in case it was
registered on Packagist.org we can install it by using composer).

1. Copy directory tiny-parcel-sdk to vendor directory of project.
2. Go to directory /vendor/tiny-parcel-sdk and run command "composer install"
3. Add class autoloader. There were the functions already in demo/index.php as the sample. P/s the sample of argument of
   class TPClient:
   ['secret' => 'xxx', 'base_url' => 'xxx']. The argument "secret" is Bearer token, and it has to match with "tp_secret"
   on server.
