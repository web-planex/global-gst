<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_note_items', function (Blueprint $table) {
            $table->id();
            $table->integer('debit_note_id');
            $table->integer('product_id');
            $table->integer('tax_id')->nullable();
            $table->string('hsn_code',8)->nullable();
            $table->string('quantity',10);
            $table->string('rate',15);
            $table->string('amount',15);
            $table->string('discount',20)->nullable();
            $table->tinyInteger('discount_type')->nullable();
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
        Schema::dropIfExists('debit_note_items');
    }
}
