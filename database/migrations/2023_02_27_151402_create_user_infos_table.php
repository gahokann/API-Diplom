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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('first_name', 100);
            $table->string('second_name', 150);
            $table->string('last_name', 150);
            $table->string('photo', 50);
            $table->string('phone_number', 12)->nullable(true);
            $table->date('date_birth');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('user_infos')->insert([
            ["user_id" => 1, 'first_name' => 'Демошенков', 'second_name' => 'Сергей', 'last_name' => 'Михайлович', 'phone_number' => '+79778598026', 'date_birth' => '2022-01-01', 'photo' => 'storage/users/default.png'],
            ["user_id" => 2, 'first_name' => 'Иванов', 'second_name' => 'Иван', 'last_name' => 'Иванович', 'phone_number' => '+79778298026', 'date_birth' => '2022-01-01', 'photo' => 'storage/users/default.png'],
            ["user_id" => 3, 'first_name' => 'Тест', 'second_name' => 'Тест', 'last_name' => 'Тест', 'phone_number' => '+79778578026', 'date_birth' => '2022-01-01', 'photo' => 'storage/users/default.png'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
