<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

#Тестовое задание добавление заказов на оформление билетов. 

###Установка и настройка
Создать и скорректировать настройки в файле .env (см .env.example)

```
composer install
php artisan migrate 
```

Запустить процесс worker
```
php artisan queue:work
```

Запустить приложение
```
php artisan serve
```
