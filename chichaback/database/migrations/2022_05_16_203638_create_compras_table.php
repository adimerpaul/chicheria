<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->integer('cantidad');
            $table->double('costo')->nullable();
//            $table->string('tipo');
            $table->date('fechaven')->nullable();
            $table->string('observacion')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('providers');
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
        Schema::dropIfExists('compras');
    }
}
