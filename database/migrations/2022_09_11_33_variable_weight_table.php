<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VariableWeightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negara_masters_id')->constrained()->onDelete('cascade');
            $table->foreignId('variable_masters_id')->constrained()->onDelete('cascade');
            $table->double('weight')->nullable();
            $table->year('based_year')->nullable();
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
        Schema::dropIfExists('variable_weights');
    }
}
