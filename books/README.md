Стек технологий
-PHP
-Laravel
-MySQL
-OpenAPI (Swagger)

Установка:

1.Клонируйте репозиторий:

<<<<<<< HEAD
https://github.com/StupachenkoArtem/CADesign.git
=======
git clone https://github.com/yourusername/yourproject.git
>>>>>>> b39f25e7489e4de3276bd7a9fd8b2f08c0f3caf2

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
GET /api/users - Получить список всех пользователей
GET /api/users/{id} - Получить пользователя по ID
POST /api/users - Создать нового пользователя
PUT /api/users/{id} - Обновить информацию о пользователе
DELETE /api/users/{id} - Удалить пользователя

Книги:
GET /api/books - Получить список всех книг
POST /api/books - Создать новую книгу
GET /api/books/{id} - Получить книгу по ID
PUT /api/books/{id} - Обновить информацию о книге
DELETE /api/books/{id} - Удалить книгу

Резервирования:
GET /api/reservations - Получить список всех резервирований
POST /api/reservations/{bookId} - Забронировать книгу
PUT /api/reservations/return/{reservationId} - Вернуть забронированную книгу
DELETE /api/reservations/{reservationId} - Удалить резервирование