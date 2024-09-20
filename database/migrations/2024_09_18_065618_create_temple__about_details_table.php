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
        Schema::create('temple__about_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id'); // Foreign key to the temples table
            $table->text('temple_about');
            $table->text('temple_history');
            $table->string('type')->nullable(); // Endowment or Trust
            $table->string('temple_reg_no')->nullable(); // Register number for Endowment or Trust
            $table->string('temple_document')->nullable(); // Path for the uploaded document
            $table->boolean('status')->default(1); // Active or inactive status
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
        Schema::dropIfExists('temple__about_details');
    }
};
