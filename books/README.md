Стек технологий:
1.PHP
2.Laravel
3.MySQL
4.OpenAPI (Swagger)

Установка:

1.Клонируйте репозиторий:

https://github.com/StupachenkoArtem/CADesign.git

2.Перейдите в директорию проекта:

cd books

3.Установите зависимости с помощью Composer:

composer install

4.Настройте файл .env:

cp .env.example .env

5.Сгенерируйте ключ приложения:

php artisan key:generate

6.Выполните миграции базы данных:

php artisan migrate

7.Запустите сервер:

php artisan serve


Эндпоинты API

Пользователи:
1) GET /api/users - Получить список всех пользователей
2) GET /api/users/{id} - Получить пользователя по ID
3) POST /api/users - Создать нового пользователя
4) PUT /api/users/{id} - Обновить информацию о пользователе
5) DELETE /api/users/{id} - Удалить пользователя

Книги:
1) GET /api/books - Получить список всех книг
2) POST /api/books - Создать новую книгу
3) GET /api/books/{id} - Получить книгу по ID
4) PUT /api/books/{id} - Обновить информацию о книге
5) DELETE /api/books/{id} - Удалить книгу

Резервирования:
1) GET /api/reservations - Получить список всех резервирований
2) POST /api/reservations/{bookId} - Забронировать книгу
3) PUT /api/reservations/return/{reservationId} - Вернуть забронированную книгу
4) DELETE /api/reservations/{reservationId} - Удалить резервирование
