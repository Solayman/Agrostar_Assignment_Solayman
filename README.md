## About Tuba Project

First you have to inport your sql file to your database. please import database file from db/agrostar.sql and configure .env file.otherwise this project will not run
seeder file already created. please run php artisan db:seed.



- [Main Website](https://agrostar.com.bd/).



## to run this project you have to follow this steps
1. go to your project and open terminal
- composer install<br/>
- copy .env.example .env<br/>
- php artisan key:generate<br/>
- php artisan storage:link<br/>
- php artisan view:cache<br/>
- php artisan route:cache<br/>
- php artisan cache:cache<br/>
- php artisan config:cache<br/>
- php artisan optimize:clear<br/>
- composer dump-autoload<br/>
- php artisan db:seed
## to create migration files from database
- php artisan help migrate:generate for help or <br/>
- php artisan  migrate:generate to migrate<br/>

