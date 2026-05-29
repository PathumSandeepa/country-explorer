<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favourite_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('country_code');
            $table->string('name');
            $table->string('capital')->nullable();
            $table->string('flag_url')->nullable();
            $table->text('personal_note')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'country_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favourite_countries');
    }
};
