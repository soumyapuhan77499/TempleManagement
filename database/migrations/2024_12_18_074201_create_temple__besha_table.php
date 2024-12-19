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
        
        Schema::create('temple__beshas', function (Blueprint $table) {
            $table->id();
            $table->string('besha_name');
            $table->text('items');
            $table->text('description')->nullable();
            $table->time('estimated_time');
            $table->string('time_period');
            $table->date('date');
            $table->string('weekly_day')->nullable();
            $table->string('special_day')->nullable();
            $table->json('photos')->nullable();
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
        Schema::dropIfExists('temple__besha');
    }
};
