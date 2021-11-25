<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_title');
            $table->string('content');

            // $table->bigInteger('table_id');
            $table->unsignedBigInteger('table_id');

            $table->bigInteger('user_id');
            $table->timestamps();

            $table->foreign('table_id')
                ->constrained()
                ->references('id')
                ->on('titles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
