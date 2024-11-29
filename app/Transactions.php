<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Users;
use App\Customers;
use App\TransactionDetails;
use App\Payments;

class Transactions extends Model
{
    protected $table = 'tbl_transactions';
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
        'discount',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id', 'transaction_id');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'transaction_id', 'transaction_id');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'customer_id');
    }
}
