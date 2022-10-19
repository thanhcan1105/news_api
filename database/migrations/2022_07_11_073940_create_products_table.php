<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',"255");
            $table->string('phone',"255");
            $table->string('select1',"255");
            $table->string('link',"255");
            $table->string('transaction_id',"255")->nullabe();
            $table->integer('reference_type')->default('8809');
            $table->integer('current_group_id')->default('1082');
            $table->string('source',"200")->default('3P_HFHR');
            $table->string('campaign',"200")->default('PTDT- API');
            $table->integer('reference_id')->nullabe();
            $table->string('str_source_group',"200")->default('fhr');
            $table->string('str_secondary_source',"200")->default('fhr');
            $table->integer('isdigital')->default('1');
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
        Schema::dropIfExists('products');
    }
}
