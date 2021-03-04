<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('tax_type')->comment('(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)');
            $table->integer('is_cess')->default(0);
            $table->integer('payee_id');
            $table->date('expense_date');
            $table->string('payment_method',50);
            $table->string('ref_no',50)->nullable();
            $table->integer('expense_category')->nullable();
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->string('total',20);
            $table->text('memo')->nullable();
            $table->text('files')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
