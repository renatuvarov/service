<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('departure_point');
            $table->foreign('departure_point')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
            $table->unsignedBigInteger('arrival_point');
            $table->foreign('arrival_point')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
            $table->dateTime('date');
            $table->unsignedTinyInteger('seat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
