<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRumus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_rumus', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('start_range');
            $table->integer('end_range');
            $table->string('nilai');
            $table->string('metode', 50);
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
        Schema::dropIfExists('table_rumus');
    }
}
