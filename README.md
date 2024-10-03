## dadeh pardaz pooyaye sharif Project

### Built With

* [![Laravel][Laravel.com]][Laravel-url]

## Introduction

This is a Laravel project that simulates a payment gateway connected with three banks. In this project, a transaction request is created, and the transactions are processed either manually or automatically (daily) upon approval.
### Requirements

* PHP >= 8.1
* laravel 11
* Composer
* sqlite

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/MR-EP97/dadeh-pardaz-pooyaye-sharif.git
   
   cd dadeh-pardaz-pooyaye-sharif
   ```
2. Install
   ```sh
   composer install
   
   cp .env.example .env

   php artisan key:generate
   ```
3. migrate and seed
   ```sh
   touch database/database.sqlit
   
   php artisan migrate
   
   php artisan db:seed
   ```

4. run
   ```sh
    php artisan serve --port=80
   
    php artisan queue:work
   
    php artisan optimize:clear
   
    
   ```
5. CronJob
    ```sh
   Add this line to the crontab file and Replace `/path/to/your/project` with the actual path to your Laravel projects
   root directory :

    * * * * * php /path/to/your/project/artisan schedule:run >> /dev/null 2>&1
      ```

For more information and to test the software, enter the file " dadeh-pardaz-pooyaye-sharif.postman_collection.json " available in the project into Postman.

[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white

[Laravel-url]: https://laravel.com
