<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->integer('province_code')->unique();
            $table->string('nepali_name');
            $table->string('english_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
