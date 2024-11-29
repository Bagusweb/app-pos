<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transactions;
use App\Products;

class TransactionDetails extends Model
{
    protected $table = 'tbl_transaction_details';
    protected $primaryKey = 'transaction_detail_id';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'total'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id', 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}