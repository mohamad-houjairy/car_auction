<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::create('auctions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
        $table->decimal('start_price', 10, 2);
        $table->dateTime('start_time');
        $table->dateTime('finish_time');
        $table->enum('status', ['pending', 'ongoing', 'completed', 'canceled']);
        $table->decimal('highest_bid', 10, 2)->default(0); // Ensure this is correct
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
