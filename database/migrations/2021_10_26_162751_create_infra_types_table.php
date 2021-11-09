<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfraTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infra_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_code');
            $table->string('type_name');
            $table->string('sts_brand');
            $table->string('sts_function');
            $table->string('sts_application');
            $table->string('sts_serialnum');
            $table->string('sts_location');
            $table->date('sts_warranty');
            $table->string('sts_condition');
            $table->string('sts_description');
            $table->string('sts_ip');
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
        Schema::dropIfExists('infra_types');
    }
}
