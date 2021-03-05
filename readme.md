<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About User Registration Module

To run application user below instruction.
 - Rename .env.example file to .env file
 - Add MAIL_USERNAME = your_gmail  and MAIL_PASSWORD = your_gmail_password. in enc
 - Please enable less secure app in gmail account.
 - Please enable less secure app in gmail account.
 - SmartStreet API Credentials are added in SmartStreetService file.
 - Create Database - ureg
 - Run command - php artisan key:generate
 - Run command - php artisan migrate
 - Run command - php artisan db:seed --class=UsersTableSeeder
 - Run command - php artisan serve

## Credentials

User Credentail 
- username - john@gmail.com password - user@123
- username - rahul@gmail.com password - user@123
- username - johnad@gmail.com password - admin@123

## Points Covered
Below points are covered in this application

 - Create a user registration module with the following fields
Name,Email,Phone,Street Address (While typing, it should auto-suggest the address using smarty street  API.)
City,State,Zip

- Once the user has registered the following things should happen
    1. Send a welcome email to user email id (use Laravel Events)
    2. Using smarty street API Find the county name of that address.
    3. Save the county name into the user table

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
