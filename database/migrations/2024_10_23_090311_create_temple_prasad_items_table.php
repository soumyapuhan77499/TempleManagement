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
        Schema::create('temple__prasad_items', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('temple_prasad_id');
            $table->string('prasad_name');
            $table->decimal('prasad_price', 8, 2);
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
        Schema::dropIfExists('temple_prasad_items');
    }
};
