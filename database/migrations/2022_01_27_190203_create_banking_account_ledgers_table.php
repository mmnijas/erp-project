<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankingAccountLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking_account_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('banking_account_group_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('code')->nullable();
            $table->double('opening_balance',10,2)->default(0);
            $table->char('opening_balance_dc')->default('D')->comment('D Debit balance, C for Credit Balance');
            $table->tinyInteger('visibility')->default(2)->comment('1 for active 2 for not');
            $table->tinyInteger('payment_account')->default(2)->comment('1 for payment account 2 for not');
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
        Schema::dropIfExists('banking_account_ledgers');
    }
}
