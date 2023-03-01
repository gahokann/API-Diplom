<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('phone_number', 12)->nullable(true);
            $table->date('date_birth');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
