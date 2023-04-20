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
        Schema::create('notification_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('notification_statuses')->insert([
            ["name" => "Изменение уровня доступа"],
            ["name" => "Изменение статуса компании"],
            ["name" => "Заказ принят в работу"],
            ["name" => "Заказ снят с работы"],
            ["name" => "Изменён статус заказа"],
            ["name" => "Сообщение в заказе"],
            ["name" => "Добавлена новая компания"],
            ["name" => "Сделан заказ"],
            ["name" => "Изменение личных данных"],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_statuses');
    }
};
