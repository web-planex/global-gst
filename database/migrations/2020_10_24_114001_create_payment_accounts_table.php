<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->integer('id',1);
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('account_type');
            $table->integer('detail_type');
            $table->string('name', 45);
            $table->text('description');
            $table->string('default_tax_code', 45);
            $table->string('balance', 45);
            $table->date('as_of');
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
        Schema::dropIfExists('payment_accounts');
    }
}
