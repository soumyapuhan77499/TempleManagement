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
    Schema::create('temple__devotees', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone_number');
        $table->date('dob');
        $table->string('photo');
        $table->string('gotra');
        $table->string('rashi');
        $table->date('anniversary_date')->nullable();
        $table->text('address');
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
        Schema::dropIfExists('temple_devotees');
    }
};
