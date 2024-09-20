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
        Schema::table('temple__about_details', function (Blueprint $table) {
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::table('temple__about_details', function (Blueprint $table) {
            $table->dropTimestamps(); // Removes 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
};
