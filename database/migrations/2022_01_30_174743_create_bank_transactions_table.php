<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type',['payment','receipt','journal','contra']);
            $table->dateTime('transaction_date');
            $table->double('amount',10,2);
            $table->double('service_charge',10,2);
            $table->double('discount',10,2);
            $table->double('final_total',10,2);
            $table->string('invoice_number')->nullable();
            $table->integer('denomination_2000')->unsigned()->default(0);
            $table->integer('denomination_500')->unsigned()->default(0);
            $table->integer('denomination_200')->unsigned()->default(0);
            $table->integer('denomination_100')->unsigned()->default(0);
            $table->integer('denomination_50')->unsigned()->default(0);
            $table->integer('denomination_20')->unsigned()->default(0);
            $table->integer('denomination_10')->unsigned()->default(0);
            $table->integer('denomination_custom')->unsigned();
            $table->tinyInteger('status');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
}
