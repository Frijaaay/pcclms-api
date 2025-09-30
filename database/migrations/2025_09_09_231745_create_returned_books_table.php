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
        Schema::create('returned_books', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('borrowed_book_id')->unique();
                $table->foreign('borrowed_book_id')->references('id')->on('borrowed_books')->cascadeOnDelete();
            $table->foreignUuid('librarian_id')->constrained('users')->cascadeOnDelete();
            $table->string('returned_condition')->nullable();
            $table->integer('penalty')->nullable();
            $table->string('penalty_fee_status')->nullable()->default('Unpaid');
            $table->timestamp('returned_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returned_books');
    }
};
