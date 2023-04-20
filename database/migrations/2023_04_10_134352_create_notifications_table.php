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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->string('description');
            $table->string('initiator');
            $table->unsignedBigInteger('order_id')->nullable(true);
            $table->unsignedBigInteger('company_id')->nullable(true);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id')->nullable(true);
            $table->boolean('is_read');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('notification_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
