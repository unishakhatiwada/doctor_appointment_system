<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained(table: 'doctors', column: 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('job_title');
            $table->string('type_of_employment');
            $table->string('health_care_name');
            $table->string('health_care_location');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('certificate')->nullable();
            $table->string('additional_detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
