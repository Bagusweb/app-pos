<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaction_details', function (Blueprint $table) {
            $table->increments('transaction_detail_id');
            $table->unsignedInteger('transaction_id'); // Transaksi terkait
            $table->unsignedInteger('product_id'); // Barang yang dibeli
            $table->integer('quantity'); // Jumlah barang
            $table->decimal('price', 10, 2); // Harga barang
            $table->timestamps();

            // Foreign key
            $table->foreign('transaction_id')->references('transaction_id')->on('tbl_transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('tbl_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transaction_details');
    }
}