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
        Schema::create('books', function (Blueprint $table) {
            $table->integer(column: 'id')->autoIncrement()->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('author')->nullable(false);
            $table->timestamp('publication_date')->nullable(false);
            $table->integer(column: 'id_category')->nullable(false);
            $table->integer(column: 'id_user')->nullable(false);

          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
