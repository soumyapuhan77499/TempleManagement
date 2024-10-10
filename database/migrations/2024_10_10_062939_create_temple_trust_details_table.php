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
        Schema::create('temple__trust_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('trust_name');
            $table->string('trust_number');
            $table->date('trust_start_date');
            $table->date('trust_end_date')->nullable(); // If the end date is optional
            $table->integer('total_day')->nullable();
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
        Schema::dropIfExists('temple_trust_details');
    }
};
