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
            $table->string('darshan_start_time');
            $table->string('darshan_start_period');
            $table->string('darshan_end_time');
            $table->string('darshan_end_period');
            $table->boolean('online_order')->default(false);
            $table->boolean('pre_order')->default(false);
            $table->boolean('offline_order')->default(false);
            $table->json('prasads'); // Storing prasad details in JSON format
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
