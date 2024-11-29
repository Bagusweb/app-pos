<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->unsignedInteger('transaction_id'); // Transaksi terkait
            $table->unsignedInteger('user_id'); // Kasir atau admin yang memproses pembayaran
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->decimal('change', 15, 2)->nullable(); // Kembalian
            $table->string('payment_method'); // Metode pembayaran (misalnya: tunai, kartu)
            $table->date('payment_date'); // Tanggal pembayaran
            $table->timestamps();

            // Foreign key
            $table->foreign('transaction_id')->references('transaction_id')->
            on('tbl_transactions')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('tbl_users')->
            onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_payments');
    }
}