<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->unsignedBigInteger('role_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });

        DB::table('users')->insert([
            ["id" => 1, "email" => "topsamper227@mail.ru", "role_id" => "6", "password" => Hash::make(123456789)],
            ["id" => 2, "email" => "test@mail.ru", "role_id" => "1", "password" => Hash::make(123456789)],
            ["id" => 3, "email" => "1@mail.ru", "role_id" => "3", "password" => Hash::make(123456789)],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
