<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariableDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negara_masters_id')->constrained()->onDelete('cascade');
            $table->foreignId('variable_masters_id')->constrained()->onDelete('cascade');
            $table->string('tahun');
            $table->string('bulan');
            $table->double('value');
            $table->double('value_index')->nullable();
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
        Schema::dropIfExists('variable_data');
    }
}
