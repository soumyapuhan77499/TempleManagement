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
        Schema::create('temple__news', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('notice_name');
            $table->date('notice_date');
            $table->text('notice_descp');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('temple__news');
    }
};
