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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('item_name');           // Name of the rented item
            $table->text('description')->nullable(); // Optional description
            $table->decimal('price', 10, 2);       // Price of the rental
            $table->date('start_date');            // Rental start date
            $table->date('end_date')->nullable();  // Rental end date (optional)
            $table->timestamps();                  // created_at & updated_at

            // Optional: add foreign key constraint if users table exists
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
