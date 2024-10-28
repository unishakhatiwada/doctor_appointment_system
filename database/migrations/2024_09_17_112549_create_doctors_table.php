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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')
                ->nullable()
                ->constrained(table: 'departments', column: 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('specialization')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
