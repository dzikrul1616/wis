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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('username', 100)->unique();
            $table->string('phone', 30);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('level', 100);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('birth_date');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('country', 100);
            $table->string('province', 100);
            $table->text('address');
            $table->string('photo', 255)->nullable();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->string('token', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('status_trash')->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
