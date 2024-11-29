<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transactions;
use App\Users;

class Payments extends Model
{
    protected $table = 'tbl_payments';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'change',
        'payment_method',
        'payment_date',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id', 'transaction_id');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}
