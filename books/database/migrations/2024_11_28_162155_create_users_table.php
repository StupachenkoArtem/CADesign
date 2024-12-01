<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'user']);
            $table->timestamps();
        });
    
            DB::table('users')->insert([
                'username' => env('ADMIN_NAME', 'admin'), 
                'email' => env('ADMIN_EMAIL', 'admin@gmail.com'), 
                'password' => Hash::make(env('ADMIN_PASSWORD', '12345')),
                'role' => 'admin',
            ]);

    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}