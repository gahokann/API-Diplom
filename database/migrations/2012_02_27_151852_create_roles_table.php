<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('info');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ["name" => "Пользователь", "info" => "Имеет стандартные функции. Производить заказы не возможно!"],
            ["name" => "Заказчик", "info" => "Имеет расширенные функции. Производить заказы возможно!"],
            ["name" => "Менеджер", "info" => "Имеет доступ к Панели администратора. Функции в Панели администратора ограничены!"],
            ["name" => "Бухгалтер", "info" => "Имеет доступ к Панели администратора. Функции в Панели администратора ограничены!"],
            ["name" => "Главный бухгалтер", "info" => "Имеет доступ к Панели администратора. Функции в Панели администратора ограничены!"],
            ["name" => "Генеральный директор", "info" => "Имеет доступ ко всем функциям системы"],
            ["name" => "Технический администратор", "info" => "Технический администратор системы"],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
