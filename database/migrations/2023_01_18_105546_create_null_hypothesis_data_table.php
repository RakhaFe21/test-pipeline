<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNullHypothesisDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('null_hypothesis_data', function (Blueprint $table) {
            $table->id();
            $table->string('null_hypothesis');
            $table->integer('group_id')->nullable();
            $table->double('obs')->nullable();
            $table->double('fStatic')->nullable();
            $table->double('prob')->nullable();
            $table->string('jenis');
            $table->unsignedBigInteger('id_negara')->nullable();
            $table->foreign('id_negara')->references('id')->on('negara_masters');
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
        Schema::dropIfExists('null_hypothesis_data');
    }
}
