<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_partners', function (Blueprint $table) {
            $table->id();
            $table->string('referenceid');
            $table->string('f88note');
            $table->integer('statusf88');
            $table->integer('loanmoneyorg');
            $table->string('lastcomment');
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
        Schema::dropIfExists('return_partners');
    }
}
