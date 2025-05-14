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
        Schema::create('review', function (Blueprint $table) {
            $table->integer(column: 'id')->autoIncrement()->nullable(false);
            $table->integer(column: 'id_user')->nullable(false);
            $table->integer(column: 'id_book')->nullable(false);
            $table->string('comment')->nullable(false);
            $table->integer(column: 'qualification')->nullable(false);
            $table->string('review_date')->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
