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
            $table->string('name');
            $table->string('image');
            $table->string('strength_and_size');
            $table->string('ndc');
            $table->string('upc_code');
            $table->string('imprint');
            $table->string('gpi_code');
            $table->string('dosage_form');
            $table->string('te_code');
            $table->string('brand_reference');
            $table->string('therapeutic_category');
            $table->string('pronunciation');
            $table->string('inactive_ingredients');
            $table->string('status');
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
