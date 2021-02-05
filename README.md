<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Install

- create .env from .env.example and configure DB and rabbitMq connections
- composer install
- php artisan migrate --seed
- php artisan key:generate

- npm install
- npm run dev

### Run import queue

- php artisan queue:work --queue=import

## About Next Features

- Вытянуть при импорте категории продуктов и добавить фильты по ним на главной

- Обновлять данные о компании при импорте

- Сохранять валютный коэфициент и цену с его учетом

- Свойство available у товара выставлять в false, если при импорте в списке его больше нет

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
