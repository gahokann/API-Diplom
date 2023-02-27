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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->integer('quantity');
            $table->date('first_deleviryDate');
            $table->date('last_deleviryDate')->nullable(true);
            $table->string('photo')->nullable(true);
            $table->text('information')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('order_statuses');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
