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
        Schema::create('temple__committee_details', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id'); // assuming temple_id is a foreign key
            $table->string('committee_id');
            $table->string('committee_creation_date');
            $table->string('financial_period');
            $table->string('committee_end_date');
            $table->string('total_committee_day');
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
        Schema::dropIfExists('temple_committee');
    }
};
