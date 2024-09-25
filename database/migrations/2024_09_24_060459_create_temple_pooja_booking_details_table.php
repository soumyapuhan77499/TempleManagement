<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temple__pooja_booking_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('pooja_image');
            $table->string('pooja_name');
            $table->string('pooja_price'); // Pooja price with 2 decimal places
            $table->text('pooja_descp')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            
            // Add foreign key if necessary
            // $table->foreign('temple_id')->references('id')->on('temples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temple__pooja_booking_details');
    }
};
