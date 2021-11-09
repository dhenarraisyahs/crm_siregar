<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfraDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infra_datas', function (Blueprint $table) {
            $table->id();
            $table->string('type_id');
            $table->string('status');
            $table->string('brand');
            $table->string('function');
            $table->string('application');
            $table->string('serialnum');
            $table->string('location');
            $table->date('warranty');
            $table->string('condition');
            $table->string('ip');
            $table->string('description');
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
        Schema::dropIfExists('infra_datas');
    }
}
