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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name', 100)->unique();
            $table->string('partner_email', 150)->unique();
            $table->string('partner_password', 255);
            $table->string('status_partner', 50);
            $table->string('partner_phone', 30)->unique();
            $table->string('partner_image', 255);
            $table->string('country', 80);
            $table->string('province', 80);
            $table->text('address');
            $table->time('open_hour')->nullable();
            $table->time('closed_hour')->nullable();
            $table->string('license', 255)->nullable();
            $table->string('latitude', 150);
            $table->string('longitude', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
