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
        Schema::create('temple__prasads', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id'); // assuming temple_id is a foreign key
            $table->string('prasad_name');
            $table->decimal('prasad_price', 8, 2);
            $table->time('darshan_start_time');
            $table->string('darshan_start_period'); // AM/PM
            $table->time('darshan_end_time');
            $table->string('darshan_end_period');   // AM/PM
            $table->boolean('online_order')->default(false);
            $table->boolean('pre_order')->default(false);
            $table->boolean('offline_order')->default(false);
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
        Schema::dropIfExists('temple_prasads');
    }
};
