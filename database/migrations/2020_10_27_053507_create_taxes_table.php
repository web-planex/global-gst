<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->integer('id',1);
            $table->string('tax_name',15);
            $table->string('rate',10);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('taxes')->insert([
                'tax_name' => 'GST',
                'rate' => '6'
            ]
        );
        \Illuminate\Support\Facades\DB::table('taxes')->insert([
                'tax_name' => 'CGST',
                'rate' => '6'
            ]
        );
        \Illuminate\Support\Facades\DB::table('taxes')->insert([
                'tax_name' => 'SGST',
                'rate' => '18'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
