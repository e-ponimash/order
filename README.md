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

###Описание решения
Поставленная задача решается следующим образом:
Контроллер OrdersController принимает HTTP запрос на добавление заказа, и с помощью сервиса обработки заказов OrderService формирует модель Order и сохраняет ее. 
В случае успеха также формирует задачу GenerateBarcodeTask на формирование корректного barcode и помещает его в очередь.

Обработчик очереди (worker) получает задачу GenerateBarcodeTask и выполняет ее (handle). 
Вначале, с помощью сервиса генерации случайного barcode BarcodeService получаем случайный barcode и сохраняем его в БД.
Проверка уникальности реализована в виде уникального индекса таблицы orders. Если при сохранении заказа получили ошибку, создаем повторное задание на GenerateBarcodeTask.
Вторичная проверка и бронирование через внешнее API (BookingServiceInterface) реализуется аналогично.

###Доработка структуры БД №1
Из таблицы orders убираем поля ticket_adult_price, ticket_adult_quantity, tiket_kids_price, ticket_kids_quantity.
```sql
create table orders
(
id int NOT NULL AUTO_INCREMENT,
event_id int,
event_date varchar(10),
barcode varchar(120),
equal_price int(11),
created datetime,
PRIMARY KEY (ID)
)
```

Создаем таблицу-справочник ticket_type
```sql
create table ticket_type(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(120),
    PRIMARY KEY (ID) 
)
```
Данные по количеству и стоимости билетов в заказе будем хранить в таблице tickets для каждого заказа в разрезе типа билета.
```sql
create table tickets (
    id int NOT NULL AUTO_INCREMENT,
    price  int(11),  
    quantity int(11), 
    type_id int(11),
    order_id int(11),

    PRIMARY KEY (ID),
    CONSTRAINT tickers_order_fk FOREIGN KEY (order_id)
        REFERENCES orders(id),
    CONSTRAINT tickers_types_fk FOREIGN KEY (type_id)
        REFERENCES ticket_type(id)
)
```

###Доработка структуры БД №2
Из таблицы tickets убираем количество билетов в заказе и добавляем barcode, т.к. теперь тут будут храниться каждый отдельный билет заказа.
```sql
create table tickets (
    id int NOT NULL AUTO_INCREMENT,
    price  int(11),  
    type_id int(11),
    order_id int(11),
    barcode varchar(120),
    PRIMARY KEY (ID),
    
    CONSTRAINT tickers_order_fk FOREIGN KEY (order_id)
        REFERENCES orders(id),
    CONSTRAINT tickers_types_fk FOREIGN KEY (type_id)
        REFERENCES ticket_type(id)
)
```
Из таблицы orders убираем barcode, т.к. теперь он генерируется для каждого билета отдельно.
```sql
create table orders 
(
    id int NOT NULL AUTO_INCREMENT,
    event_id int,
    event_date varchar(10),
    equal_price int(11),
    created datetime,
    PRIMARY KEY (ID)
)
```
