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
        Schema::create('temple__trust_member_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('member_name');
            $table->string('member_photo')->nullable();
            $table->text('about_member')->nullable();
            $table->string('member_designation')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('temple__trust_member_details');
    }
};
