<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained(table: 'doctors', column: 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('degree');
            $table->string('university');
            $table->string('institute');
            $table->string('field_of_study');
            $table->date('joining_date');
            $table->string('graduation_date');
            $table->string('grade');
            $table->string('certificate')->nullable();
            $table->string('additional_detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
