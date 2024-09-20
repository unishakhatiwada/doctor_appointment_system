<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->date('date_of_birth_ad')->nullable()->after('email');
            $table->string('date_of_birth_bs')->nullable()->after('date_of_birth_ad');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth_ad', 'date_of_birth_bs']);
        });
    }
};
