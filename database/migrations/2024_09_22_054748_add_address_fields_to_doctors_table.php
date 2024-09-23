<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('province_id')
                ->nullable()
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('district_id')
                ->nullable()
                ->constrained('districts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('municipality_id')
                ->nullable()
                ->constrained('municipalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');

            $table->dropForeign(['district_id']);
            $table->dropColumn('district_id');

            $table->dropForeign(['municipality_id']);
            $table->dropColumn('municipality_id');
        });
    }
};
