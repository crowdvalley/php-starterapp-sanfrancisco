# php-starterapp-sanfrancisco
============

A starter application in PHP Symfony for building a digital finance marketplace on top of the Crowd Valley API, using the 'San Francisco' theme.

### Installation using Composer

1) Clone this repository to your local development environment.

2) If you don't have Composer yet, download it following the instructions on `http://getcomposer.org/` or just run the following command:

```
curl -s http://getcomposer.org/installer | php

php composer.phar install
```

3) Copy the file ~/php-starterapp-sanfrancisco/app/config/parameters.yml.dist to ~/php-starterapp-mountainview/app/config/parameters.yml

4) Enter your Crowd Valley credentials, which would have been provided to you by your Crowd Valley contact or when setting up
a developer account on www.crowdvalley.com, in the new `parameters.yml` file:

```
    cv_api_key: <enter your API Key here>
    cv_api_secret: <enter your API Secret here>
    cv_network: <enter your Network Name here>
```

3) Finally, you can run:

```
composer install
```

The files will be downloaded and by default placed into a `vendors` folder within the root of your application.

5) From the project's directory, run `php app/console assets:install web` to install the application's assets.

6) From the same directory, run `php app/console server:run` to run the application using the built-in server. 

7) Start setting up your Offering data by logging in to your admin Back Office application at https://backoffice.sandbox.crowdvalley.com 
