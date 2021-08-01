## About Tuba Project

First you have to inport your sql file to your database. and configure .env file. otherwise this project will not run

- [Main Website](http://www.tubaglobal.com/).



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
- composer dump-autoload
## to create migration files from database
- php artisan help migrate:generate for help or <br/>
- php artisan  migrate:generate to migrate<br/>

## used to create this project, I have used those following packages
- [Migration Generate](https://github.com/kitloong/laravel-migrations-generator).<br/>
- [For Video Tutorial Migration Generate](https://www.youtube.com/watch?v=eLybI4WPuWc).<br/>
- [Tinymce](https://www.tiny.cloud/).<br/>
- [Unisharp File Manager](https://www.tiny.cloud/).<br/>
- [Dom PDF Laravel](https://github.com/barryvdh/laravel-dompdf).<br/>
- [Laravel Composer Toastr](https://github.com/brian2694/laravel-toastr).<br/>
- [Intervention Image](http://image.intervention.io/).<br/>
- [Mews/purifier](https://packagist.org/packages/mews/purifier).<br/>
- [Sweet Alert](https://github.com/realrashid/sweet-alert).<br/>
- [Sweet Alert](https://github.com/realrashid/sweet-alert).<br/>
- [Yajrabox Laravel Databales](https://yajrabox.com/docs/laravel-datatables/master/installation).<br/>

