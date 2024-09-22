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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('muni_type_id')->constrained('municipality_types', 'id');
            $table->foreignId('district_id')->constrained('districts', 'id');
            $table->char('muni_code', 255)->unique();
            $table->string('muni_name');
            $table->string('muni_name_en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalities');
    }
};
