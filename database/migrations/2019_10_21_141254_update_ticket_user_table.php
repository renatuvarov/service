<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTicketUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('patronymic', 100);
            $table->string('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('patronymic');
            $table->dropColumn('phone');
        });
    }
}
