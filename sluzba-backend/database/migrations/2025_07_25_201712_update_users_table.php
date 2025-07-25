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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');

            $table->string('broj_indeksa')->nullable();
            $table->unsignedTinyInteger('godina_studija')->nullable();
            $table->string('smer')->nullable();
            $table->enum('role', ['student', 'sluzbenik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable();

            $table->dropColumn('broj_indeksa');
            $table->dropColumn('godina_studija');
            $table->dropColumn('smer');
            $table->dropColumn('role');
        });
    }
};
