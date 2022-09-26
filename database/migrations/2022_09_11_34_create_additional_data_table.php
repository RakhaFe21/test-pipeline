<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negara_masters_id')->constrained()->onDelete('cascade');
            $table->string('name')->notNullable();
            $table->double('value')->notNullable();
            $table->string('jenis')->notNullable();
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
        Schema::dropIfExists('additional_data');
    }
}
