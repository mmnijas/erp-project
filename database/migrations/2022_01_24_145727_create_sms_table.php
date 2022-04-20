<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->string('phone');
            $table->text('message');
            $table->string('sender_id');
            $table->string('template_id')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('response')->nullable();
            $table->integer('length')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('status')->comment();
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
        Schema::dropIfExists('sms');
    }
}
