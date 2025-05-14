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
            $table->foreign('id_rol')->references('id')->on('roles');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreign('id_category')->references('id')->on('category');
            $table->foreign('id_user')->references('id')->on('users');
        });

        Schema::table('review', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_book')->references('id')->on('books');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign('id_book')->references('id')->on('books');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_rol']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['id_category']);
            $table->dropForeign(['id_user']);
        });

        Schema::table('review', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_book']);
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['id_book']);
            $table->dropForeign(['id_user']);
        });
    }
};