<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('body_type');
            $table->integer('door_count');
            $table->string('color');
            $table->integer('mileage');
            $table->integer('power'); // Horsepower
            $table->text('description')->nullable();
            $table->json('images')->nullable(); // Keep this as 'images'
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
        Schema::dropIfExists('cars');
        // Schema::table('cars', function (Blueprint $table) {
        //     $table->dropForeign(['vendor_id']);
        //     $table->dropColumn('vendor_id');
        // });
    }
}
