<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('permanent_province_id')
                ->nullable()
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('permanent_district_id')
                ->nullable()
                ->constrained('districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('permanent_municipality_id')
                ->nullable()
                ->constrained('municipalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('temporary_province_id')
                ->nullable()
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('temporary_district_id')
                ->nullable()
                ->constrained('districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('temporary_municipality_id')
                ->nullable()
                ->constrained('municipalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['permanent_province_id']);
            $table->dropColumn('permanent_province_id');

            $table->dropForeign(['permanent_district_id']);
            $table->dropColumn('permanent_district_id');

            $table->dropForeign(['permanent_municipality_id']);
            $table->dropColumn('permanent_municipality_id');

            $table->dropForeign(['temporary_province_id']);
            $table->dropColumn('temporary_province_id');

            $table->dropForeign(['temporary_district_id']);
            $table->dropColumn('temporary_district_id');

            $table->dropForeign(['temporary_municipality_id']);
            $table->dropColumn('temporary_municipality_id');
        });
    }
};
