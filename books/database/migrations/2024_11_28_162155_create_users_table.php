<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Создает поле id (INT, PRIMARY KEY, AUTO_INCREMENT)
            $table->string('name'); // Создает поле name (VARCHAR(255))
            $table->string('email')->unique(); // Создает поле email (VARCHAR(255), UNIQUE)
            $table->enum('role', ['admin', 'user']); // Создает поле role (ENUM)
            $table->timestamps(); // Создает поля created_at и updated_at
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}