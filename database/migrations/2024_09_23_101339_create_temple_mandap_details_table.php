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
        Schema::create('temple__mandap_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('mandap_name');
            $table->text('mandap_description');
            $table->string('booking_type');
         
            $table->string('event_name')->nullable(); // Nullable for event basis
            $table->decimal('price_per_day', 10, 2); // Price per day
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temple__mandap_details');
    }
};
